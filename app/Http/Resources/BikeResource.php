<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BikeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'class' => $this->class,
            'status' => $this->status,
            'rental_id' => $this->rental_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}