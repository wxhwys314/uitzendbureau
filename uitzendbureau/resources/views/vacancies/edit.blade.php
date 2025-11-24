@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Vacaturen Wijzigen</h1>
        <br>
        <form method='post' action="{{ route('vacancies.update', $vacancy->id) }}">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col">
                    <label class="form-label">Positie naam:</label>
                    <input type="text" name="jobTitle" class="form-control" required maxlength="50"
                           value="{{$vacancy->jobTitle}}">
                    @error('jobTitle')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Beschrijving:</label>
                    <textarea name="jobDescription" class="form-control"
                              required  maxlength="200">{{$vacancy->jobDescription}}</textarea>
                    @error('jobDescription')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="employer_id" class="form-label">Werkgevers:</label>
                    <select name="employer_id" id="employer_id" class="form-select">
                        @foreach($employers as $employer)
                            <option
                                value="{{ $employer->id }}" @selected($vacancy->employer_id == $employer->id)>{{ $employer->companyName }}
                            </option>
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
                    <input type="number" step="0.01" name="salary" class="form-control" required min="0"
                           max="99999999.99" value="{{$vacancy->salary}}">
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
                            <option value="{{ $skill->id }}"
                                {{ in_array($skill->id, $vacancy->skills->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $skill->skill }}
                            </option>
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
            <button type="submit" class="save">Wijzigen</button>
            <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>
        </form>
    </div>
@endsection
