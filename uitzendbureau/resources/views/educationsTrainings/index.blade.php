@extends('layouts.app')

@section('content')
    <div class="px-5">
        <div class="d-flex align-items-center gap-2 justify-content-between flex-wrap">
            <h1 class="mb-0">Opleidingen/Cusurssen lijst</h1>
            <a href="{{ route('educationsTrainings.create') }}" class="btn btn-primary mt-ms-0">Nieuwe
                Opleidingen/Cusurssen</a>
        </div>
        <hr>

        @if ($educationsTrainings->isEmpty())
            <p>Er zijn nog geen Opleidingen/Cusurssen toegevoegd.</p>
        @else
            <table class="table table-sm table-hover">
                <thead class="table-secondary">
                    <tr>
                        <form method="GET" action="{{ route('educationsTrainings.index') }}" id="sort_form">
                            <input type="hidden" name="sort_mode" id="sort_mode" value="{{ $sortMode }}">
                            
                            <th scope="col"><button type="button" class="text_button" onclick="toggleSort()"><b id="educationsTrainings">Opleidingen/Cusurssen naam</b></button></th>
                            <th scope="col">Acties</th>
                        </form>
                    </tr>
                </thead>
                <tbody>
                @foreach ($educationsTrainings as $educationTraining)
                    <tr>
                        <th scope="row">{{ $educationTraining->education_training }}</th>
                        <td>
                            <a href="{{ route('educationsTrainings.edit', $educationTraining) }}" class="btn btn-warning btn-sm">Bewerken</a>
                            <form action="{{ route('educationsTrainings.destroy', $educationTraining) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirmDelete(event, '{{$educationTraining->id}}', '{{$educationTraining->education_training}}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Verwijderen</button>
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
    if (window.location.search.includes('sort_mode') && urlParams.get('sort_mode') !== 'default') {
        document.addEventListener("DOMContentLoaded", function () {
            const targetElement = document.getElementById('educationsTrainings');
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

    function toggleSort() {
        const modeInput = document.getElementById('sort_mode');

        if (modeInput.value === 'default') {
            modeInput.value = 'asc';
        } else if (modeInput.value === 'asc') {
            modeInput.value = 'desc';
        } else {
            modeInput.value = 'default';
        }

        document.getElementById('sort_form').submit();
    }

    //event listener for the delete confirmation
    const candidateEducationsTrainings = @json($candidateEducationsTrainings);

    function confirmDelete(event, selectedEduTraId, selectedEduTraName) {
        if (candidateEducationsTrainings.some(item => item.education_training_id == selectedEduTraId)) {
            var message = `Edu/Tra '${selectedEduTraName}' is momenteel gebruikt. Weet u zeker dat u deze edu/tra wilt verwijderen?'`
        } else {
            var message = `Weet u zeker dat u deze edu/tra wilt verwijderen?'`
        }

        if (!confirm(message)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>
