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
                        <button id="exportButtonSum" class="btn btn-success">
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
                        <tr>
                            <th>No</th>
                            <th>Group</th>
                            <th>Keterangan</th>
                            <th>Wilayah</th>
                            <th>Jumlah SPK</th>
                            <!-- <th>KF-00</th> -->
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
                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>GRAND TOTAL</th>
                            <th colspan="1"></th>
                            <th id="total-regions"></th>
                            <th id="total-spk"></th>
                            <th colspan="18"></th>
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
                $('#exportButtonSum').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    
                    if (from && to) {
                        window.location.href = `/reports/export-sum?from=${from}&to=${to}`;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please select both start and end dates',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
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

                $('#typeContractTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route("summary.index") }}',
                        type: 'POST',
                        data: function(d) {
                            d._token = '{{ csrf_token() }}';
                        },
                        complete: function() {
                            Swal.close();
                        },
                        error: function(xhr, error, thrown) {
                            Swal.close(); 
                            Swal.fire({
                                title: 'Error!',
                                text: error,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    columnDefs: [
                        {
                            targets: 0,
                            render: function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        { width: 100, className: 'text-center', targets: 1 }, 
                        { width: 200, className: 'text-left', targets: 2 }, 
                        { width: 250, className: 'text-left', targets: 3 }, 
                        { width: 100, className: 'text-center', targets: 4 }, 
                        // { width: 50, className: 'text-center', targets: 5 }, 
                        { width: 50, className: 'text-center', targets: 5 }, 
                        { width: 50, className: 'text-center', targets: 6 },
                        { width: 50, className: 'text-center', targets: 7 },
                        { width: 50, className: 'text-center', targets: 8 },
                        { width: 50, className: 'text-center', targets: 9 },
                        { width: 50, className: 'text-center', targets: 10 },
                        { width: 50, className: 'text-center', targets: 11 },
                        { width: 60, className: 'text-center', targets: 12 },
                        { width: 60, className: 'text-center', targets: 13 },
                        { width: 60, className: 'text-center', targets: 14 },
                        { width: 60, className: 'text-center', targets: 15 },
                        { width: 60, className: 'text-center', targets: 16 },
                        { width: 60, className: 'text-center', targets: 17 },
                        { width: 60, className: 'text-center', targets: 18 },
                        { width: 60, className: 'text-center', targets: 19 },
                        { width: 60, className: 'text-center', targets: 20 },
                        { width: 60, className: 'text-center', targets: 21 },
                    ],
                    scrollX: true,
                    columns: [
                        { data: null, name: 'no', orderable: false, searchable: false },
                        { data: 'group_name', name: 'group_name' },
                        { data: 'contract_code', name: 'contract_code' },
                        { data: 'region_id', name: 'region_id' },
                        { data: 'total_spk', name: 'total_spk' },
                        // { data: 'kf_00', name: 'kf_00' },
                        { data: 'kf_15', name: 'kf_15' },
                        { data: 'kf_20', name: 'kf_20' },
                        { data: 'kf_23', name: 'kf_23' },
                        { data: 'kf_26', name: 'kf_26' },
                        { data: 'kf_34', name: 'kf_34' },
                        { data: 'kf_50', name: 'kf_50' },
                        { data: 'kf_70', name: 'kf_70' },
                        { data: 'kf_100', name: 'kf_100' },
                        { data: 'kf_120', name: 'kf_120' },
                        { data: 'sd_70', name: 'sd_70' },
                        { data: 'sd_90', name: 'sd_90' },
                        { data: 'sd_120', name: 'sd_120' },
                        { data: 'db_60', name: 'db_60' },
                        { data: 'db_80', name: 'db_80' },
                        { data: 'db_100', name: 'db_100' },
                        { data: 'db_150', name: 'db_150' },
                        { data: 'db_200', name: 'db_200' },
                        { 
                            data: 'total_biaya', 
                            name: 'total_biaya',
                            render: function(data, type, row) {
                                return new Intl.NumberFormat('id-ID').format(data);
                            }
                        }
                    ],
                    
                    drawCallback: function() {
                        var api = this.api();

                        var totalHarga = api
                            .column(22, { page: 'current' })
                            .data()
                            .reduce(function(a, b) {
                                return a + parseFloat(b.replace(/[\$,]/g, '')) || 0;
                            }, 0);

                        var uniqueRegions = new Set(api
                            .column(3, { page: 'current' })
                            .data()
                            .toArray()
                        );

                        $(api.column(4).footer()).html('{{$totalSpk}}' + ' SPK');
                        $(api.column(22).footer()).html(new Intl.NumberFormat('id-ID').format({{ $total }}));
                        $(api.column(3).footer()).html('{{$wilayah}}' + ' Wilayah');
                    }
                });


            });
        });

    </script>
@endsection