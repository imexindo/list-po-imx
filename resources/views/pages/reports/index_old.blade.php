@extends('layouts.main')

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
                            <th>Keterangan</th>
                            <th>Tahun</th>
                            <th>Jumlah SPK</th>
                            <th>KF-00</th>
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
                                <td>{{ $report->contract->title }} </td>
                                <td>{{ $report->contract->year }}</td>
                                <td>{{ $report->total_spk }} SPK</td>
                                <td>{{ $report->kf_00 }}</td>
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
                                <td>{{ $report->total_biaya }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">GRAND TOTAL</th>
                            <th id="total-spk"></th> 
                            <th colspan="18"></th>
                            <th id="total-harga">0</th>
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
                        window.location.href = `/reports/export-report?from=${from}&to=${to}`;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silakan pilih tanggal awal dan akhir',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
                })


            var table = $('#typeContractTable').DataTable({
                scrollX: true,
                columnDefs: [
                    { width: '5%', targets: 0 },
                    { width: 200, targets: 1 },
                    { width: 50, targets: 2 },
                    { width: 100, className: 'text-center', targets: 3 },
                    { width: 70, className: 'text-center', targets: [4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21] },
                    { width: 100, targets: 22 }
                ],
                drawCallback: function() {
                    var api = this.api();

                    var totalSPK = api
                        .column(3, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return a + parseInt(b) || 0;
                        }, 0);

                        
                    var totalHarga = api
                        .column(22, { page: 'current' })
                        .data()
                        .reduce(function(a, b) {
                            return a + parseFloat(b.replace(/[\$,]/g, '')) || 0;
                        }, 0);

                    $(api.column(3).footer()).html('{{$totalSpk}}' + ' SPK');
                    $(api.column(22).footer()).html('{{ number_format($total, 0, ',', '.') }}');
                }
            });

        });
        </script>
@endsection