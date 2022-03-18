@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Course</div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('courses.store') }}" method="post">
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
                   <div class="col-12 mt-5 text-right">
                       <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                       <button type="submit" class="btn btn-success">Save</button>
                   </div>
               </div>
            </form>
        </div>
    </div>
@endsection