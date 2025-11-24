<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'BSNNumber',
        'email',
        'dateOfBirth',
        'expectedSalary',
    ];

    public function educationsTrainings()
    {
        return $this->belongsToMany(EducationTraining::class, 'candidate_educations_trainings', 'candidate_id', 'education_training_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'candidate_skills', 'candidate_id', 'skill_id');
    }

    public function vacancies()
    {
        return $this->belongsToMany(Vacancies::class, 'candidates_vacancies', 'candidate_id', 'vacancy_id');
    }
    
}
