@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Department</div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('departments.update', $department->id) }}" method="post">
                        @csrf
                        @method('PUT')
                       <div class="row">
                            <div class="col-12 text-center py-4">
                                <i class="fa-solid fa-building fa-2x text-info"></i>
                            </div>
                            <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                                        <label for="name">Name</label>
                                        <input 
                                            id="name" 
                                            type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="Enter name" 
                                            name="name"
                                            value="{{ old('name', $department->name) }}"
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