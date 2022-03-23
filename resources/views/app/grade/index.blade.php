@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    @if (! $schedules->count())
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading text-danger">Oops!</h4>
            <p>It seems like your <strong>transcript of records</strong> are not available yet.</p>
            <hr>
            <p class="mb-0">Your TOR is displayed here, if not, it only means your grade still under process.</p>
        </div>
    @else
        <div class="display-6 py-3">Transcript of Records</div>
        <div class="card p-3">
            <table id="schedules" class="table table-hover">
                <thead>
                    <tr>
                        <th scope='col'>Semester</th>
                        <th scope='col'>Year Level</th>
                        <th scope='col'>Section</th>
                        <th scope='col'>Average Grade</th>
                        <th scope='col'>GWA</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->semester_type }}</td>
                            <td>{{ $schedule->year_level }}</td>
                            <td>{{ $schedule->section }}</td>
                            <td>{{ number_format($schedule->student_grades_avg_grade, 2) }}</td>
                            <td>{{ number_format($schedule->student_grades_avg_grade_point_equivalence, 2) }}</td>
                            <td>
                                <a href="" data-toggle='tooltip' data-placement='left' title='View Com Card'>
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
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