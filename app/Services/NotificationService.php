<?php

namespace App\Services;

use App\Models\Rental;
use Illuminate\Support\Facades\Http;

class NotificationService
{
    public function sendRentalNotification(Rental $rental): bool
    {
        $message = "🆕 New Rental #{$rental->id}\n" .
                  "👤 Customer: {$rental->customer_name}\n" .
                  "📱 Phone: {$rental->phone}\n" .
                  "🚲 Bikes: " . $rental->bikes->pluck('name')->implode(', ') . "\n" .
                  "💰 Deposit: {$rental->deposit}₽";

        return $this->sendTelegramMessage($message);
    }

    public function sendReturnNotification(Rental $rental): bool
    {
        $message = "✅ Return #{$rental->id}\n" .
                  "⏱ Duration: {$rental->overtime_hours}h\n" .
                  "💰 Total: {$rental->total_amount}₽";

        if ($rental->overtime_hours > 0) {
            $message .= "\n⚠️ Overtime: {$rental->overtime_hours}h";
        }

        return $this->sendTelegramMessage($message);
    }

    private function sendTelegramMessage(string $text): bool
    {
        try {
            $response = Http::post("https://api.telegram.org/bot" . config('services.telegram.token') . "/sendMessage", [
                'chat_id' => config('services.telegram.chat_id'),
                'text' => $text,
                'parse_mode' => 'HTML',
            