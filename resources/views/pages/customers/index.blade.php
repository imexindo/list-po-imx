@extends('layouts.main')

<title>LIST SEWA | Data Pelanggan</title>

{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  --}}


<style>
    
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Pelanggan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pelanggan</li>
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
                    {{-- <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Add New</button> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <table id="contractTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Cust</th>
                        <th>Nama Cust</th>
                        <th>Kode IDM</th>
                        <th>Kode DC</th>
                        <th>Nama DC</th>
                        <th>Telp 1</th>
                        <th>Group</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Kode Subkon</th>
                        <th>Toko/NonToko</th>
                        <th>Nama Subkon</th>
                        <th>City</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Loading...',
            text: 'Please wait data Customers',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });

        $.ajax({
            url: '{{ env('SAP_API') }}/api/customers',
            method: 'GET',
            success: function(data) {
                $('#contractTable').DataTable({
                    columnDefs: [
                                { width: 20, targets: 0 },  
                                { width: 100, targets: 1 },
                                { width: 200, targets: 2 },
                                { width: 60, targets: 3 },
                                { width: 100, targets: 4 },
                                { width: 250, targets: 5 },
                                { width: 150, targets: 6 },
                                { width: 180, targets: 8 },
                                { width: 100, targets: 9 },
                                { width: 100, targets: 10 },
                                { width: 150, targets: 11 },
                                { width: 150, targets: 12 },
                                { width: 250, targets: 13 },
                                { width: 250, targets: 14 },
                            ],
                    scrollX: true,
                    data: data,
                    columns: [
                        { data: null, render: (data, type, row, meta) => meta.row + 1 },
                        { data: 'Kode_Cust' },
                        { data: 'Nama_Cust' },
                        { data: 'Kode_IDM' },
                        { data: 'Kode_DC' },
                        { 
                            data: 'Nama_DC',
                            render: function(data, type, row, meta) {
                                if (!data) {
                                    return '';
                                }
                                if (data.length > 10) {
                                    return `<span class="anpwp-short">${data.substring(0, 10)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                        { data: 'Phone1' },
                        { data: 'Group' },
                        { 
                            data: 'CntctPrsn',
                            render: function(data, type, row, meta) {
                                if (!data) {
                                    return '';
                                }
                                if (data.length > 10) {
                                    return `<span class="anpwp-short">${data.substring(0, 10)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                        { data: 'E_Mail' },
                        { data: 'Kode_Subkon' },
                        // { data: 'Toko_NonToko' },
                        {
                            data: 'Toko_NonToko',
                            render: function(data, type, row) {
                                switch(data) {
                                    case 1:
                                        return '<span class="badge bg-primary">Toko</span>';
                                    case 2:
                                        return '<span class="badge bg-primary">Non Toko</span>';
                                    default:
                                        return 'Unknown';
                                }
                            }
                        },
                        { data: 'Nama_Subkon' },
                        { 
                            data: 'City',
                            render: function(data, type, row, meta) {
                                if (!data) {
                                    return '';
                                }
                                if (data.length > 20) {
                                    return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                        { 
                            data: 'Address',
                            render: function(data, type, row, meta) {
                                if (data.length > 20) {
                                    return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                    ]
                });
                Swal.close();
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

    });
</script>
@endsection
