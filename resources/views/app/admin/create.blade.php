@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Administrator</div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('administrators.store') }}" method="post">
                @csrf
               <div class="row">
                   <div class="col-12 text-center">
                        <i class="fa-solid fa-user-shield text-info fa-3x p-4"></i>
                   </div>
                   <div class="col-12">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input 
                                id="name" 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Enter name" 
                                name="name"
                                value="{{ old('name') }}"
                            >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                   </div>
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
                   <div class="col-12 mt-5 text-right">
                       <a href="{{ route('administrators.index') }}" class="btn btn-outline-secondary">Cancel</a>
                       <button type="submit" class="btn btn-success">Save</button>
                   </div>
               </div>
            </form>
        </div>
    </div>
@endsection