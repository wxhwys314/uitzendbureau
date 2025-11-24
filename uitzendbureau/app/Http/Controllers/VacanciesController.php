<?php

namespace App\Http\Controllers;

use App\Models\Employers;
use App\Models\Skill;
use App\Models\Vacancies;
use Illuminate\Http\Request;
use App\Models\Candidate;

class VacanciesController extends Controller
{
    public function index(Request $request)
    {
        $sortColumn = $request->get('sort_column', 'default');
        $sortMode = $request->get('sort_mode', 'default');
        $query = Vacancies::query();

        if ($sortColumn === 'skills') {
            $query->withCount('skills');
            if ($sortMode !== 'default') {
                $query->orderBy('skills_count', $sortMode);
            }
        } elseif ($sortColumn === 'employer_id' && $sortMode !== 'default') {
            $query->join('employers', 'vacancies.employer_id', '=', 'employers.id')
                  ->orderBy('employers.companyName', $sortMode)
                  ->select('vacancies.*');
        } elseif ($sortColumn !== 'default' && $sortMode !== 'default') {
            $query->orderBy($sortColumn, $sortMode);
        }

        $vacancies = $query->get();
        return view('vacancies.index', compact('vacancies', 'sortColumn', 'sortMode'));
    }

    public function create()
    {
        $employers = Employers::all();
        $skills = Skill::all();
        return view('vacancies.create', compact('employers', 'skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jobTitle' => 'required|string|max:50',
            'jobDescription' => 'required|string|max:200',
            'salary' => 'required|numeric|min:0|max:99999999.99',
            'employer_id' => 'required|exists:employers,id',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $vacancy = Vacancies::create([
            'jobTitle' => $validated['jobTitle'],
            'jobDescription' => $validated['jobDescription'],
            'salary' => $validated['salary'],
            'employer_id' => $validated['employer_id'],
        ]);

        $vacancy->skills()->attach($validated['skills']);
        return redirect()->route('vacancies.index')->with('success', 'Vacature succesvol aangemaakt!');
    }

    public function show(Vacancies $vacancy)
    {
        $candidates = $vacancy->candidates()->get();
        $employer = $vacancy->employer()->first();
        return view('vacancies.show', compact('vacancy', 'candidates', 'employer'));
    }

    public function edit(Vacancies $vacancy)
    {
        $employers = Employers::all();
        $skills = Skill::all();
        return view('vacancies.edit', compact('vacancy', 'employers', 'skills'));
    }

    public function update(Request $request, Vacancies $vacancy)
    {
        $validated = $request->validate([
            'jobTitle' => 'required|string|max:50',
            'jobDescription' => 'required|string|max:200',
            'salary' => 'required|numeric|min:0|max:99999999.99',
            'employer_id' => 'required|exists:employers,id',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $vacancy->update($validated);
        $vacancy->skills()->sync($validated['skills']);

        return redirect()->route('vacancies.index')->with('success', 'Vacature succesvol bijgewerkt!');
    }

    public function destroy(Vacancies $vacancy)
    {
        $vacancy->delete();
        return redirect()->route('vacancies.index')->with('success', 'Vacature succesvol verwijderd!');
    }

    public function kandidaatLinken($id)
    {
        $vacancy = Vacancies::with('candidates')->findOrFail($id);
        $candidates = Candidate::all();
        return view('vacatures.kandidaatlinken', compact('vacancy', 'candidates'));
    }

    public function storeCandidate(Request $request, Vacancies $vacancy)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $vacancy->load('candidates');

        if (!$vacancy->candidates->contains($request->candidate_id)) {
            $vacancy->candidates()->attach($request->candidate_id);
        }

        return redirect()->back()->with('success', 'Kandidaat succesvol gekoppeld aan de vacature.');
    }
    public function detachCandidate($vacancyId, $candidateId)
    {
        $vacancy = Vacancies::findOrFail($vacancyId);
        $vacancy->candidates()->detach($candidateId);

        return back()->with('success', 'Kandidaat succesvol ontkoppeld van vacature.');
    }

}
