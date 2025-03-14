<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'phone' => $this->phone,
            'deposit' => $this->deposit,
            'staff_sign' => $this->staff_sign,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'planned_end_time' => $this->planned_end_time,
            'duration' => $this->duration,
            'total_amount' => $this->total_amount,
            'overtime_hours' => $this->overtime_hours,
            'overtime_charge' => $this->overtime_charge,
            'bikes' => BikeResource::collection($this->whenLoaded('bikes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}