@extends('layouts.main')

<title>LIST SEWA | Laporan All Toko</title>


<style>
    /* Optional: Ensure the table container has a width of 100% for scrolling to work */
    .dataTables_wrapper {
        width: 100%;
        overflow-x: auto;
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
                            <li class="breadcrumb-item active">Masukan Kontrak AC</li>
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
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="date" class="form-control" name="from" id="from" aria-describedby="helpId">
                            <small>Dari</small>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="date" class="form-control" name="to" id="to" aria-describedby="helpId">
                            <small>Sampai</small>
                        </div>
                    </div>
                    <div class="col">
                        <button id="exportButtonReport" class="btn btn-success">
                            <i class="fa fa-file-excel"></i>
                            Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <table id="typeContractTable" class="table table-striped">
                    <thead>
                        <tr id="headerRow">
                            <th>No</th>
                            <th></th>
                            <th>Keterangan</th>
                            <th></th>
                            <th>Jumlah SPK</th>
                            <th>KF-15</th>
                            <th>KF-20</th>
                            <th>KF-23</th>
                            <th>KF-26</th>
                            <th>KF-34</th>
                            <th>KF-50</th>
                            <th>KF-70</th>
                            <th>KF-100</th>
                            <th>KF-120</th>
                            <th>SD-70</th>
                            <th>SD-90</th>
                            <th>SD-120</th>
                            <th>DB-60</th>
                            <th>DB-80</th>
                            <th>DB-100</th>
                            <th>DB-150</th>
                            <th>DB-200</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $index => $report)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-id="{{ $report->contract_group->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </td>
                                <td>{{ $report->contract_group->title }} </td>
                                <td></td>
                                <td>{{ $report->total_spk }} SPK</td>
                                <td>{{ $report->kf_15 }}</td>
                                <td>{{ $report->kf_20 }}</td>
                                <td>{{ $report->kf_23 }}</td>
                                <td>{{ $report->kf_26 }}</td>
                                <td>{{ $report->kf_34 }}</td>
                                <td>{{ $report->kf_50 }}</td>
                                <td>{{ $report->kf_70 }}</td>
                                <td>{{ $report->kf_100 }}</td>
                                <td>{{ $report->kf_120 }}</td>
                                <td>{{ $report->sd_70 }}</td>
                                <td>{{ $report->sd_90 }}</td>
                                <td>{{ $report->sd_120 }}</td>
                                <td>{{ $report->db_60 }}</td>
                                <td>{{ $report->db_80 }}</td>
                                <td>{{ $report->db_100 }}</td>
                                <td>{{ $report->db_150 }}</td>
                                <td>{{ $report->db_200 }}</td>
                                <td>{{ number_format($report->total_biaya, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">GRAND TOTAL</th>
                            <th id="total-spk"></th>
                            <th id="total-kf-15"></th>
                            <th id="total-kf-20"></th>
                            <th id="total-kf-23"></th>
                            <th id="total-kf-26"></th>
                            <th id="total-kf-34"></th>
                            <th id="total-kf-50"></th>
                            <th id="total-kf-70"></th>
                            <th id="total-kf-100"></th>
                            <th id="total-kf-120"></th>
                            <th id="total-sd-70"></th>
                            <th id="total-sd-90"></th>
                            <th id="total-sd-120"></th>
                            <th id="total-db-60"></th>
                            <th id="total-db-80"></th>
                            <th id="total-db-100"></th>
                            <th id="total-db-150"></th>
                            <th id="total-db-200"></th>
                            <th id="total-harga">Rp 0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
     </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('#exportButtonReport').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();

                    if (from && to) {
                        window.location.href = `/reports/export-report/all?from=${from}&to=${to}`;
                    } else {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Silakan pilih tanggal BAP awal dan akhir',
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                function format(id) {
                    return `
                        <table class="table table-striped table-info" cellpadding="5" cellspacing="0" border="0" style="margin-left: 15px;">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-left" style="width: 200px;">DC</th>
                                    <th class="text-center">Total SPK</th>
                                    <th class="text-center">KF-15</th>
                                    <th class="text-center">KF-20</th>
                                    <th class="text-center">KF-23</th>
                                    <th class="text-center">KF-26</th>
                                    <th class="text-center">KF-34</th>
                                    <th class="text-center">KF-50</th>
                                    <th class="text-center">KF-70</th>
                                    <th class="text-center">KF-100</th>
                                    <th class="text-center">KF-120</th>
                                    <th class="text-center">SD-70</th>
                                    <th class="text-center">SD-90</th>
                                    <th class="text-center">SD-120</th>
                                    <th class="text-center">DB-60</th>
                                    <th class="text-center">DB-80</th>
                                    <th class="text-center">DB-100</th>
                                    <th class="text-center">DB-150</th>
                                    <th class="text-center">DB-200</th>
                                    <th class="text-center">Total Biaya</th>
                                </tr>
                            </thead>
                            <tbody id="details-${id}">
                                <tr>
                                    <td colspan="19" class="text-center">Tampilkan di sini...</td>
                                </tr>
                            </tbody>
                        </table>
                    `;
                }

                $('#typeContractTable tbody').on('click', 'button', function () {
                    var tr = $(this).closest('tr');
                    var row = table.row(tr);
                    var reportId = $(this).data('id');

                    if (row.child.isShown()) {
                        row.child.hide();
                        tr.removeClass('shown');
                        $(this).find('i').removeClass('fa-minus').addClass('fa-eye');
                    } else {
                        row.child(format(reportId)).show();
                        tr.addClass('shown');
                        $(this).find('i').removeClass('fa-eye').addClass('fa-minus');

                        Swal.fire({
                            title: 'Loading...',
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: `/reports/details/${reportId}`,
                            method: 'GET',
                            success: function(data) {
                                $('#details-' + reportId).html(data.map((item, index) => `
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td class="text-left">${item.region_name}</td>
                                        <td class="text-center">${item.total_spk}</td>
                                        <td class="text-center">${item.kf_15}</td>
                                        <td class="text-center">${item.kf_20}</td>
                                        <td class="text-center">${item.kf_23}</td>
                                        <td class="text-center">${item.kf_26}</td>
                                        <td class="text-center">${item.kf_34}</td>
                                        <td class="text-center">${item.kf_50}</td>
                                        <td class="text-center">${item.kf_70}</td>
                                        <td class="text-center">${item.kf_100}</td>
                                        <td class="text-center">${item.kf_120}</td>
                                        <td class="text-center">${item.sd_70}</td>
                                        <td class="text-center">${item.sd_90}</td>
                                        <td class="text-center">${item.sd_120}</td>
                                        <td class="text-center">${item.db_60}</td>
                                        <td class="text-center">${item.db_80}</td>
                                        <td class="text-center">${item.db_100}</td>
                                        <td class="text-center">${item.db_150}</td>
                                        <td class="text-center">${item.db_200}</td>
                                        <td class="text-center">${new Intl.NumberFormat('id-ID').format(item.total_biaya)}</td>

                                    </tr>
                                `).join(''));
                            },
                            error: function() {
                                $('#details-' + reportId).html('<tr><td colspan="19" class="text-center">Gagal memuat detail</td></tr>');
                            },
                            complete: function() {
                                Swal.close();
                            }
                        });
                    }
                });

                var table = $('#typeContractTable').DataTable({
                    scrollX: true,
                    columnDefs: [
                        { width: '5%', targets: 0 },
                        { width: '10%', targets: 1 },
                        { width: 200, targets: 2 },
                        { width: 50, targets: 3 },
                        { width: 100, className: 'text-center', targets: 4 },
                        { width: 70, className: 'text-center', targets: [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21] },
                        { width: 100, targets: 22 }
                    ],
                    drawCallback: function() {
                        var api = this.api();

                        var totalSPK = api
                            .column(4, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalHarga = api
                            .column(22, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseFloat(b.replace(/[^\d]/g, '')) || 0;
                            }, 0);

                        var totalKF15 = api
                            .column(5, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF20 = api
                            .column(6, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF23 = api
                            .column(7, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF26 = api
                            .column(8, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF34 = api
                            .column(9, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF50 = api
                            .column(10, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF70 = api
                            .column(11, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF100 = api
                            .column(12, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalKF120 = api
                            .column(13, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalSD70 = api
                            .column(14, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalSD90 = api
                            .column(15, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalSD120 = api
                            .column(16, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalDB60 = api
                            .column(17, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalDB80 = api
                            .column(18, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalDB100 = api
                            .column(19, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalDB150 = api
                            .column(20, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        var totalDB200 = api
                            .column(21, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseInt(b) || 0;
                            }, 0);

                        $(api.column(4).footer()).html('{{$totalSpk}}' + ' SPK');
                        $(api.column(22).footer()).html(new Intl.NumberFormat('id-ID').format({{ $total }}));
                        $(api.column(5).footer()).html(totalKF15);
                        $(api.column(6).footer()).html(totalKF20);
                        $(api.column(7).footer()).html(totalKF23);
                        $(api.column(8).footer()).html(totalKF26);
                        $(api.column(9).footer()).html(totalKF34);
                        $(api.column(10).footer()).html(totalKF50);
                        $(api.column(11).footer()).html(totalKF70);
                        $(api.column(12).footer()).html(totalKF100);
                        $(api.column(13).footer()).html(totalKF120);
                        $(api.column(14).footer()).html(totalSD70);
                        $(api.column(15).footer()).html(totalSD90);
                        $(api.column(16).footer()).html(totalSD120);
                        $(api.column(17).footer()).html(totalDB60);
                        $(api.column(18).footer()).html(totalDB80);
                        $(api.column(19).footer()).html(totalDB100);
                        $(api.column(20).footer()).html(totalDB150);
                        $(api.column(21).footer()).html(totalDB200);
                    }
                });
            });
        });


    </script>
@endsection
