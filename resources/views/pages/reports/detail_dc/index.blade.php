@extends('layouts.main')

<title>LIST SEWA | Laporan Toko | SPK</title>

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

    table.dataTable {
        white-space: nowrap;
    }
</style>

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">{{ $data->first()->cardname }} | {{ $data->first()->contract->code }}</h4>
                    <input type="hidden" id="contacts_id" value="{{ $data->first()->contract->id }}">
                    <input type="hidden" id="region_id" value="{{ $data->first()->region_id }}">
                    <input type="hidden" id="from" value="{{ $from }}">
                    <input type="hidden" id="to" value="{{ $to }}">

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Report</li>
                            <li class="breadcrumb-item active">Toko</li>
                            <li class="breadcrumb-item active">Dc</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-11">
                <div class="row">
                    <div class="col">
                        <button id="exportButtonReportDc" class="btn btn-primary">
                            <i class="fa fa-file-excel"></i> EXPORT
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">

                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        {{-- <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">

                <table id="contractReportTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
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
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($item->tagihan === 1)
                                        <span class="badge text-bg-primary"><i class="fa fa-check"></i> Aktif</span>
                                    @elseif($item->tagihan === null)
                                        <span class="badge text-bg-secondary">No Keterangan</span>
                                    @elseif($item->tagihan === 0)
                                        <span class="badge text-bg-danger"><i class="fa fa-close"></i> Non Aktif</span>
                                    @else
                                        <span class="badge text-bg-secondary"><i class="fa fa-close"></i> -</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($item->is_expired)
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif($item->remaining_months === null)
                                        <span class="badge bg-secondary fw-light">No Ket</span>
                                    @else
                                        <span class="badge bg-primary fw-light">{{ $item->remaining_months }} Bulan</span>
                                    @endif
                                </td>
                                <td>{{ $item->total_pk }}</td>
                                <td>{{ $item->total_sap }}</td>
                                <td>{{ $item->tgl_bap }}</td>
                                <td>{{ $item->spk }}</td>
                                <td>{{ $item->tgl_cabut ?? '-' }}</td>
                                <td>{{ $item->category ? $item->category->category : '-' }}</td>
                                <td>{{ $item->tgl_habis_sewa }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->so }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->dc }}</td>
                                <td>{{ $item->kode_idm }}</td>
                                <td>{{ $item->tipe }}</td>
                                <td>{{ $item->ref ?? '-' }}</td>
                                <td>{{ $item->lok }}</td>
                                <td>{{ $item->contract ? $item->contract->code : '-' }} </td>
                                <td>{{ $item->cardname }}</td>
                                <td>{{ $item->group_name }}</td>
                                <td>{{ $item->ruangan ?? '-' }}</td>
                                <td>{{ Str::limit($item->keterangan, 50) ?? '-' }}</td>
                                <td>{{ $item->kf_15 }}</td>
                                <td>{{ $item->kf_20 }}</td>
                                <td>{{ $item->kf_23 }}</td>
                                <td>{{ $item->kf_26 }}</td>
                                <td>{{ $item->kf_34 }}</td>
                                <td>{{ $item->kf_50 }}</td>
                                <td>{{ $item->kf_70 }}</td>
                                <td>{{ $item->kf_100 }}</td>
                                <td>{{ $item->kf_120 }}</td>
                                <td>{{ $item->sd_70 }}</td>
                                <td>{{ $item->sd_90 }}</td>
                                <td>{{ $item->sd_120 }}</td>
                                <td>{{ $item->db_60 }}</td>
                                <td>{{ $item->db_80 }}</td>
                                <td>{{ $item->db_100 }}</td>
                                <td>{{ $item->db_150 }}</td>
                                <td>{{ $item->db_200 }}</td>
                                <td>{{ Str::limit($item->ket, 50) ?? '-' }} </td>
                                <td>{{ Str::limit($item->alamat, 50) }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>{{ $item->updated_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">TOTAL:</th>
                            <th>{{ number_format($data->sum('total_pk'), 0, ',', '.') }}</th>
                            <th>{{ number_format($data->sum('total_sap'), 0, ',', '.') }}</th>
                            <th></th>
                            <th>{{ $data->count('total_spk') }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{ $data->sum('kf_15') }}</th>
                            <th>{{ $data->sum('kf_20') }}</th>
                            <th>{{ $data->sum('kf_23') }}</th>
                            <th>{{ $data->sum('kf_26') }}</th>
                            <th>{{ $data->sum('kf_34') }}</th>
                            <th>{{ $data->sum('kf_50') }}</th>
                            <th>{{ $data->sum('kf_70') }}</th>
                            <th>{{ $data->sum('kf_100') }}</th>
                            <th>{{ $data->sum('kf_120') }}</th>
                            <th>{{ $data->sum('sd_70') }}</th>
                            <th>{{ $data->sum('sd_90') }}</th>
                            <th>{{ $data->sum('sd_120') }}</th>
                            <th>{{ $data->sum('db_60') }}</th>
                            <th>{{ $data->sum('db_80') }}</th>
                            <th>{{ $data->sum('db_100') }}</th>
                            <th>{{ $data->sum('db_150') }}</th>
                            <th>{{ $data->sum('db_200') }}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#contractReportTable').DataTable({
                scrollX: true,
                columnDefs: [{
                        targets: 0,
                        width: '40px'
                    }, // #
                    {
                        targets: 1,
                        width: '120px'
                    }, // Tagihan
                    {
                        targets: 2,
                        width: '90px'
                    }, // Status
                    {
                        targets: 3,
                        width: '100px'
                    }, // TOTAL
                    {
                        targets: 4,
                        width: '100px'
                    }, // TOTAL SAP
                    {
                        targets: 5,
                        width: '100px'
                    }, // Tgl BAP
                    {
                        targets: 6,
                        width: '80px'
                    }, // SPK
                    {
                        targets: 7,
                        width: '110px'
                    }, // Tgl Cabut
                    {
                        targets: 8,
                        width: '120px'
                    }, // Ket Cabut
                    {
                        targets: 9,
                        width: '130px'
                    }, // Tgl Habis Sewa
                    {
                        targets: 10,
                        width: '90px'
                    }, // Kode Toko
                    {
                        targets: 11,
                        width: '80px'
                    }, // SO
                    {
                        targets: 12,
                        width: '200px'
                    }, // Nama
                    {
                        targets: 13,
                        width: '60px'
                    }, // DC
                    {
                        targets: 14,
                        width: '100px'
                    }, // KODE IDM
                    {
                        targets: 15,
                        width: '80px'
                    }, // Tipe
                    {
                        targets: 16,
                        width: '100px'
                    }, // Ref
                    {
                        targets: 17,
                        width: '80px'
                    }, // Lok
                    {
                        targets: 18,
                        width: '120px'
                    }, // Contract
                    {
                        targets: 19,
                        width: '100px'
                    }, // Wilayah
                    {
                        targets: 20,
                        width: '120px'
                    }, // Group
                    {
                        targets: 21,
                        width: '100px'
                    }, // Ruangan
                    {
                        targets: 22,
                        width: '150px'
                    }, // Keterangan
                    {
                        targets: 23,
                        width: '70px'
                    }, // KF-15
                    {
                        targets: 24,
                        width: '70px'
                    }, // KF-20
                    {
                        targets: 25,
                        width: '70px'
                    }, // KF-23
                    {
                        targets: 26,
                        width: '70px'
                    }, // KF-26
                    {
                        targets: 27,
                        width: '70px'
                    }, // KF-34
                    {
                        targets: 28,
                        width: '70px'
                    }, // KF-50
                    {
                        targets: 29,
                        width: '70px'
                    }, // KF-70
                    {
                        targets: 30,
                        width: '70px'
                    }, // KF-100
                    {
                        targets: 31,
                        width: '70px'
                    }, // KF-120
                    {
                        targets: 32,
                        width: '70px'
                    }, // SD-70
                    {
                        targets: 33,
                        width: '70px'
                    }, // SD-90
                    {
                        targets: 34,
                        width: '70px'
                    }, // SD-120
                    {
                        targets: 35,
                        width: '70px'
                    }, // DB-60
                    {
                        targets: 36,
                        width: '70px'
                    }, // DB-80
                    {
                        targets: 37,
                        width: '70px'
                    }, // DB-100
                    {
                        targets: 38,
                        width: '70px'
                    }, // DB-150
                    {
                        targets: 39,
                        width: '70px'
                    }, // DB-200
                    {
                        targets: 40,
                        width: '150px'
                    }, // Ket
                    {
                        targets: 41,
                        width: '250px'
                    }, // Alamat
                    {
                        targets: 42,
                        width: '120px'
                    }, // Dibuat
                    {
                        targets: 43,
                        width: '120px'
                    } // Dirubah
                ]
            });

            $('#exportButtonReportDc').on('click', function() {
                let contactsId = $('#contacts_id').val();
                let regionId = $('#region_id').val();
                let from = $('#from').val();
                let to = $('#to').val();

                let url = `/reports/details/toko/${contactsId}/${regionId}/export`;

                if (from && to) {
                    url += `?from=${encodeURIComponent(from)}&to=${encodeURIComponent(to)}`;
                }

                window.location.href = url;
                Swal.close();
            });

        });
    </script>
@endsection
