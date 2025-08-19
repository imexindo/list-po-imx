@extends('layouts.main')

<title>LIST SEWA | Kontrak AC</title>

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
                <h4 class="mb-sm-0 font-size-18">Kontrak</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Master Kontrak</li>
                        <li class="breadcrumb-item active">Kontrak</li>
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
            <table id="contractTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Tahun</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contracts as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->year }}</td>
                            <td>
                                
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editContractModal" data-id="{{ $item->id }}" data-title="{{ $item->title }}">
                                    <i class="fa fa-pen"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteContractModal" data-id="{{ $item->id }}">
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
        <form action="{{ route('contracts.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Master Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            {{-- <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" required>
                            </div> --}}
                            <div class="form-group">
                              <label for="">Lokasi</label>
                              <select class="form-control" name="title" id="title">
                                <option value="DALAM KOTA">DALAM KOTA</option>
                                <option value="JAWA">JAWA</option>
                                <option value="LUAR JAWA">LUAR JAWA</option>
                              </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="year">Tahun</label>
                                    <select class="form-control" name="year" id="year">
                                        <option value="" disabled selected>Pilih Tahun</option>
                                        @php
                                            $currentYear = date('Y');
                                            for ($year = 2017; $year <= $currentYear; $year++) {
                                                echo "<option value=\"$year\">$year</option>";
                                            }
                                        @endphp
                                    </select>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div id="extraFieldsContainerCreate">
                    </div>
                    <button type="button" class="btn btn-info btn-sm" id="addFieldButtonCreate"><i class="fa fa-plus"></i> Add Type</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editContractModal" tabindex="-1" aria-labelledby="editContractModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editContractForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContractModalLabel">Edit Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="title" class="form-label">Lokasi</label>
                                <select class="form-control" id="title" name="title" required>
                                    <option value="DALAM KOTA">DALAM KOTA</option>
                                    <option value="JAWA">JAWA</option>
                                    <option value="LUAR JAWA">LUAR JAWA</option>
                                </select>
                            </div>                            
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteContractModal" tabindex="-1" aria-labelledby="deleteContractModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="deleteContractForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteContractModalLabel">Delete Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this contract?
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
        $('#contractTable').DataTable();

        // EDIT
        var editContractModal = document.getElementById('editContractModal');
        editContractModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var title = button.getAttribute('data-title');

            var titleSelect = editContractModal.querySelector('#title');

            titleSelect.value = title;
            titleSelect.dispatchEvent(new Event('change'));

            var editContractForm = document.getElementById('editContractForm');
            editContractForm.action = '/master/contracts/update/' + id;
        });

        // Delete Contract Modal
        var deleteContractModal = document.getElementById('deleteContractModal');
        deleteContractModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var deleteContractForm = document.getElementById('deleteContractForm');
            deleteContractForm.action = '/master/contracts/destroy/' + id;
        });



        // Fetch Types SAP
        async function fetchTypes() {
            try {
                const response = await fetch('{{ env('SAP_API') }}/api/pk');
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Failed to fetch types:', error);
                return [];
            }
        }

        function populateSelect(selectElement, options) {
            selectElement.innerHTML = '<option value="" disabled selected>Select Type</option>';

            // Group options by U_SOL_PK and keep the highest Id for each
            const groupedOptions = options.reduce((acc, option) => {
                if (!acc.has(option.U_SOL_PK) || acc.get(option.U_SOL_PK).Id < option.Id) {
                    acc.set(option.U_SOL_PK, option);
                }
                return acc;
            }, new Map());

            // Convert the map to an array and sort by Id in descending order
            const sortedOptions = Array.from(groupedOptions.values())
                .sort((a, b) => b.Id - a.Id);

            sortedOptions.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.U_SOL_PK;
                optionElement.textContent = option.U_SOL_PK;
                selectElement.appendChild(optionElement);
            });
        }

        async function addField(containerId, contractId) {
            var container = document.getElementById(containerId);
            var fieldGroup = document.createElement('div');
            fieldGroup.className = 'field-group mb-3';

            const types = await fetchTypes();

            fieldGroup.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <select name="type[]" class="form-select" placeholder="Type" required>
                            <option value="" disabled selected>Select Type</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="price[]" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="col-md-1 mt-2">
                        <button type="button" class="btn btn-danger btn-sm removeFieldButton"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <input type="hidden" name="m_contract_id[]" value="${contractId}">
            `;

            container.appendChild(fieldGroup);

            const selectElement = fieldGroup.querySelector('select[name="type[]"]');
            populateSelect(selectElement, types);

            var removeButtons = container.getElementsByClassName('removeFieldButton');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].onclick = function() {
                    this.parentNode.parentNode.parentNode.remove();
                }
            }
        }


        document.getElementById('addFieldButtonCreate').onclick = function() {
            var contractId = 'new'; 
            addField('extraFieldsContainerCreate', contractId);
        };
    });
</script>
@endsection
