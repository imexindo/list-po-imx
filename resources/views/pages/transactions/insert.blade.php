@extends('layouts.main')

<title>LIST SEWA | Input Kontrak AC</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

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

    .pk-label {
        font-size: 11px;
    }

    .pk-input {
        text-align: center
    }

    .col-so {
        width: 10rem !important;
    }

    .col-spk {
        width: 15rem !important;
    }

    .col-bap {
        width: 9rem !important;
    }

    .col-kode {
        width: 10rem !important;
    }
</style>


@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Transaksi</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Transaksi</li>
                            <li class="breadcrumb-item active">Input Kontrak AC</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col">
                        <label for="">PERIODE TGL BAP</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="from">Dari</label>
                        <input type="date" id="start_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label for="to">Sampai</label>
                        <input type="date" id="end_date" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tagihan">Status</label>
                            <select class="form-control" name="tagihan" id="tagihan">
                                <option value="{{ null }}">All</option>
                                <option value="1">Aktif</option>
                                <option value="0">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="btnFilter" class="btn btn-primary">
                            <i class="fa fa-filter"></i>
                            Filter</button>
                    </div>
                </div>
            </div>

            @role(['superadministrator', 'staff', 'Manager'])
                <div class="col-md-4">
                    <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                        <div>
                            <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i
                                    class="bx bx-plus me-1"></i> Tambah</button>
                        </div>
                    </div>
                </div>
            @endrole()


        </div>

        <div class="row mt-4">
                <div class="col-md-12 mb-4">
                    @role(['superadministrator', 'staff', 'Manager'])
                        <button id="updateButton" class="btn btn-danger" style="display: none;">Stop Tagih</button>
                    @endrole
                </div>
            <div class="col-md-12">
                <table id="contractTable" class="table table-striped">
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="display: flex; align-items: center; justify-content: space-between;">
                                <p style="margin: 0;">Actions</p>
                                <input type="checkbox" id="selectAllCheckbox" class="form-check-input"
                                    style="width: 27px; height: 27px; border: 1px solid #333;" />
                            </th>
                            <th>Tagihan</th>
                            <th>Status</th>
                            <th>TOTAL</th>
                            <th>TOTAL SAP</th>
                            <th>Tgl BAP</th>
                            <th>SPK</th>
                            <th>Tgl Cabut</th>
                            <th>Ket Cabut</th>
                            <th>Tgl Habis Sewa</th>
                            <th>Kode Toko</th>
                            <th>SO</th>
                            <th>Nama</th>
                            <th>DC</th>
                            <th>KODE IDM</th>
                            <th>Tipe</th>
                            <th>Ref</th>
                            <th>Lok</th>
                            <th>Contract</th>
                            <th>Wilayah</th>
                            <th>Group</th>
                            <th>Ruangan</th>
                            <th>Keterangan</th>
                            <th><span class="badge bg-secondary">KF-15</span></th>
                            <th><span class="badge bg-success">KF-20</span></th>
                            <th><span class="badge bg-danger">KF-23</span></th>
                            <th><span class="badge bg-warning">KF-26</span></th>
                            <th><span class="badge bg-info">KF-34</span></th>
                            <th><span class="badge bg-light text-dark">KF-50</span></th>
                            <th><span class="badge bg-dark">KF-70</span></th>
                            <th><span class="badge bg-primary">KF-100</span></th>
                            <th><span class="badge bg-secondary">KF-120</span></th>
                            <th><span class="badge bg-success">SD-70</span></th>
                            <th><span class="badge bg-danger">SD-90</span></th>
                            <th><span class="badge bg-warning">SD-120</span></th>
                            <th><span class="badge bg-info">DB-60</span></th>
                            <th><span class="badge bg-light text-dark">DB-80</span></th>
                            <th><span class="badge bg-dark">DB-100</span></th>
                            <th><span class="badge bg-primary">DB-150</span></th>
                            <th><span class="badge bg-secondary">DB-200</span></th>
                            <th>Ket</th>
                            <th>Alamat</th>
                            <th>Dibuat</th>
                            <th>Dirubah</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- INSERT --}}
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form id="spkForm" action="{{ route('insert-contract.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Add</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-10">
                                <div class="mb-3">
                                    <label for="title" class="form-label">NO SPK</label>
                                    <input type="text" class="form-control" name="title" id="spkInput" required
                                        placeholder="Masukan No SPK">
                                </div>
                            </div>
                            <div class="col mt-4">
                                <button type="button" id="cekSpkBtn" class="btn btn-success px-3 py-3">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div id="spkSearch" class="mt-1"></div>
                        <div id="spkResults" class="mt-3"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="tagihan">Tagihan</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="tagihan" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="tagihans"
                                            name="tagihan" value="1"
                                            style="height: 25px; width: 60px; margin-right: 10px;">
                                        <label class="form-check-label" for="tagihan">
                                            <span id="tagihanStatus">Non Aktif</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="tgl_bap" class="form-label">TGL BAP</label>
                                    <input type="text" class="form-control" id="tgl_bap" name="tgl_bap" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="kode" class="form-label">Kode</label>
                                    <input type="text" class="form-control" id="kode" name="kode" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="spk" class="form-label">SPK</label>
                                    <input type="text" class="form-control" id="spk" name="spk" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="Total_PK" class="form-label">Total</label>
                                    <input type="text" class="form-control" id="Total_PK" name="total_pk" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="kode_idm" class="form-label">Kode IDM</label>
                                    <input type="text" class="form-control" id="kode_idm" name="kode_idm">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="tgl_habis_sewa" class="form-label">Tgl Habis Sewa</label>
                                    <input type="date" class="form-control" id="tgl_habis_sewa"
                                        name="tgl_habis_sewa">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-2">
                                    <label for="tgl_cabut" class="form-label">Tgl Cabut</label>
                                    <input type="date" class="form-control" id="tgl_cabut" name="tgl_cabut">
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label for="">Pilih Keterangan</label>
                                        <select class="form-control" name="category_cabut_id" id="category_cabut_id">
                                            <option>Pilih</option>
                                            @foreach ($categoryCabut as $item)
                                                <option value="{{ $item->id }}">{{ $item->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="files">Upload Dokumen</label>
                                    <input type="file" class="form-control mb-1" name="files" id="files">
                                    <a id="filePath" href="#" target="_blank" style="display: none;">Lihat
                                        File</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="KF-15" class="form-label pk-label">KF-15</label>
                                    <input type="text" class="form-control" id="KF-15" name="kf_15">
                                </div>
                                <div class="col">
                                    <label for="KF-20" class="form-label pk-label">KF-20</label>
                                    <input type="text" class="form-control" id="KF-20" name="kf_20">
                                </div>
                                <div class="col">
                                    <label for="KF-23" class="form-label pk-label">KF-23</label>
                                    <input type="text" class="form-control" id="KF-23" name="kf_23">
                                </div>
                                <div class="col">
                                    <label for="KF-26" class="form-label pk-label">KF-26</label>
                                    <input type="text" class="form-control" id="KF-26" name="kf_26">
                                </div>
                                <div class="col">
                                    <label for="KF-26" class="form-label pk-label">KF-34</label>
                                    <input type="text" class="form-control" id="KF-34" name="kf_34">
                                </div>
                                <div class="col">
                                    <label for="KF-15" class="form-label pk-label">KF-50</label>
                                    <input type="text" class="form-control" id="KF-50" name="kf_50">
                                </div>
                                <div class="col">
                                    <label for="KF-20" class="form-label pk-label">KF-70</label>
                                    <input type="text" class="form-control" id="KF-70" name="kf_70">
                                </div>
                                <div class="col">
                                    <label for="KF-23" class="form-label pk-label">KF-100</label>
                                    <input type="text" class="form-control" id="KF-100" name="kf_100">
                                </div>
                                <div class="col">
                                    <label for="KF-120" class="form-label pk-label">KF-120</label>
                                    <input type="text" class="form-control" id="KF-120" name="kf_120">
                                </div>
                                <div class="col">
                                    <label for="SD-70" class="form-label pk-label">SD-70</label>
                                    <input type="text" class="form-control" id="SD-70" name="sd_70">
                                </div>
                                <div class="col">
                                    <label for="SD-90" class="form-label pk-label">SD-90</label>
                                    <input type="text" class="form-control" id="SD-90" name="sd_90">
                                </div>
                                <div class="col">
                                    <label for="SD-120" class="form-label pk-label">SD-120</label>
                                    <input type="text" class="form-control" id="SD-120" name="sd_120">
                                </div>
                                <div class="col">
                                    <label for="DB-60" class="form-label pk-label">DB-60</label>
                                    <input type="text" class="form-control" id="DB-60" name="db_60">
                                </div>
                                <div class="col">
                                    <label for="DB-80" class="form-label pk-label">DB-80</label>
                                    <input type="text" class="form-control" id="DB-80" name="db_80">
                                </div>
                                <div class="col">
                                    <label for="DB-100" class="form-label pk-label">DB-100</label>
                                    <input type="text" class="form-control" id="DB-100" name="db_100">
                                </div>
                                <div class="col">
                                    <label for="DB-150" class="form-label pk-label">DB-150</label>
                                    <input type="text" class="form-control" id="DB-150" name="db_150">
                                </div>
                                <div class="col">
                                    <label for="DB-200" class="form-label pk-label">DB-200</label>
                                    <input type="text" class="form-control" id="DB-200" name="db_200">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <label for="masterContract" class="form-label">Contract</label>
                                <select id="masterContract" name="contract_id" class="form-select" required>
                                    <option value="">-----Pilih Contract-----</option>
                                    @foreach ($masterContracts as $contract)
                                        <option value="{{ $contract->id }}">{{ $contract->code }} - {{ $contract->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="region_id">DC</label>
                                    <select class="form-select" name="region_id" id="region_id" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($dc as $item)
                                            <option value="{{ $item['cardcode'] }}">{{ $item['CardName'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="group_name" class="form-label">Group</label>
                                <select id="group_name" name="group_name" class="form-select" required>
                                    <option value="">-----Pilih Group-----</option>
                                    @foreach ($groupedDataDcGroup as $item)
                                        <option value="{{ $item['GroupName'] }}"> {{ $item['GroupName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="ruangan">Ruangan</label>
                                    <textarea name="ruangan" id="ruangan" cols="10" rows="2" class="form-control"
                                        placeholder="Berikan Keterangan Ruangan"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" cols="10" rows="10" class="form-control"
                                        placeholder="Berikan Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @role(['superadministrator', 'staff', 'Manager'])
                            <button type="submit" class="btn btn-primary">Update</button>
                        @endrole
                    </div>
                </div>

            </form>
        </div>
    </div>


    <script>
        document.getElementById('spkInput').addEventListener('input', async function() {
            const spk = this.value;

            if (spk.length >= 1) {
                try {
                    const response = await fetch('{{ env('SAP_API') }}/api/searchspk', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            spk
                        })
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }

                    const data = await response.json();

                    const resultsContainer = document.getElementById('spkSearch');
                    resultsContainer.innerHTML = '';

                    if (data.length > 0) {

                        data.forEach(item => {
                            const resultItem = document.createElement('div');
                            resultItem.classList.add('spk-result-item');
                            resultItem.textContent =
                                item;
                            resultItem.style.cursor = 'pointer';

                            resultItem.addEventListener('click', () => {
                                document.getElementById('spkInput').value =
                                    item;
                                resultsContainer.innerHTML =
                                    '';
                            });

                            resultsContainer.appendChild(resultItem);
                        });
                    } else {
                        resultsContainer.textContent = 'No SPK found.';
                    }
                } catch (error) {
                    console.error('Error fetching SPK:', error);
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            event.preventDefault();

            $(document).ready(function() {

                $('#contractTable').on('click', '.edit-btn', function() {
                    const id = $(this).data('id');

                    $.ajax({
                        url: `{{ route('api.contracts.show', '') }}/${id}`,
                        method: 'GET',
                        success: function(data) {

                            $('#Total_PK').val(new Intl.NumberFormat('id-ID', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }).format(data.total_pk));
                            $('#kode_idm').val(data.kode_idm);
                            $('#keterangan').val(data.keterangan);
                            $('#ruangan').val(data.ruangan);
                            $('#region_id').val(data.region_id);
                            $('#tgl_cabut').val(data.tgl_cabut);
                            $('#category_cabut_id').val(data.category_cabut_id);
                            $('#kode').val(data.kode);
                            $('#nama').val(data.nama);
                            $('#group_name').val(data.group_name);
                            $('#masterContract').val(data.contract_id);
                            $('#tgl_habis_sewa').val(data.tgl_habis_sewa);
                            $('#spk').val(data.spk);

                            if (data.files) {
                                let fileUrl = `/storage/${data.files}`;
                                $('#filePath').attr('href', fileUrl).text('Lihat File')
                                    .show();
                            } else {
                                $('#filePath').hide();
                            }

                            $('#tgl_bap').val(new Date(data.tgl_bap).toLocaleDateString(
                                'id-ID', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                }));
                            $('#KF-15').val(data.kf_15 ? data.kf_15 : '0');
                            $('#KF-20').val(data.kf_20 ? data.kf_20 : '0');
                            $('#KF-23').val(data.kf_23 ? data.kf_23 : '0');
                            $('#KF-26').val(data.kf_26 ? data.kf_26 : '0');
                            $('#KF-34').val(data.kf_34 ? data.kf_34 : '0');
                            $('#KF-50').val(data.kf_50 ? data.kf_50 : '0');
                            $('#KF-70').val(data.kf_70 ? data.kf_70 : '0');
                            $('#KF-100').val(data.kf_100 ? data.kf_100 : '0');
                            $('#KF-120').val(data.kf_120 ? data.kf_120 : '0');
                            $('#SD-70').val(data.sd_70 ? data.sd_70 : '0');
                            $('#SD-90').val(data.sd_90 ? data.sd_90 : '0');
                            $('#SD-120').val(data.sd_120 ? data.sd_120 : '0');
                            $('#DB-60').val(data.db_60 ? data.db_60 : '0');
                            $('#DB-80').val(data.db_80 ? data.db_80 : '0');
                            $('#DB-100').val(data.db_100 ? data.db_100 : '0');
                            $('#DB-150').val(data.db_150 ? data.db_150 : '0');
                            $('#DB-200').val(data.db_200 ? data.db_200 : '0');

                            // Set checkbox status and update label
                            $('#tagihans').prop('checked', data.tagihan == 1);

                            $('#tagihanStatus').text(data.tagihan == 1 ? 'Aktif' :
                                'Non Aktif');

                            $('#editForm').attr('action',
                                `{{ route('insert-contract.update', '') }}/${id}`);
                            $('#editForm').append(
                                '<input type="hidden" name="_method" value="PUT">');

                            $('#editModal').modal('show');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to load data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

                $('#editForm').on('submit', function(event) {
                    event.preventDefault();

                    // Tampilkan Swal loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    var formData = new FormData(this);

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            Swal.close();
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil diperbarui.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.close(); // Tutup loading
                            Swal.fire({
                                title: 'Kesalahan!',
                                text: 'Gagal memperbarui data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });

                $('#editModal').on('hidden.bs.modal', function() {
                    $('#editForm').trigger("reset");
                    $('#editForm input[name="_method"]').remove();
                    $('#editForm').attr('action', '{{ route('insert-contract.store') }}');
                });

                Swal.fire({
                    title: 'Loading...',
                    text: 'Please wait data',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                let table = $('#contractTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    ajax: {
                        url: '{{ route('api.contracts') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function(d) {
                            var from = $('#start_date').val();
                            var to = $('#end_date').val();
                            var tagihan = $('#tagihan').val();

                            return $.extend({}, d, {
                                start_date: from,
                                end_date: to,
                                tagihan: tagihan
                            });
                        },
                        complete: function() {
                            Swal.close();
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to load data.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    columnDefs: [{
                            width: 20,
                            className: 'text-center',
                            targets: 0
                        },
                        {
                            width: 100,
                            className: 'text-center',
                            targets: 1
                        },
                        {
                            width: 20,
                            className: 'text-center',
                            targets: 2
                        },
                        {
                            width: 100,
                            className: 'text-center',
                            targets: 3
                        },
                        {
                            width: 100,
                            className: 'text-center',
                            targets: 4
                        },
                        {
                            width: 100,
                            className: 'text-center',
                            targets: 5
                        },
                        {
                            width: 150,
                            className: 'text-center',
                            targets: 6
                        },
                        {
                            width: 450,
                            targets: 7
                        },
                        {
                            width: 100,
                            className: 'text-center',
                            targets: 8
                        },
                        {
                            width: 110,
                            className: 'text-center',
                            targets: 9
                        },
                        {
                            width: 150,
                            className: 'text-center',
                            targets: 10
                        },
                        {
                            width: 150,
                            className: 'text-center',
                            targets: 11
                        },
                        {
                            width: 100,
                            targets: 12
                        },
                        {
                            width: 200,
                            targets: 13
                        },

                        {
                            width: 200,
                            targets: 14
                        },
                        {
                            width: 150,
                            className: 'text-center',
                            targets: 15
                        },
                        // { width: 300, targets: 14 }, // Commented out duplicate target 14
                        {
                            width: 150,
                            targets: 16
                        },
                        {
                            width: 350,
                            targets: 17
                        },
                        {
                            width: 10,
                            className: 'text-center',
                            targets: 18
                        },
                        {
                            width: 50,
                            className: 'text-center',
                            targets: 19
                        },
                        {
                            width: 250,
                            targets: 20
                        },
                        {
                            width: 10,
                            targets: 21
                        },
                        {
                            width: 200,
                            targets: 22
                        },
                        {
                            width: 350,
                            targets: 23
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 24
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 25
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 26
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 27
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 28
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 29
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 30
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 31
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 32
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 33
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 34
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 35
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 36
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 37
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 38
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 39
                        },
                        {
                            width: 60,
                            className: 'text-center',
                            targets: 40
                        },
                        {
                            width: 400,
                            className: 'text-left',
                            targets: 41
                        },
                        {
                            width: 400,
                            targets: 42
                        },
                        {
                            width: 200,
                            className: 'text-center',
                            targets: 43
                        },
                        {
                            width: 200,
                            className: 'text-center',
                            targets: 44
                        }
                    ],
                    scrollX: true,
                    columns: [{
                            data: null,
                            render: (data, type, row, meta) => meta.row + 1
                        },
                        {
                            data: 'tagihan',
                            render: function(data, type, row) {
                                return `
                                    <div class="d-flex align-items-center justify-content-between" style="margin-left: 16px;">
                                        <button class="btn btn-success btn-sm edit-btn" data-id="${row.id}" style="padding: 8px;">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        ${data === 1 ? `<input type="checkbox" class="form-check-input" data-id="${row.id}" style="border: 1px solid #333; width: 27px; height: 27px; margin-left: 16px;">` : ''}
                                    </div>`;
                            }
                        },
                        {
                            data: 'tagihan',
                            render: function(data) {
                                if (data === 1) {
                                    return '<span class="badge text-bg-primary"><i class="fa fa-check"></i> Aktif</span>';
                                } else if (data === null) {
                                    return '<span class="badge text-bg-secondary">No Keterangan</span>';
                                } else if (data === 0) {
                                    return '<span class="badge text-bg-danger"><i class="fa fa-close"></i> Non Aktif</span>';
                                } else {
                                    return '<span class="badge text-bg-secondary"><i class="fa fa-close"></i>-</span>';
                                }
                            }
                        },
                        {
                            data: 'is_expired',
                            render: function(data, type, row) {
                                if (data) {
                                    return '<span class="badge bg-danger">Expired</span>';
                                } else if (row.remaining_months == null) {
                                    return '<span class="badge bg-secondary fw-light">No Ket</span>';
                                } else {
                                    return '<span class="badge bg-primary fw-light">' + row
                                        .remaining_months + ' Bulan</span>';
                                }
                            }
                        },
                        {
                            data: 'total_pk',
                            render: function(data) {
                                return new Intl.NumberFormat('id-ID', {
                                    // style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                            }
                        },
                        {
                            data: 'total_sap',
                            render: function(data) {
                                return new Intl.NumberFormat('id-ID', {
                                    // style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                            }
                        },
                        {
                            data: 'tgl_bap',
                            render: function(data) {
                                return data ? new Date(data).toLocaleString('id-ID', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                }) : '-';
                            }
                        },
                        {
                            data: 'spk',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 40) {
                                    return `<span class="anpwp-short">${data.substring(0, 40)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },

                        {
                            data: 'tgl_cabut',
                            render: function(data) {
                                return data ? new Date(data).toLocaleString('id-ID', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                }) : '-';
                            }
                        },
                        {
                            data: 'category.category',
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'tgl_habis_sewa',
                            render: function(data) {
                                return data ? new Date(data).toLocaleString('id-ID', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                }) : '-';
                            }
                        },
                        {
                            data: 'kode'
                        },
                        {
                            data: 'so'
                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'dc',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 16) {
                                    return `<span class="anpwp-short">${data.substring(0, 16)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },
                        {
                            data: 'kode_idm',
                            render: function(data, type, row) {
                                return data ? data : '';
                            }
                        },
                        // {
                        //     data: 'alamat',
                        //     render: function(data, type, row, meta) {
                        //         if (data && data.length > 20) {
                        //             return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                    //                 <span class="anpwp-full" style="display:none;">${data}</span>
                    //                 <a href="#" class="toggle-anpwp">Show</a>`;
                        //         }
                        //         return data || '';
                        //     }
                        // },
                        {
                            data: 'tipe'
                        },
                        {
                            data: 'ref',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 20) {
                                    return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '-';
                            }
                        },
                        {
                            data: 'lok'
                        },
                        {
                            data: 'contract.code',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 10) {
                                    return `<span class="anpwp-short">${data.substring(0, 10)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },
                        {
                            data: 'cardname',
                            render: function(data, type, row) {
                                return data ? data : '';
                            }
                        },
                        {
                            data: 'group_name'
                        },
                        {
                            data: 'ruangan'
                        },
                        {
                            data: 'keterangan',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 25) {
                                    return `<span class="anpwp-short">${data.substring(0, 25)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },
                        // { data: 'kf_00' },
                        {
                            data: 'kf_15'
                        },
                        {
                            data: 'kf_20'
                        },
                        {
                            data: 'kf_23'
                        },
                        {
                            data: 'kf_26'
                        },
                        {
                            data: 'kf_34'
                        },
                        {
                            data: 'kf_50'
                        },
                        {
                            data: 'kf_70'
                        },
                        {
                            data: 'kf_100'
                        },
                        {
                            data: 'kf_120'
                        },
                        {
                            data: 'sd_70',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'sd_90',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'sd_120',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'db_60',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'db_80',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'db_100',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'db_150',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'db_200',
                            render: function(data, type, row) {
                                return data ? data : 0;
                            }
                        },
                        {
                            data: 'ket',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 25) {
                                    return `<span class="anpwp-short">${data.substring(0, 25)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },
                        {
                            data: 'alamat',
                            render: function(data, type, row, meta) {
                                if (data && data.length > 30) {
                                    return `<span class="anpwp-short">${data.substring(0, 30)}...</span>
                                        <span class="anpwp-full" style="display:none;">${data}</span>
                                        <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data || '';
                            }
                        },
                        {
                            data: 'created_at',
                            render: data => new Date(data).toLocaleString('id-ID', {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            })
                        },
                        {
                            data: 'updated_at',
                            render: function(data) {
                                return data ? new Date(data).toLocaleString('id-ID', {
                                    year: 'numeric',
                                    month: '2-digit',
                                    day: '2-digit',
                                    hour: '2-digit',
                                    minute: '2-digit',
                                    second: '2-digit'
                                }) : '-';
                            }
                        },

                    ]
                });

                $('#btnFilter').on('click', function() {
                    var from = $('#start_date').val();
                    var to = $('#end_date').val();

                    if (from && to) {
                        table.ajax.reload();
                    } else {
                        Swal.fire({
                            title: 'Warning!',
                            text: 'Please select both start and end dates!',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                // Handle the 'Select All' checkbox
                $('#selectAllCheckbox').on('change', function() {
                    var isChecked = $(this).prop('checked');
                    $('#contractTable').find('input[type="checkbox"]').prop('checked', isChecked)
                        .trigger('change');
                });

                // Handle individual checkbox changes
                $('#contractTable').on('change', 'input[type="checkbox"]', function() {
                    var anyChecked = $('#contractTable').find('input[type="checkbox"]:checked')
                        .length > 0;
                    $('#updateButton').toggle(anyChecked);
                });

                // Handle the 'Update' button click
                $('#updateButton').on('click', function() {
                    var selectedIds = $('#contractTable').find('input[type="checkbox"]:checked')
                        .map(function() {
                            return $(this).data('id');
                        }).get();

                    if (selectedIds.length > 0) {
                        $.ajax({
                            url: '{{ route('contracts.updateTglCabut') }}',
                            method: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                ids: selectedIds,
                                tagihan: '0'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Records updated successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                $('#contractTable').DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to update records.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });


                $(document).on('click', '.toggle-anpwp', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const $short = $this.siblings('.anpwp-short');
                    const $full = $this.siblings('.anpwp-full');

                    if ($full.is(':visible')) {
                        $full.hide();
                        $short.show();
                        $this.text('Show');
                    } else {
                        $full.show();
                        $short.hide();
                        $this.text('Hide');
                    }
                });

                $(document).on('click', '.toggle-type-contracts', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const $short = $this.siblings('.type-contracts-short');
                    const $full = $this.siblings('.type-contracts-full');

                    if ($full.is(':visible')) {
                        $full.hide();
                        $short.show();
                        $this.text('Show');
                    } else {
                        $full.show();
                        $short.hide();
                        $this.text('Hide');
                    }
                });

                const cekSpkBtn = document.getElementById('cekSpkBtn');
                const spkInput = document.getElementById('spkInput');
                const spkResults = document.getElementById('spkResults');
                const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

                if (!csrfTokenMeta) {
                    console.error('CSRF token meta tag is missing.');
                    return;
                }

                const csrfToken = csrfTokenMeta.getAttribute('content');

                cekSpkBtn.addEventListener('click', async function() {
                    const spk = spkInput.value;

                    if (!spk) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please enter a valid SPK.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    try {
                        const response = await fetch('{{ env('SAP_API') }}/api/verifyspk', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                spk
                            })
                        });

                        if (!response.ok) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'SPK Not Found.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        const data = await response.json();

                        if (data.length > 0) {
                            const formHtml = data.map(item => `
                                <form id="spkForm" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-2 col-so">
                                            <label for="SO" class="form-label">SO</label>
                                            <input type="text" class="form-control" id="SO" name="so" value="${item.SO}" readonly>
                                        </div>
                                        <div class="col-2 col-spk">
                                            <label for="SPK" class="form-label">SPK</label>
                                            <input type="text" class="form-control" id="SPK" name="spk" value="${item.SPK}" readonly>
                                        </div>

                                        <div class="col-2 col-bap">
                                            <label for="BAP" class="form-label">BAP</label>
                                            <input type="text" class="form-control" id="BAP" name="bap" value="${new Date(item.BAP).toLocaleDateString('sv-SE')}" readonly>
                                        </div>
                                        <div class="col-1 col-kode">
                                            <label for="Kode" class="form-label">Kode</label>
                                            <input type="text" class="form-control" id="Kode" name="kode" value="${item.Kode}" readonly>
                                        </div>
                                        <div class="col-1">
                                            <label for="Lok" class="form-label">Lok</label>
                                            <input type="text" class="form-control" id="Lok" name="lok" value="${item.Lok}" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="Tipe" class="form-label">Tipe</label>
                                            <input type="text" class="form-control" id="Tipe" name="tipe" value="${item.Tipe}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="Total" class="form-label">Total</label>
                                            <input type="text" class="form-control" id="Total" name="total" value="${item.Total}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">

                                        <div class="col-2">
                                            <label for="Nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="Nama" name="nama" value="${item.Nama}" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="DC" class="form-label">DC</label>
                                            <input type="text" class="form-control" id="DC" name="dc" value="${item.DC}" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="Ref" class="form-label">Ref</label>
                                            <input type="text" class="form-control" id="Ref" name="ref" value="${item.ref}" readonly>
                                        </div>

                                        <div class="col-3">
                                            <label for="NPWP" class="form-label">NPWP</label>
                                            <input type="text" class="form-control" id="NPWP" name="npwp" value="${item.NPWP}" readonly>
                                        </div>
                                        <div class="col-3">
                                            <label for="NNPWP" class="form-label">NNPWP</label>
                                            <input type="text" class="form-control" id="NNPWP" name="nnpwp" value="${item.NNPWP}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="ANPWP" class="form-label">ANPWP</label>
                                            <textarea class="form-control" name="anpwp" id="ANPWP" rows="4" readonly>${item.ANPWP}</textarea>
                                        </div>
                                        <div class="col">
                                            <label for="Alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" name="alamat" id="Alamat" rows="4" readonly>${item.Alamat}</textarea>
                                        </div>
                                        <div class="col">
                                            <label for="Ket" class="form-label">Ket</label>
                                            <textarea class="form-control" name="ket" id="Ket" rows="4" readonly>${item.Ket}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label for="KF-15" class="form-label pk-label">KF-15</label>
                                            <input type="text" class="form-control pk-input" id="KF-15" name="kf_15" value="${item['KF-15']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-20" class="form-label pk-label">KF-20</label>
                                            <input type="text" class="form-control pk-input" id="KF-20" name="kf_20" value="${item['KF-20']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-23" class="form-label pk-label">KF-23</label>
                                            <input type="text" class="form-control pk-input" id="KF-23" name="kf_23" value="${item['KF-23']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-26" class="form-label pk-label">KF-26</label>
                                            <input type="text" class="form-control pk-input" id="KF-26" name="kf_26" value="${item['KF-26']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-26" class="form-label pk-label">KF-34</label>
                                            <input type="text" class="form-control pk-input" id="KF-34" name="kf_34" value="${item['KF-34']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-15" class="form-label pk-label">KF-50</label>
                                            <input type="text" class="form-control pk-input" id="KF-50" name="kf_50" value="${item['KF-50']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-20" class="form-label pk-label">KF-70</label>
                                            <input type="text" class="form-control pk-input" id="KF-70" name="kf_70" value="${item['KF-70']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-23" class="form-label pk-label">KF-100</label>
                                            <input type="text" class="form-control pk-input" id="KF-100" name="kf_100" value="${item['KF-100']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="KF-120" class="form-label pk-label">KF-120</label>
                                            <input type="text" class="form-control pk-input" id="KF-120" name="kf_120" value="${item['KF-120']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="SD-70" class="form-label pk-label">SD-70</label>
                                            <input type="text" class="form-control pk-input" id="SD-70" name="sd_70" value="${item['SD-70'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="SD-90" class="form-label pk-label">SD-90</label>
                                            <input type="text" class="form-control pk-input" id="SD-90" name="sd_90" value="${item['SD-90'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="SD-120" class="form-label pk-label">SD-120</label>
                                            <input type="text" class="form-control pk-input" id="SD-120" name="sd_120" value="${item['SD-120'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="DB-60" class="form-label pk-label">DB-60</label>
                                            <input type="text" class="form-control pk-input" id="DB-60" name="db_60" value="${item['DB-60'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="DB-80" class="form-label pk-label">DB-80</label>
                                            <input type="text" class="form-control pk-input" id="DB-80" name="db_80" value="${item['DB-80'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="DB-100" class="form-label pk-label">DB-100</label>
                                            <input type="text" class="form-control pk-input" id="DB-100" name="db_100" value="${item['DB-100'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="DB-150" class="form-label pk-label">DB-150</label>
                                            <input type="text" class="form-control pk-input" id="DB-150" name="db_150" value="${item['DB-150'] ?? '0'}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="DB-200" class="form-label pk-label">DB-200</label>
                                            <input type="text" class="form-control pk-input" id="DB-200" name="db_200" value="${item['DB-200'] ?? '0'}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-2">
                                            <label for="kode_idm" class="form-label">KODE IDM</label>
                                            <input type="text" class="form-control" id="kode_idm" name="kode_idm" value="${item['Kode_IDM']}" readonly>
                                        </div>
                                        <div class="col-2">
                                            <label for="total_sap" class="form-label">Total SAP</label>
                                            <input type="text" class="form-control" id="total_sap" name="total_sap" value="${item['Total']}" readonly>
                                        </div>
                                        <div class="col">
                                            <label for="masterContract" class="form-label">Contract</label>
                                            <select id="masterContract" name="contract_id" class="form-select">
                                                <option value="">-----Pilih Contract-----</option>
                                                @foreach ($masterContracts as $contract)
                                                    <option value="{{ $contract->id }}">{{ $contract->code }} - {{ $contract->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col">
                                            <label for="region_id" class="form-label">DC</label>
                                            <select id="region_id" name="region_id" class="form-select">
                                                <option value="">-----Pilih DC-----</option>
                                                @foreach ($dc as $item)
                                                    <option value="{{ $item['cardcode'] }}"> {{ $item['CardName'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="group_name" class="form-label">Group</label>
                                            <select id="group_name" name="group_name" class="form-select">
                                                <option value="">-----Pilih Group-----</option>
                                                @foreach ($groupedDataDcGroup as $item)
                                                    <option value="{{ $item['GroupName'] }}"> {{ $item['GroupName'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="type">Ruangan</label>
                                                <textarea name="ruangan" id="ruangan" class="form-control" cols="10" rows="2" placeholder="ruangan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="type">Keterangan</label>
                                                <textarea name="keterangan" id="keterangan" class="form-control" cols="10" rows="5" placeholder="Keterangan"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            `).join('');
                            spkResults.innerHTML = formHtml;
                            try {
                                const kode = data[0].Kode;
                                const editResponse = await fetch(
                                    `{{ url('/transactions/edit-contracts') }}/${kode}`, {
                                        method: 'GET',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': csrfToken
                                        }
                                    });

                                if (!editResponse.ok) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to fetch contract details.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                    return;
                                }

                                const editData = await editResponse.json();

                                let contractDetailsHtml = `
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="mt-4">History Toko</h5>
                                        </div>
                                    </div>
                                `;
                                if (Array.isArray(editData) && editData.length > 0) {
                                    contractDetailsHtml += editData.map(contract => `
                                        <div class="row my-1">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="tgl_bap">Tgl BAP</label>
                                                    <input type="text" class="form-control" id="tgl_bap" name="tgl_bap" value="${new Date(contract.tgl_bap).toLocaleDateString('id-ID', {day: '2-digit', month: '2-digit', year: 'numeric'})}" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="kode">Kode</label>
                                                    <input type="text" class="form-control" id="kode" name="kode" value="${contract.kode}" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>SPK</label>
                                                    <input type="text" class="form-control" id="spk_e" name="spk_e" value="${contract.spk}" readonly>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="tagihan">Tagihan</label>
                                                    <input type="text" class="form-control" id="tagihan" name="tagihan"
                                                        value="${contract.tagihan === 1 ? 'Aktif' : 'Tidak Aktif'}" readonly>
                                                </div>
                                            </div>
                                            <div class="col mt-4">
                                                <div class="form-group">
                                                    <a href="/transactions/insert-contract/spk/${btoa(contract.spk)}" target="_blank" class="btn btn-primary" id="editBtn" data-kode="${contract.spk}">
                                                        Edit <i class="fa fa-paper-plane"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    `).join('');
                                } else {
                                    contractDetailsHtml += `
                                        <div class="row">
                                            <div class="col-12">
                                                <p>Toko belum mempunyai History.</p>
                                            </div>
                                        </div>
                                    `;
                                }

                                spkResults.innerHTML += contractDetailsHtml;

                            } catch (editError) {
                                Swal.fire({
                                    title: 'Failed to Fetch Contract Details',
                                    text: 'Failed to fetch contract details: ' +
                                        editError.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }

                            Swal.fire({
                                title: 'Success!',
                                text: 'Data SAP successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            console.log(n);
                            return
                            Swal.fire({
                                title: 'No Data Found',
                                text: 'No data found for the provided SPK.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                            spkResults.innerHTML = '';
                        }
                    } catch (error) {
                        // console.log(f);
                        //     return
                        Swal.fire({
                            title: 'Failed to Fetch Data',
                            text: 'Failed to fetch data: ' + error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        spkResults.innerHTML = '';
                    }
                });

                $('#spkForm').on('submit', function(event) {
                    event.preventDefault();

                    // Tampilkan Swal loading
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading()
                        }
                    });

                    // AJAX request to submit the form data
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        success: function(data) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data berhasil disimpan.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessages = '';
                                $.each(errors, function(field, messages) {
                                    errorMessages += messages.join(', ') +
                                        '<br>';
                                });
                                Swal.fire({
                                    title: 'Kesalahan Validasi!',
                                    html: errorMessages,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else if (xhr.status === 500) {
                                Swal.fire({
                                    title: 'Kesalahan!',
                                    text: 'SPK sudah ada dalam data transaksi.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Kesalahan!',
                                    text: 'Gagal menyimpan data.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                });


            });

        });
    </script>
@endsection
