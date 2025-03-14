<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bike extends Model
{
    protected $fillable = [
        'name',
        'class',
        'status',
        'rental_id',
    ];

    const STATUS_AVAILABLE = 0;
    const STATUS_RENTED = 1;
    const STATUS_MAINTENANCE = 2;

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }
}