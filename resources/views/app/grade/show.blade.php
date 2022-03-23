@extends('layouts.main')

@section('content')
    <div class="text-right">
        <button 
            type="submit"
            data-toggle='tooltip'
            data-placement='left'
            title='Print Com Card' 
            class="btn btn-outline-secondary mb-5"
        >
            <i class="fa-solid fa-print"></i>
        </button>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">Student Information</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col"><strong>Name</strong></div>
                        <div class="col text-secondary">{{ $student->user->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Department</strong></div>
                        <div class="col text-secondary">{{ $student->department->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Course</strong></div>
                        <div class="col text-secondary">{{ $student->course->name }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Year Level</strong></div>
                        <div class="col text-secondary">{{ $schedule->year_level }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Semester</strong></div>
                        <div class="col text-secondary">{{ $schedule->semester_type }}</div>
                    </div>
                    <div class="row">
                        <div class="col"><strong>Section</strong></div>
                        <div class="col text-secondary">{{ $schedule->section }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-header bg-transparent">Grades</div>
                <div class="card-body">
                    <div class="row align-items-center">
                        @foreach ($schedule->studentGrades as $studentGrade)
                            <div class="col-12 col-sm-6 col-md-6">
                                {{ $studentGrade->subject->name }}
                            </div>
                            <div class="col-12 col-sm-6 col-md-2">
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <p>{{ $studentGrade->grade }}</p>
                                        </div>
                                        <div class="col {{ $studentGrade->grade_point_equivalence >= 4 ? 'text-danger' : 'dark' }}">
                                            <p>{{ $studentGrade->grade_point_equivalence }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach 
                    </div>
                </div>
                <div class="card-footer bg-warning">
                    <small><strong class="text-danger">Note:</strong> A zero grade is equivalent to <strong><i>incomplete</i></strong>.</small>
                </div>
            </div>
        </div>
    </div>
@endsection