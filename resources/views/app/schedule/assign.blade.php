@extends('layouts.main')

@section('js')
    <script>
        document
            .querySelector('.select-all-input')
            .addEventListener('change', function () 
            {
                const checkboxes = document.querySelectorAll('.student-checkbox');

                for (var checkbox of checkboxes) {
                    checkbox.checked = this.checked;
                }
            });
    </script>
@endsection

@section('content')
    @if (! $errors->isEmpty())
        <div class="alert alert-danger" role="alert">
        Please select students!
        <button type="button" class="close close-modal-btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
    <div class="row justify-content-between align-items-center">
        <div class="col">
            <div class="display-6 px-2 pt-3">Assign Schedule {{ $schedule->code }}</div>
        </div>
        <div class="col text-right">
            @if (! $schedule->is_assigned_students_finalized && $schedule->studentGrades->count())
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#markButtonAsFinal">
                    MARK AS FINAL
                </button>
            @endif
            <div class="modal fade" id="markButtonAsFinal" tabindex="-1" aria-labelledby="markButtonAsFinalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('schedules.finalize.assigned.students', $schedule->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title text-danger" id="markButtonAsFinalLabel">FINALIZED</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-left">
                                Are you sure to mark <strong>{{ $schedule->code }}</strong> as final, you won`t be able to revert this action?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Continue</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <strong>Year Level</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->year_level }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong>Semester Type</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->semester_type }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong>Department</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->department->name }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong>Course</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->course->name }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong>Subjects</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->details_count }}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <strong>Units</strong>
                </div>
                <div class="col text-secondary">
                    {{ $schedule->details->map->subject->sum('units') }}
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('schedules.assign', $schedule->id) }}" method="post">
                @csrf
               <div class="row">
                    <div class="col-12 text-center mb-3">
                            <i class="fa-solid fa-user-check text-info fa-3x p-4"></i>
                    </div>
                    <div class="dropdown-divider mt-4"></div>
                    <div class="col-12 col-sm-12 col-md-6 mt-4">
                        <div class="list-group-item bg-dark text-white">
                            <div class="form-check ml-1">
                                <input
                                    id="selectAll"
                                    class="form-check-input select-all-input" 
                                    type="checkbox"
                                >
                                <label class="form-check-label" for="selectAll">
                                <i class="mr-2"></i> Select All
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label 
                            for="students" 
                            class="my-4 @error('student_ids') text-danger @enderror"
                        >
                            Select Students
                        </label>
                        <ul class="list-group">
                            <div class="row">
                                @foreach ($students as $student)
                                    <div class="col-12 col-sm-12 col-md-6">
                                        <div class="list-group-item">
                                            <div class="form-check ml-1">
                                                <input 
                                                    id="student{{ $student->id }}"
                                                    name="student_ids[]" 
                                                    class="form-check-input student-checkbox" 
                                                    type="checkbox" 
                                                    value="{{ $student->id }}" 
                                                    {{ in_array($student->id, old('student_ids', $schedule->studentGrades?->map?->student_id?->toArray() ?? [])) ? 'checked' : '' }}
                                                >
                                                <label class="form-check-label" for="student{{ $student->id }}">
                                                <i class="mr-2">{{ $student->code }}</i> {{ $student->user->name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </ul>
                    </div>
                    <div class="col-12 mt-5 text-right">
                        <a href="{{ route('schedules.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection