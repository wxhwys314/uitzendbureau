@extends('layouts.app')

@section('content')
    <div class="px-5">
        <div class="d-flex align-items-center gap-2 justify-content-between flex-wrap">
            <h1 class="mb-0">Werkgever Lijst</h1>
            <a href="{{ route('employers.create') }}" class="btn btn-primary mt-ms-0">Nieuwe werkgever</a>
        </div>
        <hr>

        @if ($employers->isEmpty())
            <p>Er zijn nog geen werkgevers toegevoegd.</p>
        @else
            <table class="table table-sm table-hover">
                <thead class="table-secondary">
                <tr>
                    <form method="GET" action="{{ route('employers.index') }}" id="sort_form">
                        <input type="hidden" name="sort_column" id="sort_column" value="{{ $sortColumn }}">
                        <input type="hidden" name="sort_mode" id="sort_mode" value="{{ $sortMode }}">

                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('companyName')"><b id="companyName">Bedrijfsnaam</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('companyAddress')"><b id="companyAddress">Bedrijfsadres</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('totalEmployees')"><b id="totalEmployees">Werkenemersaantal</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('contactFirstName')"><b id="contactFirstName">Contactpersoon Voornaam</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('contactLastName')"><b id="contactLastName">Contactpersoon Achternaam</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('contactPhone')"><b id="contactPhone">Contactpersoon Telefoonnummer</b></button></th>
                        <th scope="col"><button type="button" class="text_button" onclick="toggleSort('contactEmail')"><b id="contactEmail">Contactpersoon E-mail</b></button></th>
                        <th scope="col">Acties</th>
                    </form>
                </tr>
                </thead>
                <tbody>
                @foreach ($employers as $employer)
                    <tr>
                        <th scope="row">{{ $employer->companyName }}</th>
                        <td>{{ $employer->companyAddress }}</td>
                        <td>{{ $employer->totalEmployees }}</td>
                        <td>{{ $employer->contactFirstName }}</td>
                        <td>{{ $employer->contactLastName }}</td>
                        <td>{{ $employer->contactPhone }}</td>
                        <td>{{ $employer->contactEmail }}</td>
                        <td>
                            <a href="{{ route('employers.edit', $employer->id) }}"
                               class="btn btn-warning btn-sm">Bewerken</a>
                            <a href="{{ route('employers.show', $employer->id) }}" class="btn btn-success btn-sm">details</a>
                            <form action="{{ route('employers.destroy', $employer->id) }}" method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Weet je zeker dat je deze werkgever wilt verwijderen?')">
                                    Verwijderen
                                </button>
                            </form>
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