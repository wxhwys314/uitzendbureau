<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\EducationTraining;
use App\Models\Skill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EducationsTrainingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $educationsTrainings = EducationTraining::all();
        $candidateEducationsTrainings = DB::table('candidate_educations_trainings')->get();

        // Handle sorting
        $query = EducationTraining::query();
        $sortMode = $request->get('sort_mode', 'default');

        if ($sortMode !== 'default') {
            $query->orderBy('education_training', $sortMode);
        }

        $educationsTrainings = $query->get();

        return view('educationsTrainings.index', compact('educationsTrainings', 'candidateEducationsTrainings', 'sortMode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $educationsTrainings = EducationTraining::all();
        return view('educationsTrainings.create', compact('educationsTrainings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'education_training' => 'required|string|max:255'
        ]);        
    
        EducationTraining::create($validated);
        return redirect()->route('educationsTrainings.index')->with('success', 'Education/Training successfully created');////////////////
    }

    /**
     * Display the specified resource.
     */
    public function show(EducationTraining $educationsTraining)
    {
        return view('educationsTrainings.show', compact('educationsTraining'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationTraining $educationsTraining)
    {
        return view('educationsTrainings.edit', compact('educationsTraining'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationTraining $educationsTraining)
    {
        $validated = $request->validate([
            'education_training' => 'required|string|max:255',
        ]);

        $educationsTraining->update($validated);
        return redirect()->route('educationsTrainings.index')->with('success', 'Education/Training successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationTraining $educationsTraining, Request $request)
    {
        $educationsTraining->delete();
        return redirect()->route('educationsTrainings.index')->with('success', 'Education/Training successfully deleted.');////////////////
    }
}
