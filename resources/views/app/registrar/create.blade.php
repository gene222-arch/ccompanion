@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Registrar</div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('registrars.store') }}" method="post">
                @csrf
               <div class="row">
                   <div class="col-12 text-center mb-3">
                        <i class="fa-solid fa-user-tie text-info fa-3x p-4"></i>
                   </div>
                   <div class="col-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input 
                                id="first_name" 
                                type="text" 
                                class="form-control @error('first_name') is-invalid @enderror" 
                                placeholder="Enter First Name" 
                                name="first_name"
                                value="{{ old('first_name') }}"
                            >
                            @error('first_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input 
                                id="last_name" 
                                type="text" 
                                class="form-control @error('last_name') is-invalid @enderror" 
                                placeholder="Enter Last Name" 
                                name="last_name"
                                value="{{ old('last_name') }}"
                            >
                            @error('last_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="birthed_at">Birthday</label>
                            <input 
                                id="birthed_at" 
                                type="date" 
                                class="form-control @error('birthed_at') is-invalid @enderror" 
                                placeholder="Enter Birthday" 
                                name="birthed_at"
                                value="{{ old('birthed_at') }}"
                            >
                            @error('birthed_at')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="department">Select Department</label>
                            <select 
                                class="form-control custom-select @error('department_id') is-invalid @enderror" 
                                id="department" 
                                name="department_id"
                            >
                                <option value="0">Select department</option>
                                @foreach ($departments as $department)
                                    <option 
                                        {{ old('department_id', 0) == $department->id ? 'selected' : '' }}
                                        value="{{ $department->id }}"
                                    >
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">Account</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input 
                                                id="email" 
                                                type="text" 
                                                class="form-control @error('email') is-invalid @enderror" 
                                                placeholder="Enter email" 
                                                name="email"
                                                value="{{ old('email') }}"
                                            >
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input 
                                                id="password" 
                                                type="password" 
                                                class="form-control @error('password') is-invalid @enderror" 
                                                placeholder="Enter password" 
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input 
                                                id="password_confirmation" 
                                                type="password" 
                                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                placeholder="Repeat Password" 
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
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-5 text-right">
                        <a href="{{ route('registrars.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
               </div>
            </form>
        </div>
    </div>
@endsection