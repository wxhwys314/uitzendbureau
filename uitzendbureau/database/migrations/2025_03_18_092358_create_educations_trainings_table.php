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
        Schema::create('educations_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('education_training', 255);
            $table->timestamps();
        });

        //Initial Data:
        DB::table('educations_trainings')->insert([
            ['education_training' => 'Bachelor in Information Technology'],
            ['education_training' => 'Master in Computer Science'],
            ['education_training' => 'Software Development'],
            ['education_training' => 'Cybersecurity Basics'],
            ['education_training' => 'Data Analytics and Visualization'],
            ['education_training' => 'Bachelor in Business Administration'],
            ['education_training' => 'Project Management Professional - PMP'],
            ['education_training' => 'Bachelor of Nursing'],
            ['education_training' => 'Master in Pharmacy'],
            ['education_training' => 'First Aid and CPR Certification'],
            ['education_training' => 'Bachelor in Graphic Design'],
            ['education_training' => 'User Experience Design - UX'],
            ['education_training' => 'Bachelor in Marketing'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations_trainings');
    }
};
