<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\EducationTraining;
use App\Models\Skill;
use App\Models\Vacancies;
use Illuminate\Http\Request;

class CandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $candidates = Candidate::with(['educationsTrainings', 'skills'])->get();
        $educationsTrainings = EducationTraining::all();
        $skills = Skill::all();

        // Handle sorting
        $query = Candidate::query();
        $sortColumn = $request->get('sort_column', 'default');
        $sortMode = $request->get('sort_mode', 'default');

        if ($sortColumn === 'skills') {
            $query->withCount('skills');
            if ($sortMode !== 'default') {
                $query->orderBy('skills_count', $sortMode);
            }
        } elseif ($sortColumn === 'educationstrainings') {
            $query->withCount('educationstrainings');
            if ($sortMode !== 'default') {
                $query->orderBy('educationstrainings_count', $sortMode);
            }
        } elseif ($sortColumn !== 'default' && $sortMode !== 'default') {
            $query->orderBy($sortColumn, $sortMode);
        }

        $candidates = $query->get();

        return view('candidates.index', compact('candidates', 'educationsTrainings', 'skills', 'sortColumn', 'sortMode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($vacatureId = null)
    {
        $vacature = null;

        if ($vacatureId) {
            $vacature = Vacancies::findOrFail($vacatureId);
        }

        $candidates = Candidate::all();
        $educationsTrainings = EducationTraining::all();
        $skills = Skill::all();

        return view('candidates.create', compact('candidates', 'educationsTrainings', 'skills', 'vacature'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'gender' => 'required|in:man,vrouw,anders',
            'BSNNumber' => 'required|digits:9|unique:candidates,BSNNumber',
            'email' => 'required|email|max:100|unique:candidates,email',
            'dateOfBirth' => 'required|date|before:today',
            'expectedSalary' => 'required|numeric|min:0|max:99999999.99',

            'educationsTrainings' => 'required|array',
            'educationsTrainings.*' => 'exists:educations_trainings,id',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $candidate = Candidate::create([
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
            'gender' => $validated['gender'],
            'BSNNumber' => $validated['BSNNumber'],
            'email' => $validated['email'],
            'dateOfBirth' => $validated['dateOfBirth'],
            'expectedSalary' => $validated['expectedSalary'],
        ]);

        $candidate->educationsTrainings()->attach($validated['educationsTrainings']);
        $candidate->skills()->attach($validated['skills']);

        return redirect()->route('candidates.index')->with('success', 'Kandidaat succesvol aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        $appliedVacancies = $candidate->vacancies()->get();
        return view('candidates.show', compact('candidate', 'appliedVacancies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        $candidates = Candidate::all();
        $educationsTrainings = EducationTraining::all();
        $skills = Skill::all();
        return view('candidates.edit', compact('candidates', 'candidate', 'educationsTrainings', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'gender' => 'required|in:man,vrouw,anders',
            'BSNNumber' => 'required|digits:9|unique:candidates,BSNNumber,' . $candidate->id,
            'email' => 'required|email|max:100|unique:candidates,email,' . $candidate->id,
            'dateOfBirth' => 'required|date|before:today',
            'expectedSalary' => 'required|numeric|min:0|max:99999999.99',

            'educationsTrainings' => 'required|array',
            'educationsTrainings.*' => 'exists:educations_trainings,id',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $candidate->update([
            'firstName' => $validated['firstName'],
            'lastName' => $validated['lastName'],
            'gender' => $validated['gender'],
            'BSNNumber' => $validated['BSNNumber'],
            'email' => $validated['email'],
            'dateOfBirth' => $validated['dateOfBirth'],
            'expectedSalary' => $validated['expectedSalary'],
        ]);

        $candidate->educationsTrainings()->sync($validated['educationsTrainings']);
        $candidate->skills()->sync($validated['skills']);

        return redirect()->route('candidates.index')->with('success', 'Kandidaat succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Kandidaat succesvol verwijderd.');
    }
}
