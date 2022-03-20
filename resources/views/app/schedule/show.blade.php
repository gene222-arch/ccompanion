@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    {{-- Modal --}}
    <div class="modal fade" id="createSchedule" tabindex="-1" role="dialog" aria-labelledby="createScheduleTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('schedules.store.details', $schedule->id) }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add new schedule</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select 
                                        class="form-control custom-select @error('subject_id') is-invalid @enderror" 
                                        id="subject" 
                                        name="subject_id"
                                    >
                                        <option value="0">Select subject</option>
                                        @foreach ($subjects as $subject)
                                            <option 
                                                {{ old('subject_id', 0) == $subject->id ? 'selected' : '' }}
                                                value="{{ $subject->id }}"
                                            >
                                                {{ $subject->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="professor">Professor</label>
                                    <select 
                                        class="form-control custom-select @error('professor_id') is-invalid @enderror" 
                                        id="professor" 
                                        name="professor_id"
                                    >
                                        <option value="0">Select professor</option>
                                        @foreach ($professors as $professor)
                                            <option 
                                                {{ old('professor_id', 0) == $professor->id ? 'selected' : '' }}
                                                value="{{ $professor->id }}"
                                            >
                                                {{ $professor->name() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('professor_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="day">Day</label>
                                    <select 
                                        class="form-control custom-select @error('day') is-invalid @enderror" 
                                        id="day" 
                                        name="day"
                                    >
                                        <option value="0">Select Day</option>
                                        @foreach ([
                                            'Monday',
                                            'Tuesday',
                                            'Wednesday',
                                            'Thursday',
                                            'Friday',
                                            'Saturday'
                                        ] as $day)
                                            <option 
                                                {{ old('day', 0) == $day ? 'selected' : '' }}
                                                value="{{ $day }}"
                                            >
                                                {{ $day }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('day')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="from">From</label>
                                    <input 
                                        id="from" 
                                        type="time" 
                                        class="form-control @error('from') is-invalid @enderror" 
                                        placeholder="Enter From" 
                                        name="from"
                                        value="{{ old('from') }}"
                                    >
                                    @error('from')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="to">To</label>
                                    <input 
                                        id="to" 
                                        type="time" 
                                        class="form-control @error('to') is-invalid @enderror" 
                                        placeholder="Enter To" 
                                        name="to"
                                        value="{{ old('to') }}"
                                    >
                                    @error('to')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal --}}
    <div class="row justify-content-center">
        <div class="display-6 mb-5"><small class="text-secondary">Sched Code:</small> {{ $schedule->code }}</div>
        <div class="col-12 col-sm-12 col-md-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <strong>Year Level</strong>
                        </div>
                        <div class="col text-secondary">
                            {{ $schedule->day }}
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
                </div>
                <div class="card-footer text-muted text-center">
                    Created {{ \Carbon\Carbon::parse($schedule->created_at)->diffForHumans() }}
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-10 text-right mt-2">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createSchedule">
                <i class="fa-solid fa-plus"></i> Add Schedule
            </button>
        </div>
        <div class="col-12 mt-4">
            <table class="table table-hover" id="schedules">
                <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">Professor</th>
                        <th scope="col">Day</th>
                        <th scope="col">From</th>
                        <th scope="col">To</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $detail)
                        <tr>
                            <td>{{ $detail->subject->name }}</td>
                            <td>{{ $detail->professor->name() }}</td>
                            <td>{{ $detail->day }}</td>
                            <td>{{ $detail->from }}</td>
                            <td>{{ $detail->to }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#schedules').DataTable({
                pageLength: 5
            });
        });
    </script>
@endsection