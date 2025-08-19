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
                    <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add</button>
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
                        <th>Kode Kontrak</th>
                        <th>Nama</th>
                        <th>Tahun</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($typeContracts as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->contract ? $item->contract->code : '-' }}</td>
                            <td>{{ $item->contract ? $item->contract->title : '-' }}</td>
                            <td>{{ $item->contract ? $item->contract->year : '-'}}</td>
                            @php
                                $badgeColors = [
                                    'KF-70' => 'bg-primary',
                                    'KF-50' => 'bg-success', 
                                    'KF-34' => 'bg-warning',
                                    'KF-26' => 'bg-info',
                                    'KF-15' => 'bg-danger',
                                    'KF-00' => 'bg-light text-dark',
                                    'KF-100' => 'bg-secondary',
                                    'KF-120' => 'bg-dark',
                                    'SD-70' => 'bg-primary',
                                    'SD-90' => 'bg-success',
                                    'SD-120' => 'bg-warning', 
                                    'DB-60' => 'bg-info',
                                    'DB-80' => 'bg-danger',
                                    'DB-100' => 'bg-light text-dark',
                                    'DB-150' => 'bg-secondary',
                                    'DB-200' => 'bg-dark'
                                ];
                                $badgeColor = $badgeColors[$item->type] ?? 'bg-secondary';
                            @endphp
                            <td><span class="badge {{ $badgeColor }}">{{ $item->type }}</span></td>
                            <td>{{ formatRupiah($item->price) }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                {{-- <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editTypeContractModal" 
                                        data-id="{{ $item->id }}" data-code="{{ $item->contract->code }}" 
                                        data-title="{{ $item->contract->title }}" data-year="{{ $item->contract->year }}" 
                                        data-type="{{ $item->type }}" data-price="{{ $item->price }}">
                                    <i class="fa fa-pen"></i> Edit
                                </button> --}}
                                {{-- <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteTypeContractModal" data-id="{{ $item->id }}">
                                    <i class="fa fa-trash"></i> Delete
                                </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>

<!-- Create Modal -->
{{-- <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('type-contracts.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Add Type Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> --}}


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


<!-- Edit Type Contract Modal -->
<div class="modal fade" id="editTypeContractModal" tabindex="-1" aria-labelledby="editTypeContractModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editTypeContractForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTypeContractModalLabel">Edit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-control" id="title" name="title" required disabled>
                            <option value="DALAM KOTA">DALAM KOTA</option>
                            <option value="JAWA">JAWA</option>
                            <option value="LUAR JAWA">LUAR JAWA</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-control" id="year" name="year" required disabled>
                            <option value="" disabled>Pilih Tahun</option>
                            @php
                                $currentYear = date('Y');
                                for ($year = 2017; $year <= $currentYear; $year++) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                            @endphp
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" id="type" name="type" required disabled>
                            <option value="" disabled selected>Select Type</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
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
                    <h5 class="modal-title" id="deleteTypeContractModalLabel">Delete</h5>
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

        function populateSelect(selectElement, options, selectedValue = null) {
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
                if (option.U_SOL_PK === selectedValue) {
                    optionElement.selected = true;
                }
                selectElement.appendChild(optionElement);
            });
        }

        // Edit Type Contract Modal
        var editTypeContractModal = document.getElementById('editTypeContractModal');
        editTypeContractModal.addEventListener('show.bs.modal', async function (event) {
            var button = event.relatedTarget;

            // Get data attributes from the button
            var id = button.getAttribute('data-id');
            var code = button.getAttribute('data-code');
            var title = button.getAttribute('data-title');
            var year = button.getAttribute('data-year');
            var type = button.getAttribute('data-type');
            var price = button.getAttribute('data-price');

            // Populate the form inputs with the data
            document.getElementById('code').value = code;
            document.getElementById('price').value = price;

            // Set the selected option for Title
            var titleSelect = document.getElementById('title');
            titleSelect.value = title;

            // Set the selected option for Year
            var yearSelect = document.getElementById('year');
            yearSelect.value = year;

            // Populate and set selected option for Type
            const types = await fetchTypes();
            var typeSelect = document.getElementById('type');
            populateSelect(typeSelect, types, type);

            // Update the form action with the correct URL
            var editTypeContractForm = document.getElementById('editTypeContractForm');
            editTypeContractForm.action = '/master/type-contracts/update/' + id;
        });


          // Delete Type Contract Modal
          var deleteTypeContractModal = document.getElementById('deleteTypeContractModal');
        deleteTypeContractModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var deleteTypeContractForm = document.getElementById('deleteTypeContractForm');
            deleteTypeContractForm.action = '/master/type-contracts/destroy/' + id;
        });

        // Create Modal
        document.getElementById('createModal').addEventListener('show.bs.modal', async function() {
            // Populate Type select on create modal
            const types = await fetchTypes();
            var typeSelect = document.getElementById('type');
            populateSelect(typeSelect, types);
        });

        // Add Field Button
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
