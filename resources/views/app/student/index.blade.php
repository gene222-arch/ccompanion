@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row align-items-center justify-content-between px-2 py-3">
        <div class="col">
            <div class="display-6">Students</div>
        </div>
        <div class="col text-right">
            <a href="{{ route('students.create') }}" class="p-2 px-4" data-toggle="tooltip" data-placement="right" title="Create New Student">
                <i class="fa-solid fa-circle-plus fa-3x text-success create-button-icon"></i>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <small><strong class="text-info">Note</strong> Select the name of the student to edit</small>
        </div>
    </div>
    <div class="card p-3">
        <table id="students" class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>
                            <a 
                                class="select-to-edit" 
                                href="{{ route('students.edit', $student->id) }}"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Edit selected student"
                            >
                                {{ $student->user->name }}
                            </a>
                        </td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->department->name }}</td>
                        <td>{{ $student->course->name }}</td>
                        <td>
                            <div class="row align-items-center">
                                @if ($student->activeSchedule())
                                    <div class="col">
                                        <a href="{{ route('grades.edit', $student->id) }}">
                                            <i class="fa-solid fa-pen-fancy fa-2x"></i>
                                        </a>
                                    </div>
                                @endif
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
                                            data-target="#student{{ $student->id }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="student{{ $student->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete selected student named <i class="text-danger">{{ $student->user->name }}</i>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <form action="{{ route('students.destroy', $student->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-warning">Continue</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
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
            $('#students').DataTable({
                pageLength: 5
            });
        });
    </script>
@endsection