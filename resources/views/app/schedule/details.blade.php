@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@if ($schedule)
    @section('content')
        <div class="row align-items-center mb-5">
            <div class="col">
                <div class="display-6">
                    <small class="text-secondary">Sched Code:</small> {{ $schedule->code }}
                </div>
            </div>
            <div class="col text-right">
                <form action="{{ route('exports.registration.form', [
                    'student' => $student->id,
                    'schedule' => $schedule->id
                ]) }}" target="_blank" method="post">
                    @csrf
                    <button 
                        type="submit"
                        data-toggle='tooltip'
                        data-placement='left'
                        title='Print Schedule' 
                        class="btn btn-outline-secondary"
                    >
                        <i class="fa-solid fa-print"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
                <div class="card">
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
                                <strong>Section</strong>
                            </div>
                            <div class="col text-secondary">
                                {{ $schedule->section }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover" id="schedules">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Section</th>
                                    <th scope="col">Professor</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Units</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedule->details as $scheduleDetail)
                                    <tr>
                                        <td>{{ $scheduleDetail->subject->code }}</td>
                                        <td>{{ $scheduleDetail->subject->name }}</td>
                                        <td>{{ $schedule->section }}</td>
                                        <td>{{ $scheduleDetail->professor->name() }}</td>
                                        <td>{{ $scheduleDetail->room }}</td>
                                        <td>{{ $scheduleDetail->day }}</td>
                                        <td>{{ $scheduleDetail->from }}</td>
                                        <td>{{ $scheduleDetail->to }}</td>
                                        <td>{{ $scheduleDetail->subject->units }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@else
    @section('content')
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading text-danger">Oops!</h4>
            <p>It seems like you`re <strong>not scheduled</strong> yet.</p>
            <hr>
            <p class="mb-0">Your current schedule is displayed here, if not, it only means you`re still under process.</p>
        </div>
    @endsection
@endif

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#schedules').DataTable({
                pageLength: 5,
                "order": [[ 6, "DESC" ]]
            });
        });
    </script>
@endsection