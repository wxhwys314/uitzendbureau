<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationTraining extends Model
{
    protected $table = 'educations_trainings';
    protected $fillable = ['education_training'];

    public function candidates()
    {
        return $this->belongsToMany(Candidate::class, 'candidate_educations_trainings');
    }
}
