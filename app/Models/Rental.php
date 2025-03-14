<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rental extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'deposit',
        'staff_sign',
        'start_time',
        'end_time',
        'planned_end_time',
        'duration',
        'total_amount',
        'overtime_hours',
        'overtime_charge',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'planned_end_time' => 'datetime',
    ];

    public function bikes(): HasMany
    {
        return $this->hasMany(Bike::class);
    }

    public function isActive(): bool
    {
        return $this->end_time === null;
    }
}