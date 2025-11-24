@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Nieuwe Vacature Toevoegen</h1>
        <br>
        <form action="{{ route('vacancies.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label class="form-label">Positie naam:</label>
                    <input type="text" name="jobTitle" class="form-control" required maxlength="50">
                    @error('jobTitle')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Beschrijving:</label>
                    <textarea name="jobDescription" class="form-control" required maxlength="200"></textarea>
                    @error('jobDescription')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label" for="employer_id">Werkgevers:</label>
                    <select name="employer_id" id="employer_id" class="form-select" required>
                        <option value="" disabled selected>Kies een optie</option>
                        @foreach($employers as $employer)
                            <option value="{{ $employer->id }}">{{ $employer->companyName }}</option>
                        @endforeach
                    </select>
                    @error('employer_id')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Salaris (€):</label>
                    <input type="number" step="0.01" name="salary" class="form-control" required min="0" max="99999999.99">
                    @error('salary')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">Skills:</label>
                    <select name="skills[]" class="form-select" multiple required>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->skill }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Houd de CTRL-toets ingedrukt om meerdere opties te selecteren.</small>
                    @error('skills')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <br>
            <button type="submit" class="save">Opslaan</button>
            <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>
        </form>
    </div>
@endsection
