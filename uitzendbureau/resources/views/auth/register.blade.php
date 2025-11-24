@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h1 class="form-title p-2"><strong>{{ __('Registreer') }}</strong></h1>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3 w-50 mx-auto">
                                <div
                                    class="bg-light d-flex justify-content-start align-items-center rounded py-2 shadow-sm">
                                    <i class="fa fa-user me-2"></i>
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror login-input pe-0 border-0"
                                           name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus
                                           placeholder="Naam">
                                </div>
                            </div>

                            <div class="row mb-3 w-50 mx-auto">
                                <div
                                    class="bg-light d-flex justify-content-start align-items-center rounded py-2 shadow-sm">
                                    <i class="fa fa-envelope me-2"></i>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror login-input pe-0 border-0"
                                           name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus
                                           placeholder="Email">
                                </div>
                            </div>

                            <div class="row mb-3 w-50 mx-auto">
                                <div
                                    class="bg-light d-flex justify-content-start align-items-center rounded py-2 shadow-sm">
                                    <i class="fa fa-lock me-2"></i>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror login-input pe-0 border-0"
                                           name="password" required autocomplete="new-password" autofocus
                                           placeholder="Wachtwoord">
                                </div>
                            </div>

                            <div class="row mb-3 w-50 mx-auto">
                                <div
                                    class="bg-light d-flex justify-content-start align-items-center rounded py-2 shadow-sm">
                                    <i class="fa fa-unlock me-2"></i>
                                    <input id="password-confirm" type="password"
                                           class="form-control login-input pe-0 border-0"
                                           name="password_confirmation"
                                           required autocomplete="new-password"
                                           placeholder="Bevestig Wachtwoord">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 text-center mb-3">
                                    <button type="submit" class="btn btn-primary rounded-pill w-50">
                                        {{ __('Registreer') }}
                                    </button>

                                    <div style="min-height: 25px;">
                                        @if ($errors->any())
                                            <div class="mt-2">
                                                <ul class="list-unstyled text-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <li><small><strong>{{ $error }}</strong></small></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <small>Heeft u al een account? </small>
                                    <a class="btn btn-link p-0 text-decoration-none"
                                       href="{{ route('login') }}">
                                        {{ __('Log hier in!') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
