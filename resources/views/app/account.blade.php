@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card" style="height: 28.8vh">
                <div class="card-header bg-primary text-white">Personal Information</div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col"><strong>Name</strong></div>
                        <div class="col text-right text-secondary">{{ $user->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Email</strong></div>
                        <div class="col text-right text-secondary">{{ $user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('account.change.password') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col"><strong>New Password</strong></div>
                            <div class="col text-right text-secondary">
                                <div class="form-group">
                                    <input 
                                        id="password" 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        placeholder="Enter Password" 
                                        name="password"
                                        value="{{ old('password') }}"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><strong>Confirm New Password</strong></div>
                            <div class="col text-right text-secondary">
                                <div class="form-group">
                                    <input 
                                        id="password_confirmation" 
                                        type="password" 
                                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        placeholder="Confirm Password" 
                                        name="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                    >
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col">
                                <button class="btn btn-success btn-block">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection