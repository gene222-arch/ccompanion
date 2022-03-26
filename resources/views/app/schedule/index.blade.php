@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row align-items-center justify-content-between px-2 py-3">
        <div class="col">
            <div class="display-6">Schedules</div>
        </div>
        @hasanyrole('Super Administrator|Administrator|Registrar')
            <div class="col text-right">
                <a href="{{ route('schedules.create') }}" class="p-2 px-4" data-toggle="tooltip" data-placement="right" title="Create New Department">
                    <i class="fa-solid fa-circle-plus fa-3x text-success create-button-icon"></i>
                </a>
            </div>
        @endhasanyrole
    </div>
    <div class="card">
        <div class="card-body">
            <small><strong class="text-info">Note</strong> Select the code of the schedule to edit</small>
        </div>
    </div>
    <div class="card p-3">
        <table id="schedules" class="table table-hover">
            <thead>
                <tr>
                    @hasanyrole('Super Administrator|Administrator|Registrar')
                        <th>ID</th>
                        <th>Department</th>
                        <th>Course</th>
                    @endhasanyrole
                    @hasrole('Student')
                        <th>Year Level</th>
                        <th>Semester</th>
                        <th>Section</th>
                    @endhasrole
                    <th>Subjects</th>
                    @hasanyrole('Super Administrator|Administrator|Registrar')
                        <th>Status</th>
                    @endhasanyrole
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        @hasanyrole('Super Administrator|Administrator|Registrar')
                            <td>
                                @if (! $schedule->is_finalized)
                                    <a 
                                        class="select-to-edit" 
                                        href="{{ route('schedules.edit', $schedule->id) }}"
                                        data-toggle="tooltip" 
                                        data-placement="right" 
                                        title="Edit selected schedule"
                                    >
                                        {{ $schedule->code }}
                                    </a>
                                @else 
                                    {{ $schedule->code }}
                                @endif
                            </td>
                            <td>{{ $schedule->department->name }}</td>
                            <td>{{ $schedule->course->name }}</td>
                        @endhasanyrole
                        @hasrole('Student')
                            <td>{{ $schedule->year_level }}</td>
                            <td>{{ $schedule->semester_type }}</td>
                            <td>{{ $schedule->section }}</td>
                        @endhasrole
                        <td>{{ $schedule->details->map->subject_id->unique()->count() }}</td>
                        @hasanyrole('Super Administrator|Administrator|Registrar')
                        <td>
                            <span 
                                @class([
                                    'badge',
                                    'badge-success' => $schedule->is_finalized,
                                    'badge-info' => !$schedule->is_finalized
                                ])
                            >
                                {{ !$schedule->is_finalized ? 'In Progress' : 'Finalized' }}
                            </span>
                        </td>
                        <td>
                            <div class="row align-items-center text-center">
                                @if (! $schedule->is_finalized)
                                    <div class="col">
                                        <div 
                                            class="form-group my-2" 
                                            data-toggle="tooltip" 
                                            data-placement="right" 
                                            title="Finalize"
                                        >
                                            <button 
                                                type="submit" 
                                                class="btn btn-warning"
                                                data-toggle="modal" 
                                                data-target="#scheduleFinalized{{ $schedule->id }}"
                                            >
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="scheduleFinalized{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Finalize</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Finalize selected schedule?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                        <form action="{{ route('schedules.finalize', $schedule->id) }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <button 
                                                                class="btn btn-warning"
                                                                data-toggle="tooltip" 
                                                                data-placement="right" 
                                                                title="Finalize"
                                                            >
                                                                Continue
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div 
                                            class="form-group my-2" 
                                            data-toggle="tooltip" 
                                            data-placement="right" 
                                            title="Delete"
                                        >
                                            <button 
                                                type="submit" 
                                                class="btn btn-danger"
                                                data-toggle="modal" 
                                                data-target="#schedule{{ $schedule->id }}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="modal fade" id="schedule{{ $schedule->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Delete selected schedule named <i class="text-danger">{{ $schedule->name }}</i>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-warning">Continue</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($schedule->is_finalized)
                                    <div class="col">
                                        <a 
                                            @class([
                                                'btn',
                                                'btn-outline-info' => !$schedule->is_assigned_students_finalized,
                                                'btn-success' => $schedule->is_assigned_students_finalized
                                            ])
                                            href="{{ route('schedules.assign', $schedule->id) }}"
                                            data-toggle="tooltip" 
                                            data-placement="right" 
                                            title="{{ !$schedule->is_assigned_students_finalized ? 'Assign schedule to' : 'View assigned'}} students"
                                        >
                                            <i 
                                                @class([
                                                    'fa-solid',
                                                    'fa-user-check' => !$schedule->is_assigned_students_finalized,
                                                    'fa-users-viewfinder' => $schedule->is_assigned_students_finalized
                                                ])
                                            ></i>
                                        </a>
                                    </div>
                                @endif
                                <div class="col">
                                    <a 
                                        href="{{ route('schedules.show', $schedule->id) }}"
                                        data-toggle="tooltip" 
                                        data-placement="right" 
                                        title="View More Details"
                                    >
                                        <i class="fa-solid fa-eye fa-2x"></i>
                                    </a>
                                </div>
                            </div>
                        </td>
                        @endhasanyrole
                        @hasrole('Student')
                         <td>
                            <a 
                                href="{{ route('schedules.details.for.student', [
                                    'schedule' => $schedule->id,
                                    'student' => Auth::user()->student->id
                                ]) }}"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="View More Details"
                            >
                                <i class="fa-solid fa-eye fa-2x"></i>
                            </a>
                         </td>
                        @endhasrole
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#schedules').DataTable({
                pageLength: 5,
                // "order": []
            });
        });
    </script>
@endsection