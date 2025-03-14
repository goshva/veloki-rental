<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRentalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'bike_ids' => ['required', 'array', 'min:1'],
            'bike_ids.*' => ['required', 'exists:bikes,id'],
            'deposit' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1', 'max:24'],
        ];
    }
}