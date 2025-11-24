@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center ">
            <h2>{{$candidate->firstName}} {{$candidate->lastName}}</h2>
            <div class="d-flex align-items-center gap-2 ms-auto">
                <button id="printButton" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                <a href="{{ route('candidates.index') }}" class="btn btn-outline-secondary ms-auto">
                    &larr; Terug naar overzicht
                </a>
            </div>
        </div>

        <div id="printSection" class="px-5 py-4 d-flex justify-content-center ">
            <div class="border p-4 mt-3 w-100" style="background: #fff;">
                <h3 class="text-center mb-4">Candidate Information</h3>
                <p><strong>Naam:</strong> {{ $candidate->firstName }} {{ $candidate->lastName }}</p>
                <p><strong>Geslacht: </strong> {{$candidate->gender}}</p>
                <p><strong>BSN: </strong> {{$candidate->BSNNumber}}</p>
                <p><strong>Email:</strong> <a href="mailto:{{$candidate->email}}"
                                              class="text-dark text-decoration-none">{{ $candidate->email }}</a></p>
                <p><strong>Geboortedatum:</strong> {{ $candidate->dateOfBirth }}</p>
                <p><strong>Verwacht salaris:</strong> €{{ $candidate->expectedSalary }}</p>
                <div><strong>Gesolliciteerde vacatures:</strong>
                    <div>
                        @if($appliedVacancies->count() > 0)
                            <ul class="list-group">
                                @foreach($appliedVacancies as $vacancy)
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <a href="{{ route('vacancies.show', $vacancy->id) }}"
                                               class="text-dark text-decoration-none"><strong>{{ $vacancy->jobTitle }}</strong></a>
                                            <a href="{{ route('employers.show', $vacancy->employer->id) }}"
                                               class="text-dark text-decoration-none"><strong>{{ $vacancy->employer->companyName}}</strong></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="list-group">
                                <li class="list-group-item">
                                    De kandidaat heeft nog niet gesolliciteerd op vacatures.
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    window.addEventListener('load', function () {
        const printButton = document.getElementById('printButton');
        const printSection = document.getElementById('printSection').cloneNode(true);
        const originalContent = document.body.innerHTML;

        printButton.addEventListener('click', function () {
            document.body.innerHTML = printSection.outerHTML;
            window.print();
            document.body.innerHTML = originalContent;
            window.location.reload();
        });
    });
</script>

