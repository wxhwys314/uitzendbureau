@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center mb-4">
            <h1 class="text-danger">{{ $vacancy->jobTitle }}</h1>
            <a href="{{ route('vacancies.index') }}" class="btn btn-outline-secondary ms-auto">
                &larr; Terug naar overzicht
            </a>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h4 class="mb-4"><b>Vacature Informatie</b></h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h5><strong>Bedrijf:</strong>
                        <a href="{{ route('employers.show', $employer->id) }}" class="fw-bold text-decoration-none">
                            {{ $employer->companyName }}
                        </a>
                        </h5>
                        <p class="text-muted mt-2">{{ $vacancy->description }}</p>

                        <p><strong>Adres:</strong> {{ $employer->companyAddress }}</p>
                        <p><strong>Salaris:</strong> <span class="text-success">€{{ $vacancy->salary }}</span> / maand</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Beschrijving van de functie:</strong></p>
                        <p class="text-muted">{{ $vacancy->jobDescription }}</p>

                        @php $skills = $vacancy->skills()->get() @endphp
                        <p><strong>Benodigde Skills:</strong></p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($skills as $skill)
                                <span class="badge bg-light text-dark border">{{ $skill->skill }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4"><b>Kandidaten Ingeschreven</b></h4>
                @if($candidates->count() > 0)
                    <div class="list-group">
                        @foreach($candidates as $candidate)
                            <a href="{{ route('candidates.show', $candidate->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>
                                    <strong>{{ $candidate->firstName }} {{ $candidate->lastName }}</strong>
                                </span>
                                <span class="text-muted">{{ $candidate->email }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Er zijn nog geen kandidaten ingeschreven voor deze vacature.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
