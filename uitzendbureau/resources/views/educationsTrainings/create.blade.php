@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Nieuwe Opleidingen/Cusurssen</h1>
        <br>
        <form action="{{ route('educationsTrainings.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Opleidingen/Cusurssen naam:</label>
                <input type="text" name="education_training" class="form-control" placeholder="Maximaal 255 tekens" required maxlength="255">
                @error('education_training')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <br>
            <button type="submit" class="save">Opslaan</button>
            <a href="{{ route('educationsTrainings.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>

        </form>
    </div>
@endsection
