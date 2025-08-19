@extends('layouts.main')

<title>LIST SEWA | Laporan Habis Sewa</title>

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
                    <h4 class="mb-sm-0 font-size-18">Laporan</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan Habis Sewa</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col">
                        <label for="">PERIODE TGL HABIS SEWA</label>
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
                        <button id="exportButtonReportHabis" class="btn btn-success"><i class="fa fa-filter"></i> Submit</button>
                    </div>
                </div>
            </div>
        </div>
        
     </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('#exportButtonReportHabis').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    
                    if (from && to) {
                        window.location.href = `/reports/export-sewa-habis?from=${from}&to=${to}`;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silakan pilih tanggal awal dan akhir',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

            });
        });


    </script>
@endsection