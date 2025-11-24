@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Nieuwe Kandidaat Toevoegen</h1>
        <br>
        <form action="{{ route('candidates.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Voornaam:</label>
                    <input type="text" name="firstName" class="form-control" required maxlength="50">
                    @error('firstName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-5">
                    <label class="form-label">Achternaam:</label>
                    <input type="text" name="lastName" class="form-control" required maxlength="50">
                    @error('lastName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <label class="form-label">Geslacht:</label>
                    <select name="gender" class="form-select" required>
                        <option value="" disabled selected>Kies een optie</option>
                        <option value="man">Man</option>
                        <option value="vrouw">Vrouw</option>
                        <option value="anders">Anders</option>
                    </select>
                    @error('gender')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">BSN Nummer:</label>
                    <input type="number" name="BSNNumber" class="form-control" id="BSNNumber" required min="100000000"
                           max="999999999" onkeyup="getBSNNrEmail()">
                    @error('BSNNumber')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">E-mail:</label>
                    <input type="email" name="email" class="form-control" id="email" required maxlength="100"
                           onkeyup="getBSNNrEmail()">
                    @error('email')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Geboortedatum:</label>
                    <input type="date" name="dateOfBirth" class="form-control" required max="<?php echo date('Y-m-d', strtotime('yesterday')); ?>">
                    @error('dateOfBirth')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Gewenst Salaris (€):</label>
                    <input type="number" step="0.01" name="expectedSalary" class="form-control" required min="0" max="99999999.99">
                    @error('expectedSalary')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label class="form-label">Opleidingen/Cursussen:</label>
                    <select name="educationsTrainings[]" class="form-select" multiple required>
                        @foreach ($educationsTrainings as $educationTraining)
                            <option
                                value="{{ $educationTraining->id }}">{{ $educationTraining->education_training }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Houd de CTRL-toets ingedrukt om meerdere opties te
                        selecteren.</small>
                    @error('educationsTrainings[]')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Skills:</label>
                    <select name="skills[]" class="form-select" multiple required>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}">{{ $skill->skill }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Houd de CTRL-toets ingedrukt om meerdere opties te
                        selecteren.</small>
                    @error('skills[]')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <br>
            <button type="submit" class="save">Opslaan</button>
            <a href="{{ route('candidates.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr; Terug naar
                overzicht</a>
        </form>
    </div>
@endsection

<script>
    var candidates = @json($candidates);
    var usedBSNNumbers = []
    var usedEmails = []

    candidates.forEach(candidate => {
        usedBSNNumbers.push(candidate.BSNNumber)
        usedEmails.push(candidate.email)
    });

    function getBSNNrEmail() {
        var BSNNumber = document.getElementById('BSNNumber').value
        var email = document.getElementById('email').value

        if (usedBSNNumbers.includes(Number(BSNNumber))) {
            alert("BSN number: '" + BSNNumber + "' bestaat al!")
            document.getElementById('BSNNumber').value = ""
        }
        if (usedEmails.includes(email)) {
            alert("Email: '" + email + "' bestaat al!")
            document.getElementById('email').value = ""
        }
    }
</script>
