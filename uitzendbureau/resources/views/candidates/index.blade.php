@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <div class="px-5">
        <div class="d-flex align-items-center gap-2 justify-content-between flex-wrap">
            <h1 class="mb-0">Kandidaten Lijst</h1>
            <a href="{{ route('candidates.create') }}" class="btn btn-primary mt-ms-0">Nieuwe Kandidaat</a>
        </div>
        <hr>

        @if ($candidates->isEmpty())
            <p>Er zijn nog geen kandidaten toegevoegd.</p>
        @else
            <table class="table table-sm table-hover">
                <thead class="table-secondary">
                    <tr>
                        <form method="GET" action="{{ route('candidates.index') }}" id="sort_form">
                            <input type="hidden" name="sort_column" id="sort_column" value="{{ $sortColumn }}">
                            <input type="hidden" name="sort_mode" id="sort_mode" value="{{ $sortMode }}">

                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('firstName')"><b id="firstName">Voornaam</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('lastName')"><b id="lastName">Achternaam</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('gender')"><b id="gender">Geslacht</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('BSNNumber')"><b id="BSNNumber">BSN Nummer</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('email')"><b id="email">E-mail</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('dateOfBirth')"><b id="dateOfBirth">Geboortedatum</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('expectedSalary')"><b id="expectedSalary">Gewenst Salaris (€)</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('educationstrainings')"><b id="educationstrainings">Opleidingen/Cursussen</b></button></th>
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort('skills')"><b id="skills">Skills</b></button></th>
                            <th scope="col">Acties</th>
                        </form>
                    </tr>
                </thead>
                <tbody>
                @foreach ($candidates as $candidate)
                    <tr>
                        <th scope="row">{{ $candidate->firstName }}</th>
                        <td>{{ $candidate->lastName }}</td>
                        <td>{{ $candidate->gender }}</td>
                        <td>{{ $candidate->BSNNumber }}</td>
                        <td>{{ $candidate->email }}</td>
                        <td>{{ $candidate->dateOfBirth }}</td>
                        <td>€{{ number_format($candidate->expectedSalary, 2, ',', '.') }}</td>
                        <td>
                            @if ($candidate->educationsTrainings->isNotEmpty())
                                <ul>
                                    @foreach ($candidate->educationsTrainings as $educationTraining)
                                        <li>{{ $educationTraining->education_training }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Geen opleidingen/cursussen</em>
                            @endif
                        </td>
                        <td>
                            @if ($candidate->skills->isNotEmpty())
                                <ul>
                                    @foreach ($candidate->skills as $skill)
                                        <li>{{ $skill->skill }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>Geen skills</em>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('candidates.edit', $candidate->id) }}" class="btn btn-warning btn-sm">Bewerken</a>
                            <a href="{{ route('candidates.show', $candidate->id) }}" class="btn btn-success btn-sm">details</a>
                            <!-- <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je deze kandidaat wilt verwijderen?')">
                                    Verwijderen
                                </button>
                            </form> -->
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal_{{ $candidate->id }}" data-target="#exampleModal">Verwijderen</button>

                            <!-- Modal -->
                            <div class="modal_{{ $candidate->id }} fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Waarschuwing!</h5>
                                    </div>
                                    <div class="modal-body">
                                        Weet je zeker dat je deze kandidaat wilt verwijderen?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

<script>
    // handle the sorting icon of the table based on the URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    if (window.location.search.includes('sort_column') && window.location.search.includes('sort_mode') && urlParams.get('sort_mode') !== 'default') {
        document.addEventListener("DOMContentLoaded", function () {
            const targetElement = document.getElementById(urlParams.get('sort_column'));
            switch (urlParams.get('sort_mode')) {
                case 'asc':
                    var d = "M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1"
                    break;
                case 'desc':
                    var d = "M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5"
                    break;
            }

            if (targetElement) {
                const svgElement = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svgElement.setAttribute("xmlns", "http://www.w3.org/2000/svg");
                svgElement.setAttribute("width", "16");
                svgElement.setAttribute("height", "16");
                svgElement.setAttribute("fill", "currentColor");
                svgElement.setAttribute("class", "bi bi-arrow-down");
                svgElement.setAttribute("viewBox", "0 0 16 16");

                const pathElement = document.createElementNS("http://www.w3.org/2000/svg", "path");
                pathElement.setAttribute("fill-rule", "evenodd");
                pathElement.setAttribute("d", d);

                svgElement.appendChild(pathElement);
                targetElement.insertAdjacentElement('afterend', svgElement);
            }
        });
    }

    function toggleSort(column) {
        const columnInput = document.getElementById('sort_column');
        const modeInput = document.getElementById('sort_mode');

        if (columnInput.value !== column) {
            columnInput.value = column;
            modeInput.value = 'asc';
        } else {
            if (modeInput.value === 'default') {
                modeInput.value = 'asc';
            } else if (modeInput.value === 'asc') {
                modeInput.value = 'desc';
            } else {
                modeInput.value = 'default';
            }
        }
        document.getElementById('sort_form').submit();
    }
</script>