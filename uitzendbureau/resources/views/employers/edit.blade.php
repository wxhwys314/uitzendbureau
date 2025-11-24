@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Werkgever Wijzigen</h1>
        <br>
        <form action="{{ route('employers.update', $employer->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col">
                    <label class="form-label">Bedrijfsnaam:</label>
                    <input type="text" name="companyName" class="form-control" required maxlength="50"
                           value="{{$employer->companyName}}">
                    @error('companyName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Bedrijfs adres:</label>
                    <input type="text" name="companyAddress" class="form-control" required maxlength="50"
                           value="{{$employer->companyAddress}}">
                    @error('companyAddress')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Aantal werknemers:</label>
                    <input type="number" name="totalEmployees" class="form-control" required max="999" min="0"
                           value="{{$employer->totalEmployees}}">
                    @error('totalEmployees')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">Contactpersoon Voornaam:</label>
                    <input type="text" name="contactFirstName" class="form-control" required maxlength="50"
                           value="{{$employer->contactFirstName}}">
                    @error('contactFirstName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Contactpersoon Achternaam:</label>
                    <input type="text" name="contactLastName" class="form-control" required maxlength="50"
                           value="{{$employer->contactLastName}}">
                    @error('contactLastName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">Contactpersoon Telefoonnummer:</label>
                    <input type="number" name="contactPhone" id="contactPhone" class="form-control" required maxlength="15"
                           value="{{$employer->contactPhone}}" onkeyup="getPhoneNrEmail()">
                    @error('contactPhone')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Contactpersoon E-mail:</label>
                    <input type="email" name="contactEmail" id="contactEmail" class="form-control" required maxlength="50"
                           value="{{$employer->contactEmail}}" onkeyup="getPhoneNrEmail()">
                    @error('contactEmail')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <br>
            <button type="submit" class="save">Wijzigen</button>
            <a href="{{ route('employers.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>
        </form>
    </div>
@endsection

<script>
    var employers = @json($employers);
    var currentEmployer = @json($employer);
    var usedPhoneNumbers = []
    var usedEmails = []    

    employers.forEach(employer => {
        if (employer.id !== currentEmployer.id) {
            usedPhoneNumbers.push(employer.contactPhone)
            usedEmails.push(employer.contactEmail)
        }
    });

    function getPhoneNrEmail() {
        var contactPhone = document.getElementById('contactPhone').value
        var contactEmail = document.getElementById('contactEmail').value
        console.log(usedPhoneNumbers)
        console.log(usedEmails)

        if (usedPhoneNumbers.includes(contactPhone)) {
            alert("ContactPhone: '" + contactPhone + "' bestaat al!")
            document.getElementById('contactPhone').value = ""
        }
        if (usedEmails.includes(contactEmail)) {
            alert("ContactEmail: '" + contactEmail + "' bestaat al!")
            document.getElementById('contactEmail').value = ""
        }
    }
</script>