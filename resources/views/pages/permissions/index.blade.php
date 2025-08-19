@extends('layouts.main')

<title>LIST PO IMX | Permissions</title>


@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Permissions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles & Permissions</li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <form action="{{ route('permissions.store') }}" method="POST">
        <div class="row mt-5">
            <div class="col-md-6">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Permission Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
            </div>
            <div class="col-6 mt-4">
                <button type="submit" class="btn btn-primary">Create Permission</button>
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="col-md-12">
            <table id="permissionsTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Permission Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editPermissionModal" data-permission-id="{{ $permission->id }}" data-permission-name="{{ $permission->name }}">
                                    <i class="fa fa-pen"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePermissionModal" data-permission-id="{{ $permission->id }}">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Edit Permission Modal -->
<div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editPermissionForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="permissionName" class="form-label">Permission Name</label>
                        <input type="text" class="form-control" id="permissionName" name="name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Permission Modal -->
<div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deletePermissionForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Delete Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this permission?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete Permission</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('#permissionsTable').DataTable();

        // Edit Permission Modal
        var editPermissionModal = document.getElementById('editPermissionModal');
        editPermissionModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var permissionId = button.getAttribute('data-permission-id');
            var permissionName = button.getAttribute('data-permission-name');
            var permissionNameInput = document.querySelector('#permissionName');
            permissionNameInput.value = permissionName;
            var editPermissionForm = document.getElementById('editPermissionForm');
            editPermissionForm.action = '/permissions/update/' + permissionId;
        });

        // Delete Permission Modal
        var deletePermissionModal = document.getElementById('deletePermissionModal');
        deletePermissionModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var permissionId = button.getAttribute('data-permission-id');
            var deletePermissionForm = document.getElementById('deletePermissionForm');
            deletePermissionForm.action = '/permissions/destroy/' + permissionId;
        });
    });
</script>
@endsection
