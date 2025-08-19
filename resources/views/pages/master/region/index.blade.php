@extends('layouts.main')


<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
</style>

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Wilayah</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master</li>
                        <li class="breadcrumb-item active">Wilayah</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="mb-3">
                {{-- <h5 class="card-title">Contact List <span class="text-muted fw-normal ms-2">(834)</span></h5> --}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                <div>
                    <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <table id="typeContractTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>DC</th>
                        {{-- <th>Group DC</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regions as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->dc_name }}</td>
                            {{-- <td>{{ $item->group_name }}</td> --}}
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editTypeContractModal" data-id="{{ $item->id }}" data-dc_name="{{ $item->dc_name }}" data-group_name="{{ $item->group_name }}">
                                    <i class="fa fa-pen"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTypeContractModal" data-id="{{ $item->id }}">
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('region.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dc_name" class="form-label">DC</label>
                        <select id="dc_name" name="dc_name" class="form-control" required>
                            <option value="">Select DC</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal --><!-- Edit Modal -->
<div class="modal fade" id="editTypeContractModal" tabindex="-1" aria-labelledby="editTypeContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editRegionForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTypeContractModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_dc_name" class="form-label">DC</label>
                        <select id="edit_dc_name" name="dc_name" class="form-control" required>
                            <option value="">Select DC</option>
                        </select>
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


<!-- Delete Modal -->
<div class="modal fade" id="deleteTypeContractModal" tabindex="-1" aria-labelledby="deleteTypeContractModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteTypeContractForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTypeContractModalLabel">Delete Type Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this type contract?
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

        $('#typeContractTable').DataTable();

        fetch('{{ env('SAP_API') }}/api/dc')
            .then(response => response.json())
            .then(data => {
                const dcSelect = document.getElementById('dc_name');
                data.forEach(dc => {
                    const option = document.createElement('option');
                    option.value = dc.CardName;
                    option.textContent = `${dc.CardName}`;
                    dcSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching DC data:', error));

        fetch('{{ env('SAP_API') }}/api/dc-group')
            .then(response => response.json())
            .then(data => {
                const dcGroupSelect = document.getElementById('dc_group');
                data.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group.GroupName;
                    option.textContent = `${group.GroupName}`;
                    dcGroupSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching DC Group data:', error));
            

        // Edit Type Contract Modal
        var editTypeContractModal = document.getElementById('editTypeContractModal');
        editTypeContractModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var nameInput = document.getElementById('name');
            nameInput.value = name;
            var editRegionForm = document.getElementById('editRegionForm');
            editRegionForm.action = '/master/region/update/' + id;
        });


        // Handle Edit Button Click
        document.querySelectorAll('[data-bs-target="#editTypeContractModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const dcName = this.getAttribute('data-dc_name');
                const groupName = this.getAttribute('data-group_name');

                // Set form action URL for update
                document.getElementById('editRegionForm').action = `/master/region/update/${id}`;

                // Pre-fill the edit form fields
                document.getElementById('edit_dc_name').value = dcName;
                document.getElementById('edit_dc_group').value = groupName;
            });
        });

        // Fetch and populate select options for edit modal
        function populateSelectOptions() {
            fetch('{{ env('SAP_API') }}/api/dc')
                .then(response => response.json())
                .then(data => {
                    const dcSelect = document.getElementById('edit_dc_name');
                    data.forEach(dc => {
                        const option = document.createElement('option');
                        option.value = dc.CardName;
                        option.textContent = `${dc.CardName}`;
                        dcSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching DC data:', error));

            fetch('{{ env('SAP_API') }}/api/dc-group')
                .then(response => response.json())
                .then(data => {
                    const dcGroupSelect = document.getElementById('edit_dc_group');
                    data.forEach(group => {
                        const option = document.createElement('option');
                        option.value = group.GroupName;
                        option.textContent = `${group.GroupName}`;
                        dcGroupSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching DC Group data:', error));
        }

        populateSelectOptions();
        var deleteTypeContractModal = document.getElementById('deleteTypeContractModal');
        deleteTypeContractModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var deleteTypeContractForm = document.getElementById('deleteTypeContractForm');
            deleteTypeContractForm.action = '/master/region/destroy/' + id;
        });
    });
</script>
@endsection
