@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center mb-4">
            <h1 class="text-danger">{{$employer->companyName}}</h1>
            <a href="{{ route('employers.index') }}" class="btn btn-outline-secondary ms-auto">
                &larr; Terug naar overzicht
            </a>
        </div>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h4 class="mb-4"><b>Bedrijfsinformatie</b></h4>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Naam:</strong> {{ $employer->companyName }}</p>
                        <p><strong>Adres:</strong> {{ $employer->companyAddress }}</p>
                        <p><strong>Aantal Werknemers:</strong> {{ $employer->totalEmployees }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <strong>Contactpersoon:</strong> {{ $employer->contactFirstName }} {{ $employer->contactLastName }}
                        </p>
                        <p><strong>Email:</strong> {{ $employer->contactEmail }}</p>
                        <p><strong>Telefoon:</strong> {{ $employer->contactPhone }}</p>
                    </div>
                </div>
            </div>
        </div>

        <h3>Vacatures bij {{$employer->companyName}}</h3>

        <div class="auth_dashboard_content">
            @forelse($vacancies as $vacancy)
                @php
                    $daysAgo = $vacancy->created_at->diffForHumans();
                    $skills = $vacancy->skills()->get()
                @endphp
                <a href="{{ route('vacancies.show', $vacancy->id) }}">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="title" style="color: red"><b>{{ $vacancy->jobTitle }}</b>
                            </h4>
                            <h5><b>{{ $vacancy->employer->companyAddress }}</b>
                                • {{ $vacancy->employer->companyName }}
                                • {{ $vacancy->jobTitle }}</h5>
                            <span class="information_block">30 - 40 uur</span>
                            <span class="information_block">&euro; {{ $vacancy->salary }} p/m</span>
                            <span class="information_block">Ploegen</span>
                            <span class="information_block">Winstdeling</span>
                            <br>
                            @foreach($vacancy->skills()->get() as $skill)
                                <span class="information_block"
                                      style="background-color: #FFF0F0;">{{$skill->skill}}</span>
                            @endforeach
                            <div style="margin-top: 20px;">
                                <small
                                    class="small_text">{{ ($vacancy->created_at)->diffForHumans(new DateTime()) }}
                                    geleden</small>
                            </div>
                        </div>
                    </div>
                </a>
                <br>
            @empty
                <p class="text-center">Geen vacatures gevonden voor dit bedrijf.</p>
            @endforelse
        </div>
    </div>
@endsection
