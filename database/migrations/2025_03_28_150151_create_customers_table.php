<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('age');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('occupation');
            $table->string('monthly_income'); // ใช้ string แทน decimal
            $table->string('educational_qualifications');
            $table->integer('family_size')->nullable();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('pin_code');
            $table->string('order_status');
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
