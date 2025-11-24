<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\Vacancies;
use Illuminate\Support\Facades\DB; // <- HIER

class HomeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filteredSkills = $request->input('skills', []);
        $expectedSalary = $request->input('expectedSalary') ?? 0;
        $allSkills = Skill::all();

        $vacancies = Vacancies::with('employer')
            ->whereHas('skills', function ($query) use ($filteredSkills) {
                $query->whereIn('skill', $filteredSkills);
            }, '=', count($filteredSkills))
            ->where('Salary', '>=', $expectedSalary)
            ->get();

        $id = $request->query('vacancy');
        $selected_vacancy = Vacancies::find($id);
        if ($id == null) {
            $selected_vacancy = Vacancies::find(1);
        }

        $skillIds = DB::table('vacancies_skills')
                        ->where('vacancy_id', $id)
                        ->pluck('skill_id');

        $skills = DB::table('skills')
                    ->whereIn('id', $skillIds)
                    ->get();

        return view('home', compact('vacancies', 'selected_vacancy', 'skills', 'allSkills', 'filteredSkills'));
    }
}
