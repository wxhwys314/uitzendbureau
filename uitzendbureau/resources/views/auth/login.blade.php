@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h1 class="form-title p-2"><strong>{{ __('Login') }}</strong></h1>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

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
                                           class="form-control @error('email') is-invalid @enderror login-input border-0"
                                           name="password"
                                           value="{{ old('password') }}" required autocomplete="password" autofocus
                                           placeholder="Wachtwoord">
                                </div>
                                <div class="d-flex justify-content-start ps-0">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-decoration-none"
                                           href="{{ route('password.request') }}">
                                            {{ __('Wachtwoord vergeten?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Herrinner mij') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-12 text-center mb-3">
                                    <button type="submit" class="btn btn-primary rounded-pill w-50">
                                        {{ __('Login') }}
                                    </button>

                                    <div style="min-height: 25px;">
                                        @error('email')
                                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <small>Nog geen account? </small>
                                    <a class="btn btn-link p-0 text-decoration-none"
                                       href="{{ route('register') }}">
                                        {{ __('Registreer nu!') }}
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
