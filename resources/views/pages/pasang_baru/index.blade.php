@extends('layouts.main')

<title>PASANG BARU | IMX</title>

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
                                <li class="breadcrumb-item active">Pasang baru</li>
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
                                <th>PO</th>
                                <th>SO</th>
                                <th>SPK</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>DC</th>
                                <th>IDM</th>
                                <th>Sub</th>
                                <th>KF-15</th>
                                <th>KF-20</th>
                                <th>KF-23</th>
                                <th>KF-26</th>
                                <th>KF-34</th>
                                <th>KF-50</th>
                                <th>KF-70</th>
                                <th>KF-100</th>
                                <th>KF-120</th>
                                <th>TGL PO</th>
                                <th>Start</th>
                                <th>Due</th>
                                <th>SJ</th>
                                <th>BAP</th>
                                <th>Tipe</th>
                                <th>Lok</th>
                                <th>Ket</th>
                                <th>Cabut</th>
                                <th>Harga Sewa</th>
                                <th>Created</th>
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
                    url: "{{ route('pasang-baru.get') }}",
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
                            return '<a href="/pasang-baru/get/edit/' + btoa(row.id) + '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_seri'
                    },
                    {
                        data: 'po'
                    },
                    {
                        data: 'so'
                    },
                    {
                        data: 'spk'
                    },
                    {
                        data: 'kode'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'dc'
                    },
                    {
                        data: 'idm'
                    },
                    {
                        data: 'subkon'
                    },
                    {
                        data: 'kf_15'
                    },
                    {
                        data: 'kf_20'
                    },
                    {
                        data: 'kf_23'
                    },
                    {
                        data: 'kf_26'
                    },
                    {
                        data: 'kf_34'
                    },
                    {
                        data: 'kf_50'
                    },
                    {
                        data: 'kf_70'
                    },
                    {
                        data: 'kf_100'
                    },
                    {
                        data: 'kf_120'
                    },
                    {
                        data: 'tgl_po'
                    },
                    {
                        data: 'start'
                    },
                    {
                        data: 'due'
                    },
                    {
                        data: 'sj'
                    },
                    {
                        data: 'bap'
                    },
                    {
                        data: 'tipe'
                    },
                    {
                        data: 'lok'
                    },
                    {
                        data: 'ket'
                    },
                    {
                        data: 'cabut'
                    },
                    {
                        data: 'harga_sewa'
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            return data.split('T')[0].split('-').reverse().join('/');
                        }
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        width: 50,
                        orderable: false,
                        searchable: false
                    }, // #
                    {
                        targets: 1,
                        width: 100,
                        orderable: false,
                        searchable: false
                    }, // Action
                    {
                        targets: 2,
                        width: 100
                    }, // No Resi
                    {
                        targets: 5,
                        width: 200
                    },
                    {
                        targets: 6,
                        width: 100
                    },
                    {
                        targets: 7,
                        width: 200
                    },
                    {
                        targets: 8,
                        width: 100
                    },
                    {
                        targets: 9,
                        width: 50
                    },
                    {
                        targets: 10,
                        width: 50
                    },
                    {
                        targets: 11,
                        width: 50
                    },
                    {
                        targets: 12,
                        width: 50
                    },
                    {
                        targets: 13,
                        width: 50
                    },
                    {
                        targets: 14,
                        width: 50
                    },
                    {
                        targets: 15,
                        width: 50
                    },
                    {
                        targets: 16,
                        width: 80
                    },
                    {
                        targets: 17,
                        width: 80
                    },
                    {
                        targets: 18,
                        width: 100
                    },
                    {
                        targets: 19,
                        width: 100
                    },
                    {
                        targets: 20,
                        width: 100
                    },
                    {
                        targets: 21,
                        width: 100
                    },
                    {
                        targets: 22,
                        width: 150
                    },
                    {
                        targets: 23,
                        width: 150
                    },
                    {
                        targets: 24,
                        width: 150
                    },
                    {
                        targets: 25,
                        width: 100
                    },
                    {
                        targets: 27,
                        width: 350
                    },
                    {
                        targets: 28,
                        width: 100
                    },
                    {
                        targets: 29,
                        width: 100
                    },
                ]

            });
        });
    </script>
@endsection
