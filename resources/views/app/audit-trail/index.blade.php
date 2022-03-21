@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
    <div class="row align-items-center justify-content-between px-2 py-3">
        <div class="col">
            <div class="display-6">Audit Trails</div>
        </div>
    </div>
    <div class="card p-3">
        <table id="departments" class="table table-hover">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>Model</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($auditTrails as $auditTrail)
                    <tr>
                        <td>
                            <span
                                @class([
                                    'p-2',
                                    'badge',
                                    'rounded-pill',
                                    'bg-success' => $auditTrail->action === 'Create',
                                    'bg-warning' => $auditTrail->action === 'Update',
                                    'bg-danger' => $auditTrail->action === 'Delete'
                                ])
                            >
                                {{ $auditTrail->action }}
                            </span>
                        </td>
                        <td>
                            {{ Str::substr($auditTrail->audit_trailable_type, 11) }}
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
            $('#departments').DataTable({
                pageLength: 5
            });
        });
    </script>
@endsection