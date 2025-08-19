@extends('layouts.main')

<title>LIST PO IMX | Users</title>

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    {{-- <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">(834)</span></h5> --}}
                </div>
            </div>

            {{-- <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <a href="#" class="btn btn-light"><i class="bx bx-plus me-1"></i> Add New</a>
                    </div>
                </div>
            </div> --}}
        </div>
        <!-- end row -->

        <div class="row">
            @foreach($users as $user)
                <div class="col-xl-3 col-sm-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="dropdown text-end">
                                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-end">
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-roles="{{ json_encode($user->roles->pluck('id')) }}">Edit</button>
                                    <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}">Remove</button>
                                </div>
                            </div>
                            
                            <div class="mx-auto mb-4">
                                <img src="{{ $user->pic ? asset('storage/profile_pictures/' . $user->pic) : asset('cms/assets/img/logo.png') }}" alt="" class="avatar-xl rounded-circle img-thumbnail">
                                
                            </div>
                            <h5 class="font-size-16 mb-1"><a href="#" class="text-body">{{ $user->name }}</a></h5>
                            <h5 class="font-size-16 mb-1"><a href="#" class="text-body">{{ $user->email }}</a></h5>
                            <p class="text-muted mb-2">
                                @foreach($user->roles as $role)
                                    {{ $role->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                            <span class="badge bg-primary py-1 px-2">Last Login : {{ $user->last_login }}</span>
                            
                        </div>
        
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-light text-truncate" data-bs-toggle="modal" data-bs-target="#editUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-roles="{{ json_encode($user->roles->pluck('id')) }}"><i class="uil uil-user me-1"></i> Edit</button>
                            <button type="button" class="btn btn-outline-light text-truncate" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-user-id="{{ $user->id }}"><i class="uil uil-envelope-alt me-1"></i> Remove</button>
                        </div>
                    </div>
                    <!-- end card -->
                </div>
            @endforeach
        </div>
        <!-- end row -->
        
        
        <div class="row g-0 align-items-center mb-4">
            <div class="col-sm-6">
                <div>
                    <p class="mb-sm-0">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-end">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        
        
        <!-- end row -->
        
    </div> <!-- container-fluid -->
</div>


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editUserForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Roles</label>
                        <div id="rolesContainer">
                            @foreach($roles as $role)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $role->id }}" id="role{{ $role->id }}" name="roles[]">
                                    <label class="form-check-label" for="role{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="userPassword" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="userPasswordConfirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="userPasswordConfirmation" name="password_confirmation">
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

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteUserForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#usersTable').DataTable();
        // Edit User Modal
        var editUserModal = document.getElementById('editUserModal');
        editUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var userName = button.getAttribute('data-user-name');
            var userEmail = button.getAttribute('data-user-email');
            var userRoles = JSON.parse(button.getAttribute('data-user-roles'));
            var modal = document.querySelector('#editUserModal');
            modal.querySelector('#userName').value = userName;
            modal.querySelector('#userEmail').value = userEmail;

            // Set roles
            var roleCheckboxes = document.querySelectorAll('#rolesContainer .form-check-input');
            roleCheckboxes.forEach(function(checkbox) {
                checkbox.checked = userRoles.includes(parseInt(checkbox.value));
            });

            var editUserForm = document.getElementById('editUserForm');
            editUserForm.action = '/users/update/' + userId;
        });

        // Delete User Modal
        var deleteUserModal = document.getElementById('deleteUserModal');
        deleteUserModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute('data-user-id');
            var deleteUserForm = document.getElementById('deleteUserForm');
            deleteUserForm.action = '/users/destroy/' + userId;
        });
    });
</script>
@endsection