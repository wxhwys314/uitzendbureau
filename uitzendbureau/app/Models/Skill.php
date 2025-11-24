<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['skill'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_skills');
    }

    public function vacancies()
    {
        return $this->belongsToMany(Vacancies::class, 'vacancies_skills');
    }
}
