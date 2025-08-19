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
                    <h4 class="mb-sm-0 font-size-18">Laporan Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Laporan Details</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
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
        </div>

        <div class="row mt-4 align-items-center" id="periodeTglBap" style="display: none;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-2">
                        <label for="">PERIODE TGL BAP</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="from" class="form-label">Dari</label>
                            <input type="date" class="form-control" name="from" id="from"
                                aria-describedby="helpId">
                            <small id="fromHelp" class="form-text">Pilih tanggal awal</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="to" class="form-label">Sampai</label>
                            <input type="date" class="form-control" name="to" id="to"
                                aria-describedby="helpId">
                            <small id="toHelp" class="form-text">Pilih tanggal akhir</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="region_id" class="form-label">DC</label>
                            <select id="region_id" name="region_id" class="form-select">
                                <option value="">All</option>
                                @foreach ($dc as $item)
                                    <option value="{{ $item['cardcode'] }}">{{ $item['CardName'] }}</option>
                                @endforeach
                            </select>
                            <small id="regionHelp" class="form-text">Pilih distribusi center (DC)</small>
                        </div>
                    </div>
                    <div class="col mt-4">
                        <button id="exportButtonReportHabis" class="btn btn-success" disabled>
                            <i class="fa fa-filter"></i> Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 align-items-center" id="periodeTglCreated" style="display: none;">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-4">
                        <label for="">PERIODE TGL UPDATED</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="from" class="form-label">Dari</label>
                            <input type="date" class="form-control" name="from" id="fromc"
                                aria-describedby="helpId">
                            <small id="fromHelp" class="form-text">Pilih tanggal awal</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="to" class="form-label">Sampai</label>
                            <input type="date" class="form-control" name="to" id="toc"
                                aria-describedby="helpId">
                            <small id="toHelp" class="form-text">Pilih tanggal akhir</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="region_id" class="form-label">DC</label>
                            <select id="region_idc" name="region_id" class="form-select">
                                <option value="">All</option>
                                @foreach ($dc as $item)
                                    <option value="{{ $item['cardcode'] }}">{{ $item['CardName'] }}</option>
                                @endforeach
                            </select>
                            <small id="regionHelp" class="form-text">Pilih distribusi center (DC)</small>
                        </div>
                    </div>
                    <div class="col mt-4">
                        <button id="exportButtonReportHabisCreated" class="btn btn-success" disabled>
                            <i class="fa fa-filter"></i> Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>


    <script>
        function togglePeriode() {
            const selectedValue = document.getElementById("selectPeriode").value;
            document.getElementById("periodeTglBap").style.display = selectedValue === "tglBap" ? "block" : "none";
            document.getElementById("periodeTglCreated").style.display = selectedValue === "tglCreated" ? "block" : "none";
        }


        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('#exportButtonReportHabis').on('click', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    var region_id = $('#region_id').val();
                    var $button = $(this);

                    if (from && to) {
                        $button.prop('disabled', true).text('Processing...');
                        window.location.href =
                            `/reports/export-details?from=${from}&to=${to}&region_id=${region_id}`;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silakan pilih tanggal awal dan akhir',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                // Enable/disable export button based on date selection
                $('#from, #to').on('change', function() {
                    var from = $('#from').val();
                    var to = $('#to').val();
                    $('#exportButtonReportHabis').prop('disabled', !(from && to));
                });

                // Handle the second form for "TGL UPDATED"
                $('#exportButtonReportHabisCreated').on('click', function() {
                    var from = $('#fromc').val();
                    var to = $('#toc').val();
                    var region_id = $('#region_idc').val();
                    var $button = $(this);

                    if (from && to) {
                        $button.prop('disabled', true).text('Processing...');
                        window.location.href =
                            `/reports/export-details/created?from=${from}&to=${to}&region_id=${region_id}`;
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silakan pilih tanggal awal dan akhir',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });

                $('#fromc, #toc').on('change', function() {
                    var from = $('#fromc').val();
                    var to = $('#toc').val();
                    $('#exportButtonReportHabisCreated').prop('disabled', !(from && to));
                });
            });
        });
    </script>
@endsection
