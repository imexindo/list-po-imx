@extends('layouts.main')

<title>LIST SEWA | Roles</title>


@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Manage Roles</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">Roles & Permissions</li>
                        <li class="breadcrumb-item active">Roles</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    {{-- <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">(834)</span></h5>
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <div>
                    <a href="#" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                </div>
            </div>
        </div>
    </div> --}}
    <form action="{{ route('roles.store') }}" method="POST">
        <div class="row">
            <div class="col-md-6">
                @csrf
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="col-6 mt-4">
                <button type="submit" class="btn btn-primary mt-2"><i class="fa fa-plus"></i> Create Role</button>
            </div>
        </div>
    </form>

    <div class="row mt-4">
        <div class="col-md-12">
            <table id="rolesTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Role Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal" data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                    <i class="fa fa-pen"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRoleModal" data-role-id="{{ $role->id }}">
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

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editRoleForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleName">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="permissions">Permissions</label>
                        <div id="permissionsCheckboxes">
                            <!-- Permission checkboxes will be inserted here -->
                        </div>
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

<!-- Delete Role Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" id="deleteRoleForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this role?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    $('#rolesTable').DataTable();

    var editRoleModal = document.getElementById('editRoleModal');
        editRoleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var roleId = button.getAttribute('data-role-id');
            var roleName = button.getAttribute('data-role-name');
            var roleNameInput = document.querySelector('#roleName');
            var editRoleForm = document.getElementById('editRoleForm');
            var permissionsCheckboxes = document.getElementById('permissionsCheckboxes');

            roleNameInput.value = roleName;
            editRoleForm.action = '/roles/update/' + roleId;

            // Fetch the permissions
            fetch(`/roles/${roleId}/permissions`)
                .then(response => response.json())
                .then(data => {
                    var permissions = data.permissions;
                    permissionsCheckboxes.innerHTML = ''; // Clear previous checkboxes

                    // Iterate over permissions and create checkboxes
                    @foreach($permissions as $permission)
                        var checked = permissions.includes({{ $permission->id }}) ? 'checked' : '';
                        permissionsCheckboxes.innerHTML += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" ${checked}>
                                <label class="form-check-label">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        `;
                    @endforeach
                });
        });

        var deleteRoleModal = document.getElementById('deleteRoleModal');
        deleteRoleModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var roleId = button.getAttribute('data-role-id');
            var deleteRoleForm = document.getElementById('deleteRoleForm');
            deleteRoleForm.action = '/roles/destroy/' + roleId;
        });
    });


</script>
@endsection
