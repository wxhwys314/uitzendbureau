<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employers extends Model
{
    protected $fillable = [
        'companyName',
        'companyAddress',
        'totalEmployees',
        'contactFirstName',
        'contactLastName',
        'contactPhone',
        'contactEmail',
    ];

    public function vacancies()
    {
        return $this->hasMany(Vacancies::class, 'employer_id');
    }
}
