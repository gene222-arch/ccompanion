@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Course</div>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('courses.update', $course->id) }}" method="post">
                        @csrf
                        @method('PUT')
                       <div class="row">
                            <div class="col-12 text-center py-4">
                                <i class="fa-solid fa-graduation-cap text-info fa-2x"></i>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input 
                                        id="code" 
                                        type="text" 
                                        class="form-control @error('code') is-invalid @enderror" 
                                        placeholder="Enter code" 
                                        name="code"
                                        value="{{ old('code', $course->code) }}"
                                    >
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                    <div class="form-group">
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <label for="name">Name</label>
                                        <input 
                                            id="name" 
                                            type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            placeholder="Enter name" 
                                            name="name"
                                            value="{{ old('name', $course->name) }}"
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
                                                    {{ old('department_id', $course->department_id) == $department->id ? 'selected' : '' }} 
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
        </div>
    </div>
@endsection