@extends('layouts.app')

@section('content')
    <div class="input_content">
        <h1 class="form-title">Nieuwe Werkgever Toevoegen</h1>
        <br>
        <form action="{{ route('employers.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <label class="form-label">Bedrijfsnaam:</label>
                    <input type="text" name="companyName" class="form-control" required maxlength="50">
                    @error('companyName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Bedrijfs adres:</label>
                    <input type="text" name="companyAddress" class="form-control" required maxlength="50">
                    @error('companyAddress')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Aantal werknemers:</label>
                    <input type="number" name="totalEmployees" class="form-control" required max="999" min="0">
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
                    <input type="text" name="contactFirstName" class="form-control" required maxlength="50">
                    @error('contactFirstName')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Contactpersoon Achternaam:</label>
                    <input type="text" name="contactLastName" class="form-control" required maxlength="50">
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
                    <input type="number" name="contactPhone" id="contactPhone" class="form-control" required maxlength="15" onkeyup="getPhoneNrEmail()">
                    @error('contactPhone')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label">Contactpersoon E-mail:</label>
                    <input type="email" name="contactEmail" id="contactEmail" class="form-control" required maxlength="50" onkeyup="getPhoneNrEmail()">
                    @error('contactEmail')
                        <div class="error_message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <br>
            <button type="submit" class="save">Opslaan</button>
            <a href="{{ route('employers.index') }}" class="btn btn-outline-secondary w-100 mt-2"> &larr;
                Terug naar overzicht</a>

        </form>
    </div>
@endsection

<script>
    var employers = @json($employers);
    var usedPhoneNumbers = []
    var usedEmails = []    

    employers.forEach(employer => {
        usedPhoneNumbers.push(employer.contactPhone)
        usedEmails.push(employer.contactEmail)
    });

    function getPhoneNrEmail() {
        var contactPhone = document.getElementById('contactPhone').value
        var contactEmail = document.getElementById('contactEmail').value

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