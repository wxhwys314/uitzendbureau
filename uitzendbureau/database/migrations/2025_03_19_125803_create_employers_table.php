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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('companyName', 50);
            $table->string('companyAddress', 50);
            $table->integer('totalEmployees');
            $table->string('contactFirstName', 50);
            $table->string('contactLastName', 50);
            $table->string('contactPhone', 15)->unique();
            $table->string('contactEmail', 50)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employers');
    }
};
