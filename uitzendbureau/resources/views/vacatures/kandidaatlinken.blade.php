@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Koppel kandidaat aan vacature: <b>{{ $vacancy->jobTitle }}</b></h2>

    {{-- Koppelformulier --}}
    <form action="{{ route('vacancies.candidates.store', $vacancy->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="candidate_id" class="form-label">Selecteer een kandidaat</label>
            <select name="candidate_id" id="candidate_id" class="form-select">
                @foreach($candidates as $candidate)
                    <option value="{{ $candidate->id }}">{{ $candidate->firstName }} {{ $candidate->lastName }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Kandidaat koppelen</button>
    </form>

    {{-- Feedbackmelding --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Gekoppelde kandidaten --}}
    <div class="mt-5">
        <h4>Gekoppelde kandidaten:</h4>
        @if($vacancy->candidates->isEmpty())
            <p>Er zijn nog geen kandidaten gekoppeld.</p>
        @else
            <ul class="list-group">
                @foreach($vacancy->candidates as $candidate)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $candidate->firstName }} {{ $candidate->lastName }}
                        <form action="{{ route('vacancies.candidates.detach', [$vacancy->id, $candidate->id]) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze kandidaat wilt ontkoppelen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Ontkoppelen</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
