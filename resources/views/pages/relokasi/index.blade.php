@extends('layouts.main')

<title>RELOKASI | IMX</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-8">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                                <li class="breadcrumb-item active">Relokasi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-inverse table-responsive" id="installation" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>No Seri</th>
                                <th>SPK</th>
                                <th>Tgl SPK</th>
                                <th>Status Pasang</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>



                </div>
            </div>


        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#installation').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('relokasi.get') }}",
                    dataSrc: 'data'
                },
                scrollX: true,
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                    <a href="/relokasi/get/edit/${btoa(row.id)}" 
                       class="btn btn-primary btn-sm">
                        <i class="fa fa-pencil"></i> Edit
                    </a>`;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_seri'
                    },
                    {
                        data: 'spk',
                        render: function(data) {
                            if (data && data.length > 25) {
                                return `
                        <span title="${data}">
                            ${data.substring(0, 25)}...
                        </span>`;
                            }
                            return data ?? '';
                        }
                    },
                    {
                        data: 'tgl_spk'
                    },
                    {
                        data: 'tipe'
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        width: "50px"
                    },
                    {
                        targets: 1,
                        width: "100px"
                    },
                    {
                        targets: 2,
                        width: "120px"
                    },
                    {
                        targets: 3,
                        width: "200px"
                    },
                    {
                        targets: 4,
                        width: "120px"
                    },
                    {
                        targets: 5,
                        width: "220px"
                    }
                ],
            });



        });
    </script>
@endsection
