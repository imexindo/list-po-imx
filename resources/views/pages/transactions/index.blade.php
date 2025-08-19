@extends('layouts.main')

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
                <h4 class="mb-sm-0 font-size-18">Transactions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
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
            <table id="contractTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>SO</th>
                        <th>SPK</th>
                        <th>TGL BAP</th>
                        <th>Kode Toko</th>
                        <th>Nama</th>
                        <th>DC</th>
                        <th>Kode IDM</th>
                        <th>KF-15</th>
                        <th>KF-20</th>
                        <th>KF-23</th>
                        <th>KF-26</th>
                        <th>KF-34</th>
                        <th>KF-50</th>
                        <th>KF-70</th>
                        <th>KF-100</th>
                        <th>KF-120</th>
                        <th>Alamat</th>
                        <th>NPWP</th>
                        <th>ANPWP</th>
                        <th>NNPWP</th>
                        <th>Tipe</th>
                        <th>Ref</th>
                        <th>Lok</th>
                        <th>Total</th>
                        <th>Ket</th>
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
            text: 'Please wait data SAP',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        $.ajax({
            url: '{{ env('SAP_API') }}/api/spk',
            method: 'GET',
            success: function(data) {
                $('#contractTable').DataTable({
                    scrollX: true,
                    data: data,
                    columns: [
                        { data: null, render: (data, type, row, meta) => meta.row + 1 },
                        { data: 'SO' },
                        { data: 'SPK' },
                        { data: 'BAP', render: data => new Date(data).toLocaleDateString() },
                        { data: 'Kode' },
                        { data: 'Nama' },
                        { data: 'DC' },
                        { data: 'Kode_IDM' },
                        { data: 'KF-15' },
                        { data: 'KF-20' },
                        { data: 'KF-23' },
                        { data: 'KF-26' },
                        { data: 'KF-34' },
                        { data: 'KF-50' },
                        { data: 'KF-70' },
                        { data: 'KF-100' },
                        { data: 'KF-120' },
                        { 
                            data: 'Alamat',
                            render: function(data, type, row, meta) {
                                if (data.length > 20) {
                                    return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                        { data: 'NPWP' },
                        { 
                            data: 'ANPWP',
                            render: function(data, type, row, meta) {
                                if (data.length > 20) {
                                    return `<span class="anpwp-short">${data.substring(0, 20)}...</span>
                                            <span class="anpwp-full" style="display:none;">${data}</span>
                                            <a href="#" class="toggle-anpwp">Show</a>`;
                                }
                                return data;
                            }
                        },
                        { data: 'NNPWP' },
                        { data: 'Tipe' },
                        { data: 'ref' },
                        { data: 'Lok' },
                        { data: 'Total' },
                        { 
                            data: 'Ket',
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
