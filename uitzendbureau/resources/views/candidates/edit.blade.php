@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Kandidaat Wijzigen</h1>
        <br>
        <form method="post" action="{{ route('candidates.update', $candidate->id) }}">
            @csrf
            @method('PATCH')

            <div class="row">
                <div class="col">
                    <label class="form-label">Voornaam:</label>
                    <input type="text" class="form-control" name="firstName" value="{{ $candidate->firstName }}"
                           maxlength="50" required>
                    @error('firstName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Achternaam:</label>
                    <input type="text" class="form-control" name="lastName" value="{{ $candidate->lastName }}"
                           maxlength="50" required>
                    @error('Achternaam')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Geslacht:</label>
                    <select class="form-select" name="gender" required>
                        <option value="man" {{ $candidate->gender == 'man' ? 'selected' : '' }}>Man</option>
                        <option value="vrouw" {{ $candidate->gender == 'vrouw' ? 'selected' : '' }}>Vrouw</option>
                        <option value="anders" {{ $candidate->gender == 'anders' ? 'selected' : '' }}>Anders</option>
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
                    <input type="number" class="form-control" name="BSNNumber" id="BSNNumber"
                           value="{{ $candidate->BSNNumber }}" min="100000000" max="999999999" required
                           onkeyup="getBSNNrEmail()">
                    @error('BSNNumber')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">E-mail:</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $candidate->email }}"
                           maxlength="100" required onkeyup="getBSNNrEmail()">
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
                    <input type="date" class="form-control" name="dateOfBirth" value="{{ $candidate->dateOfBirth }}"
                           required max="<?php echo date('Y-m-d', strtotime('yesterday')); ?>">
                    @error('dateOfBirth')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Gewenst Salaris (€):</label>
                    <input type="number" class="form-control" name="expectedSalary"
                           value="{{ $candidate->expectedSalary }}"
                           step="0.01" min="0" required max="99999999.99">
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
                            <option value="{{ $educationTraining->id }}"
                                {{ in_array($educationTraining->id, $candidate->educationsTrainings->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $educationTraining->education_training }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Houd de CTRL-toets ingedrukt om meerdere opties te
                        selecteren.</small>
                    @error('educationsTrainings')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Skills:</label>
                    <select name="skills[]" class="form-select" multiple required>
                        @foreach ($skills as $skill)
                            <option value="{{ $skill->id }}"
                                {{ in_array($skill->id, $candidate->skills->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $skill->skill }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Houd de CTRL-toets ingedrukt om meerdere opties te
                        selecteren.</small>
                    @error('skills')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <br>
            <button type="submit" class="save">Wijzigen</button>
            <a href="{{ route('candidates.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr; Terug naar
                overzicht</a>
        </form>
    </div>
@endsection

<script>
    var candidates = @json($candidates);
    var currentCandidate = @json($candidate);
    var usedBSNNumbers = []
    var usedEmails = []

    candidates.forEach(candidate => {
        if (candidate.id !== currentCandidate.id) {
            usedBSNNumbers.push(candidate.BSNNumber);
            usedEmails.push(candidate.email);
        }
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
