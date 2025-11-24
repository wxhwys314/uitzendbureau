<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CandidatesController;
use App\Http\Controllers\EducationsTrainingsController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\VacanciesController;
use App\Http\Controllers\EmployersController;

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('candidates', CandidatesController::class);
    Route::resource('educationsTrainings', EducationsTrainingsController::class);
    Route::resource('skills', SkillsController::class);
    Route::resource('vacancies', VacanciesController::class);
    Route::resource('employers', EmployersController::class);
    
});

Route::resource('home', HomeController::class);
Route::get('/vacancies/{vacancy}/kandidaatlinken', [VacanciesController::class, 'kandidaatLinken'])
    ->middleware('auth')
    ->name('vacatures.kandidaatlinken');
Route::post('/vacancies/{vacancy}/candidates', [VacanciesController::class, 'storeCandidate'])
    ->name('vacancies.candidates.store');
Route::resource('candidates', CandidatesController::class);


Route::post('/vacancies/{vacancy}/candidates', [VacanciesController::class, 'storeCandidate'])->name('vacancies.candidates.store');
Route::delete('/vacancies/{vacancy}/candidates/{candidate}', [VacanciesController::class, 'detachCandidate'])->name('vacancies.candidates.detach');





