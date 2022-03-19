@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row align-items-center justify-content-between px-2 py-3">
        <div class="col">
            <div class="display-6">Announcements</div>
        </div>
        <div class="col text-right">
            <a href="{{ route('announcements.create') }}" class="p-2 px-4" data-toggle="tooltip" data-placement="right" title="Create New Department">
                <i class="fa-solid fa-circle-plus fa-3x text-success create-button-icon"></i>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <small><strong class="text-info">Note</strong> Select the name of the announcement to edit</small>
        </div>
    </div>
    <div class="card p-3">
        <table id="announcements" class="table table-hover">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Subheader</th>
                    <th>Body</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/' . $announcement->image_path) }}" alt="{{ $announcement->header }}" width="100" height="100">
                        </td>
                        <td>
                            <a
                                class="select-to-edit" 
                                href="{{ route('announcements.edit', $announcement->id) }}"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Edit selected announcement"
                            >
                                {{ $announcement->header }}
                            </a>
                        </td>
                        <td>{{ $announcement->subheader }}</td>
                        <td>{!! Str::of($announcement->body)->limit(30) !!}</td>
                        <td>
                            <span 
                                @class([
                                    'badge',
                                    'p-1',
                                    'badge-success' => $announcement->enabled,
                                    'badge-secondary' => !$announcement->enabled,
                                ])
                            >
                                {{ $announcement->enabled ? 'Enabled' : 'Disabled' }}
                            </span>
                        </td>
                        <td>
                            <div class="row align-items-center">
                                <div class="col">
                                   <a href="{{ route('announcements.enabled', $announcement->id) }}">
                                        <i class="fa-solid fa-toggle-{{ $announcement->enabled ? 'on' : 'off' }} fa-2x"></i>
                                   </a>
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
                                            data-target="#announcement{{ $announcement->id }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="modal fade" id="announcement{{ $announcement->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Delete selected announcement named <i class="text-danger">{{ $announcement->name }}</i>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                                    <form action="{{ route('announcements.destroy', $announcement->id) }}" method="post">
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
            $('#announcements').DataTable({
                pageLength: 5
            });
        });
    </script>
@endsection