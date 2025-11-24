@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Skill Wijzigen</h1>
        <br>
        <form method="post" action="{{ route('skills.update', $skill->id) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Skill naam:</label>
                <input type="text" class="form-control" name="skill" value="{{$skill->skill}}" placeholder="Maximaal 100 tekens" required maxlength="100"/>
                @error('skill')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <br>
            <button type="submit" class="save">Wijzigen</button>
            <a href="{{ route('skills.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>
        </form>
    </div>
@endsection
