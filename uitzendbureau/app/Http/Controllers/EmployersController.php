<?php

namespace App\Http\Controllers;

use App\Models\employers;
use App\Models\Vacancies;
use Illuminate\Http\Request;

class EmployersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employers = employers::all();

        // Handle sorting
        $query = employers::query();
        $sortColumn = $request->get('sort_column', 'default');
        $sortMode = $request->get('sort_mode', 'default');

        if ($sortColumn !== 'default' && $sortMode !== 'default') {
            $query->orderBy($sortColumn, $sortMode);
        }

        $employers = $query->get();

        return view('employers.index', compact('employers', 'sortColumn', 'sortMode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employers = employers::all();
        return view('employers.create', compact('employers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'companyName' => 'required|string|max:50',
            'companyAddress' => 'required|string|max:100',
            'totalEmployees' => 'required|integer|min:0|max:999',
            'contactFirstName' => 'required|string|max:25',
            'contactLastName' => 'required|string|max:25',
            'contactPhone' => 'required|numeric',
            'contactEmail' => 'required|email|max:50',
        ]);

        Employers::Create($validate);
        return redirect()->route('employers.index')->with('success', 'Employer successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(employers $employer)
    {
        $vacancies = $employer->vacancies()->get();
        return view('employers.show', compact('employer', 'vacancies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(employers $employer)
    {
        $employers = employers::all();
        return view('employers.edit', compact('employer', 'employers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, employers $employer)
    {
        $validate = $request->validate([
            'companyName' => 'required|string|max:50',
            'companyAddress' => 'required|string|max:100',
            'totalEmployees' => 'required|integer|min:0|max:999',
            'contactFirstName' => 'required|string|max:25',
            'contactLastName' => 'required|string|max:25',
            'contactPhone' => 'required|numeric',
            'contactEmail' => 'required|email|max:50',
        ]);

       $employer->update($validate);
        return redirect()->route('employers.index')->with('success', 'Employer successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(employers $employer)
    {
        $employer->delete();
        return redirect()->route('employers.index')->with('success', 'Employer successfully deleted!');
    }
}
