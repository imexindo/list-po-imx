@extends('layouts.main')

<title>GESER | IMX</title>

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
                                <li class="breadcrumb-item"><a href="/geser">Dashboard</a></li>
                                <li class="breadcrumb-item active">Geser</li>
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
                                <th>AC yg di Geser</th>
                                <th>Tgl BAP</th>
                                <th>SPK</th>
                                <th>BAP</th>
                                <th>Tgl Dok Diterima</th>
                                <th>Keterangan</th>
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
                    url: "{{ route('geser.get') }}",
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
                            return '<a href="/geser/get/edit/' + btoa(row.id) +
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
                        data: null,
                        render: function(data, type, row) {
                            let html = '';

                            let fields = ['kf_15', 'kf_20', 'kf_23', 'kf_26', 'kf_34', 'kf_50',
                                'kf_70', 'kf_100', 'kf_120'
                            ];

                            fields.forEach(function(field) {
                                if (row[field] != 0 && row[field] != null) {
                                    html +=
                                        `<span class="badge bg-info">${row[field]} UNIT ${field.toUpperCase()}</span> `;
                                }
                            });

                            return html === '' ? '-' : html;
                        }
                    },
                    {
                        data: 'tgl_bap'
                    },
                    {
                        data: 'l_spk',
                        render: function(data, type, row) {
                            let badgeClass = 'secondary';
                            let text = '<i class="fa fa-spinner"></i> -';

                            if (data == 0) {
                                badgeClass = 'secondary';
                                text = '<i class="fa fa-spinner"></i> Blank';
                            } else if (data == 1) {
                                badgeClass = 'success';
                                text = '<i class="fa fa-check-circle"></i> Accepted';
                            } else if (data == 2) {
                                badgeClass = 'danger';
                                text = '<i class="fa fa-close"></i> Canceled';
                            }
                            return `<span class="badge bg-${badgeClass}">${text}</span>`;
                        }
                    },
                    {
                        data: 'l_bap',
                        render: function(data, type, row) {
                            let badgeClass = 'secondary';
                            let text = '<i class="fa fa-spinner"></i> -';

                            if (data == 0) {
                                badgeClass = 'secondary';
                                text = '<i class="fa fa-spinner"></i> Blank';
                            } else if (data == 1) {
                                badgeClass = 'success';
                                text = '<i class="fa fa-check"></i> Accepted';
                            } else if (data == 2) {
                                badgeClass = 'danger';
                                text = '<i class="fa fa-close"></i> Canceled';
                            }
                            return `<span class="badge bg-${badgeClass}">${text}</span>`;
                        }
                    },
                    {
                        data: 'tgl_dok_terima'
                    },
                    {
                        data: 'keterangan'
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
                        width: 300
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
                        width: 300
                    },
                    {
                        targets: 10,
                        width: 300
                    }
                ]

            });

        });
    </script>
@endsection
