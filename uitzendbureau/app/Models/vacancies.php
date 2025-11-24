<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Vacancies extends Model
{
    protected $fillable = [
        'jobTitle',
        'jobDescription',
        'employer_id',
        'salary'
    ];

    public function employer()
    {
        return $this->belongsTo(Employers::class, 'employer_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'vacancies_skills', 'vacancy_id', 'skill_id');
    }

    public function candidate()
    {
        return $this->belongsToMany(Candidate::class, 'candidates_vacancies', 'vacancy_id', 'candidate_id');
    }
    public function candidates()
    {
        return $this->belongsToMany(\App\Models\Candidate::class, 'candidates_vacancies', 'vacancy_id', 'candidate_id');
    }

}
