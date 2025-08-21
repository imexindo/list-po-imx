@extends('layouts.main')

<title>Exit Sementara | IMX</title>

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
                                <li class="breadcrumb-item"><a href="/extSementara">Dashboard</a></li>
                                <li class="breadcrumb-item active">Exit Sementara</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-inverse table-responsive" id="installation">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>No Seri</th>
                                <th>SPK</th>
                                <th>Tgl SPK</th>
                                <th>Tgl PO</th>
                                <th>No SPK Subkon</th>
                                <th>Tgl Mulai Pasang</th>
                                <th>Tgl Batas Pasang</th>
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
                    url: "{{ route('extSementara.get') }}",
                    dataSrc: 'data'
                },
                scrollX: true,
                scrollCollapse: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="/extSementara/get/edit/' + btoa(row.id) +
                                '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_seri'
                    },
                    {
                        data: 'spk',
                        render: function(data, type, row) {
                            if (data.length > 25) {
                                return `<span>${data.substring(0, 25)}... <a href="#" class="show-more" data-full="${data}" onclick="alert('${data}')">Show</a></span>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'tgl_spk'
                    },
                    {
                        data: 'tgl_po'
                    },
                    {
                        data: 'spk_subkon'
                    },
                    {
                        data: 'start'
                    },
                    {
                        data: 'due'
                    },
                    {
                        data: 'tipe'
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        width: 50,
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: 1,
                        width: 100,
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: 2,
                        width: 100
                    },
                    {
                        targets: 3,
                        width: 300
                    },
                    {
                        targets: 4,
                        width: 100
                    },
                    {
                        targets: 5,
                        width: 100
                    },
                    {
                        targets: 6,
                        width: 150
                    },
                    {
                        targets: 7,
                        width: 150
                    },
                    {
                        targets: 8,
                        width: 150
                    },
                    {
                        targets: 9,
                        width: 200
                    }
                ]

            });

        });
    </script>
@endsection
