@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h1 class="form-title p-2"><strong>{{ __('Reset Wachtwoord') }}</strong></h1>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.email') }}">
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

                            <div class="col-md-12 text-center mb-3 d-flex flex-column justify-content-center align-items-center">
                                <button type="submit" class="btn btn-primary rounded-pill w-50">
                                    {{ __('Stuur Wachtwoord Reset Link') }}
                                </button>
                                <a href="{{ route('login') }}" class="btn text-decoration-none">{{ __('Terug naar Login') }}</a>

                                <div style="min-height: 25px;">
                                    @error('email')
                                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                                    @enderror
                                </div>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
