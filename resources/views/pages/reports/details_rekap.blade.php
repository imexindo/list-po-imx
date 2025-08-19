@extends('layouts.main')

<title>LIST SEWA | Laporan Details Toko</title>

<style>
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
                    <h4 class="mb-sm-0 font-size-18">Laporan Details Rekap</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan Rekap</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">PERIODE</label>
                    <select class="form-control" name="" id="selectPeriode" onchange="togglePeriode()">
                        <option value="none">PILIH</option>
                        <option value="tglBap">TGL BAP</option>
                        <option value="tglCreated">TGL UPDATED</option>
                    </select>
                </div>
            </div>
        </div> --}}

        <div class="row mt-4 align-items-center" id="periodeTglBap">
            <div class="col-md-12">
                <div class="row mb-3">
                    <div class="col">
                        <button id="exportButtonReportHabis" class="btn btn-success">
                            <i class="fa fa-download"></i> Export Rekap Untuk Tagihan
                        </button>
                    </div>
                </div>

            </div>
        </div>


    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('#exportButtonReportHabis').on('click', function() {
                    $(this).prop('disabled', true).text('Processing...');
                    window.location.href = `/reports/export-rekap`;
                });
            });

        });
    </script>
@endsection
