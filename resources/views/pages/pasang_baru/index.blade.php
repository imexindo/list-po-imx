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
                                <th>SPK</th>
                                <th>Tgl SPK</th>
                                <th>Tgl Kirim Unit</th>
                                <th>No SJ</th>
                                <th>Tgl SJ Diterima</th>
                                <th>Tgl Pasang</th>
                                <th>Tgl BAP</th>
                                <th>Proses SPK</th>
                                <th>Proses BAP</th>
                                <th>Tgl Dok Diterima</th>
                                <th>Tgl Info Cancel</th>
                                <th>No Goods Isuued</th>
                                <th>No Kapitalisasi</th>
                                <th>Keterangan</th>
                                <th>Ket SAP</th>
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
                            return '<a href="/pasang-baru/get/edit/' + btoa(row.id) +
                                '" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>';
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_seri'
                    },
                    {
                        data: 'spk'
                    },
                    {
                        data: 'tgl_spk'
                    },
                    {
                        data: 'tgl_kirim_unit'
                    },
                    {
                        data: 'sj'
                    },
                    {
                        data: 'tgl_dok_sj'
                    },
                    {
                        data: 'tgl_pasang'
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
                        data: 'no_info_cancel'
                    },
                    {
                        data: 'no_goods_issued'
                    },
                    {
                        data: 'no_kapitalisasi'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'ket'
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
                        width: 100
                    },
                    {
                        targets: 7,
                        width: 150
                    },
                    {
                        targets: 8,
                        width: 100
                    },
                    {
                        targets: 9,
                        width: 100
                    },
                    {
                        targets: 10,
                        width: 100
                    }, // Proses SPK
                    {
                        targets: 11,
                        width: 150
                    }, // Proses BAP
                    {
                        targets: 12,
                        width: 150
                    },
                    {
                        targets: 13,
                        width: 150
                    },
                    {
                        targets: 14,
                        width: 150
                    },
                    {
                        targets: 15,
                        width: 150
                    },
                    {
                        targets: 16,
                        width: 400
                    },
                    {
                        targets: 17,
                        width: 400
                    },
                    {
                        targets: 18,
                        width: 100
                    },
                ],
                initComplete: function() {
                    this.api().columns([10, 11]).every(function() {
                        var column = this;
                        var select = $(`
                            <select class="form-control">
                                <option value="">All</option>
                                <option value="0">Blank</option>
                                <option value="1">Accepted</option>
                                <option value="2">Canceled</option>
                            </select>
                        `)
                            .appendTo($(column.header()).empty())
                            .on('change', function() {
                                var val = $(this).val();
                                column.search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                            });
                    });
                }

            });

        });
    </script>
@endsection
