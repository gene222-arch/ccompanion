@extends('layouts.main')

@section('content')
    <div class="display-6 px-2 py-3">Update Schedule</div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('schedules.update', $schedule->id) }}" method="post">
                        @csrf
                        @method('PUT')
                       <div class="row">
                            <div class="col-12 text-center py-4">
                                    <i class="fa-solid fa-calendar-day fa-2x text-info"></i>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="year_level">Year Level</label>
                                    <select 
                                        class="form-control custom-select @error('year_level') is-invalid @enderror" 
                                        id="year_level" 
                                        name="year_level"
                                    >
                                        <option value="0">Select Year Level</option>
                                        @foreach ([
                                            'First' => 1,
                                            'Second' => 2,
                                            'Third' => 3,
                                            'Fourth' => 4
                                        ] as $key => $value)
                                            <option 
                                                {{ old('year_level', $schedule->year_level) == $value ? 'selected' : '' }}
                                                value="{{ $value }}"
                                            >
                                                {{ $key }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('year_level')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="semester_type">Semester Level</label>
                                    <select 
                                        class="form-control custom-select @error('semester_type') is-invalid @enderror" 
                                        id="semester_type" 
                                        name="semester_type"
                                    >
                                        <option value="0">Select Semester Level</option>
                                        @foreach ([
                                            'First',
                                            'Second'
                                        ] as $semesterType)
                                            <option 
                                                {{ old('semester_type', $schedule->semester_type) == $semesterType ? 'selected' : '' }}
                                                value="{{ $semesterType }}"
                                            >
                                                {{ $semesterType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('semester_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                    <div class="form-group">
                                        <label for="department">Department</label>
                                        <select 
                                            class="form-control custom-select @error('department_id') is-invalid @enderror" 
                                            id="department" 
                                            name="department_id"
                                        >
                                            <option value="0">Select department</option>
                                            @foreach ($departments as $department)
                                                <option 
                                                    {{ old('department_id', $schedule->department_id) == $department->id ? 'selected' : '' }}
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
                                        <label for="course">Course</label>
                                        <select 
                                            class="form-control custom-select @error('course_id') is-invalid @enderror" 
                                            id="course" 
                                            name="course_id"
                                        >
                                            <option value="0">Select course</option>
                                            @foreach ($courses as $course)
                                                <option 
                                                    {{ old('course_id', $schedule->course_id) == $course->id ? 'selected' : '' }}
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
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="section">Section</label>
                                        <input 
                                            id="section" 
                                            type="text" 
                                            class="form-control @error('section') is-invalid @enderror" 
                                            placeholder="Enter Section" 
                                            name="section"
                                            value="{{ old('section', $schedule->section) }}"
                                        >
                                        @error('section')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            <div class="col-12 mt-5 text-right">
                                <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection