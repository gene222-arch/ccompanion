@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Create Student</div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('students.store') }}" method="post">
                @csrf
               <div class="row">
                   <div class="col-12 text-center">
                        <i class="fa-solid fa-user text-info fa-3x p-4"></i>
                   </div>
                   <h5 class="text-secondary my-4">
                       Student Information
                   </h5>
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
                    <div class="col-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input 
                                id="email" 
                                type="text" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="ex: student@gmail.com" 
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
                    <div class="col-6">
                        <div class="form-group">
                            <label for="guardian">Guardian</label>
                            <input 
                                id="guardian" 
                                type="text" 
                                class="form-control @error('guardian') is-invalid @enderror" 
                                placeholder="Enter Guardian" 
                                name="guardian"
                                value="{{ old('guardian') }}"
                            >
                            @error('guardian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="contact_number">Contact Number</label>
                            <input 
                                id="contact_number" 
                                type="text" 
                                class="form-control @error('contact_number') is-invalid @enderror" 
                                placeholder="Ex: +630915420321" 
                                name="contact_number"
                                value="{{ old('contact_number') }}"
                            >
                            @error('contact_number')
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
                    <div class="dropdown-divider mt-4"></div>
                    <h5 class="text-secondary my-4">
                        Course Information
                    </h5>
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
                    <div class="col-12">
                        <div class="form-group">
                            <label for="course">Select Courses</label>
                            <select 
                                class="form-control custom-select @error('course_id') is-invalid @enderror" 
                                id="course" 
                                name="course_id"
                            >
                                <option value="0">Select course</option>
                                @foreach ($courses as $course)
                                    <option 
                                        {{ old('course_id', 0) == $course->id ? 'selected' : '' }}
                                        value="{{ $course->id }}"
                                    >
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mt-5 text-right">
                        <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
               </div>
            </form>
        </div>
    </div>
@endsection