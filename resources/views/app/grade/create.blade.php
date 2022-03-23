@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead">Student ID: <strong>{{ $student->student_id }}</strong></p>
            </div>
            <div class="col text-right">
                <form action="{{ route('grades.toggle.student.access', [
                    'studentID' => $student->id,
                    'schedule' => $schedule->id
                ]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <button 
                        type="submit"
                        @class([
                            'btn',
                            'btn-warning' => !$schedule->studentGrades->first()->is_accessible_to_student,
                            'btn-success' => $schedule->studentGrades->first()->is_accessible_to_student
                        ])
                        data-toggle='tooltip'
                        data-placement='left'
                        title="{{ $schedule->studentGrades->first()->is_accessible_to_student ? 'Disable' : 'Enable' }} student access"
                    >
                        <i
                            @class([
                                'fa-solid',
                                'fa-eye-slash' => !$schedule->studentGrades->first()->is_accessible_to_student,
                                'fa-eye' => $schedule->studentGrades->first()->is_accessible_to_student
                            ])
                        ></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-4">
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
            <form action="{{ route('grades.update') }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                
                <div class="col">
                    <div class="card">
                        <div class="card-header bg-transparent">Subjects</div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($schedule->studentGrades as $studentGrade)
                                    <div class="col-12 col-sm-6 col-md-6">
                                        {{ $studentGrade->subject->name }}
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input
                                                type="text" 
                                                class="form-control @error('subject_id_' .  $studentGrade->subject_id) is-invalid @enderror" 
                                                placeholder="Enter grade" 
                                                name="subject_id_{{ $studentGrade->subject_id }}"
                                                value="{{ old('subject_id_' . $studentGrade->subject_id, $studentGrade->grade) }}"
                                            >
                                            @error( 'subject_id_' . $studentGrade->subject_id)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
                <div class="col-12 mt-4 text-right">
                    <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection