@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-between pl-3 align-items-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5 text-center">
                <h1 class="text-left">CCompanion</h1>
                <h3 class="text-left text-secondary">A Partner</h3>
                <img src="{{ asset('images/student.svg') }}" style="height: 100%; width: 80%;">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                <div class="card py-5" style="height: 71vh;">
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <div class="row mb-5 text-right">
                                <label for="email" class="col col-form-label">{{ __('Email Address') }}</label>
    
                                <div class="col-9">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-5 text-right">
                                <label for="password" class="col col-form-label">{{ __('Password') }}</label>
    
                                <div class="col-9">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <button type="submit" class="btn btn-outline-primary btn-block">
                                        {{ __('SIGN IN') }}
                                    </button>
                                </div>
                            </div>

                            <div class="text-right">
                                @if (Route::has('password.request'))
                                    <a class="btn" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
