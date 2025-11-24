@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Opleidingen/Cusurssen Wijzigen</h1>
        <br>
        <form method="post" action="{{ route('educationsTrainings.update', $educationsTraining->id) }}">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label class="form-label">Opleidingen/Cusurssen naam:</label>
                <input type="text" class="form-control" name="education_training" value="{{$educationsTraining->education_training}}" placeholder="Maximaal 255 tekens" required maxlength="255"/>
                @error('education_training')
                    <div class="error_message">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <br>
            <button type="submit" class="save">Wijzigen</button>
            <a href="{{ route('educationsTrainings.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>
        </form>
    </div>
@endsection
