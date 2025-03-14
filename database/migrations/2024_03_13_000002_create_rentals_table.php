<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->decimal('deposit', 10, 2);
            $table->string('staff_sign');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->dateTime('planned_end_time');
            $table->integer('duration');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->integer('overtime_hours')->default(0);
            $table->decimal('overtime_charge', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};