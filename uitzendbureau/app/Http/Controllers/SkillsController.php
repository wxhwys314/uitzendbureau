<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\EducationTraining;
use App\Models\Skill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $skills = Skill::all();
        $candidateSkills = DB::table('candidate_skills')->get();
        $vacanciesSkills = DB::table('vacancies_skills')->get();

        // Handle sorting
        $query = Skill::query();
        $sortMode = $request->get('sort_mode', 'default');

        if ($sortMode !== 'default') {
            $query->orderBy('skill', $sortMode);
        }

        $skills = $query->get();

        return view('skills.index', compact('skills', 'candidateSkills', 'vacanciesSkills', 'sortMode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all();
        return view('skills.create', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill' => 'required|string|max:100'
        ]);        
    
        Skill::create($validated);
        return redirect()->route('skills.index')->with('success', 'Skills successfully created');////
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'skill' => 'required|string|max:100'
        ]);
    
        $skill->update($validated);
        return redirect()->route('skills.index')->with('success', 'Skills successfully updated.');//
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill, Request $request)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill successfully deleted.');
    }
}
