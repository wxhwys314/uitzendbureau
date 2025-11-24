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
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('skill', 100);
            $table->timestamps();
        });

        //Initial Data:
        DB::table('skills')->insert([
            ['skill' => 'C#'],
            ['skill' => 'Java'],
            ['skill' => 'HTML5 (JavaScript, HTML en CSS)'],
            ['skill' => 'Frontend Developer'],
            ['skill' => 'Backend Developer'],
            ['skill' => 'Full Stack Developer'],
            ['skill' => 'Banketbakker'],
            ['skill' => 'Stratenmaker'],
            ['skill' => 'Loodgieter'],
            ['skill' => 'Automonteur'],
            ['skill' => 'C (programmeertaal)'],
            ['skill' => 'C++'],
            ['skill' => 'PHP'],
            ['skill' => 'Python']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
