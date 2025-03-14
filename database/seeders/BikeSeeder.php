<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bikes')->insert([
            [
                'name' => 'Bike-01',
                'class' => 'standard',
                'status' => 0,
                'rental_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bike-02',
                'class' => 'premium',
                'status' => 0,
                'rental_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Bike-03',
                'class' => 'standard',
                'status' => 0,
                'rental_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}