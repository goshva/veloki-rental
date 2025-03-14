<?php

namespace App\Services;

use App\Models\Bike;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RentalService
{
    public function __construct(
        private NotificationService $notificationService
    ) {}

    public function createRental(array $data): Rental
    {
        return DB::transaction(function () use ($data) {
            // Validate bikes availability
            $bikes = Bike::whereIn('id', $data['bike_ids'])
                        ->where('status', Bike::STATUS_AVAILABLE)
                        ->get();

            if ($bikes->count() !== count($data['bike_ids'])) {
                throw new \Exception('Some bikes are not available');
            }

            // Calculate planned end time
            $startTime = Carbon::now();
            $plannedEndTime = $this->calculatePlannedEndTime($startTime, $data['duration']);

            // Create rental
            $rental = Rental::create([
                'customer_name' => $data['customer_name'],
                'phone' => $data['phone'],
                'deposit' => $data['deposit'],
                'staff_sign' => auth()->user()->name ?? 'system',
                'start_time' => $startTime,
                'planned_end_time' => $plannedEndTime,
                'duration' => $data['duration'],
            ]);

            // Update bikes status
            $bikes->each->update([
                'status' => Bike::STATUS_RENTED,
                'rental_id' => $rental->id,
            ]);

            // Send notification
            $this->notificationService->sendRentalNotification($rental);

            return $rental->load('bikes');
        });
    }

    public function completeRental(Rental $rental): array
    {
        return DB::transaction(function () use ($rental) {
            if (!$rental->isActive()) {
                throw new \Exception('Rental is already completed');
            }

            $now = Carbon::now();
            $hoursElapsed = $rental->start_time->diffInHours($now, true);
            $overtimeHours = max(0, $hoursElapsed - $rental->duration);
            
            $baseCharge = $this->calculateBaseCharge($rental->duration);
            $overtimeCharge = $overtimeHours * config('rental.price_1h');
            $totalAmount = $baseCharge + $overtimeCharge;

            // Update rental
            $rental->update([
                'end_time' => $now,
                'total_amount' => $totalAmount,
                'overtime_hours' => $overtimeHours,
                'overtime_charge' => $overtimeCharge,
            ]);

            // Free up bikes
            $rental->bikes()->update([
                'status' => Bike::STATUS_AVAILABLE,
                'rental_id' => null,
            ]);

            // Send notification
            $this->notificationService->sendReturnNotification($rental);

            return [
                'hours' => $hoursElapsed,
                'overtime' => $overtimeHours,
                'total' => $totalAmount,
                'deposit' => $rental->deposit,
                'balance_due' => $totalAmount - $rental->deposit,
            ];
        });
    }

    private function calculatePlannedEndTime(Carbon $start, int $duration): Carbon
    {
        $planned = $start->copy()->addHours($duration);
        $workEnd = Carbon::parse($start->format('Y-m-d ') . config('rental.work_end_time'));
        
        return $planned->gt($workEnd) ? $workEnd : $planned;
    }

    private function calculateBaseCharge(int $duration): float
    {
        return match(true) {
            $duration <= 1 => config('rental.price_1h'),
            $duration <= 2 => config('rental.price_2h'),
            default => config('rental.price_24h'),
        };
    }
}