@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row align-items-center justify-content-between px-2 py-3">
        <div class="col">
            <div class="display-6">Registrars</div>
        </div>
        <div class="col text-right">
            <a href="{{ route('registrars.create') }}" class="p-2 px-4" data-toggle="tooltip" data-placement="right" title="Create New Registrars">
                <i class="fa-solid fa-circle-plus fa-3x text-success create-button-icon"></i>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <small><strong class="text-info">Note</strong> Select the name of the registrar to edit</small>
        </div>
    </div>
    <div class="card p-3">
        <table id="registrars" class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrars as $registrar)
                    <tr>
                        <td>
                            <a 
                                class="select-to-edit" 
                                href="{{ route('registrars.edit', $registrar->id) }}"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Edit selected registrar"
                            >
                                {{ $registrar->name }}
                            </a>
                        </td>
                        <td>{{ $registrar->email }}</td>
                        <td>
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
                                    data-target="#registrar{{ $registrar->id }}"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="modal fade" id="registrar{{ $registrar->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Delete selected registrar named <i class="text-danger">{{ $registrar->name }}</i>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                            <form action="{{ route('registrars.destroy', $registrar->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning">Continue</button>
                                            </form>
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
            $('#registrars').DataTable({
                pageLength: 5
            });
        });
    </script>
@endsection