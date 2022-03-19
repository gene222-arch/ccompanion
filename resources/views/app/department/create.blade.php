@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Department</div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('departments.store') }}" method="post">
                        @csrf
                       <div class="row">
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
                           <div class="col-12 mt-5 text-right">
                               <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                               <button type="submit" class="btn btn-success">Save</button>
                           </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection