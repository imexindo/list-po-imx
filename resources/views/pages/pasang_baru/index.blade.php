@extends('layouts.main')

<title>PASANG BARU | IMX</title>


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
                @role(['superadministrator', 'staff', 'Manager'])
                    <div class="col-md-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                            <div>
                                <button data-bs-toggle="modal" data-bs-target="#createModal" class="btn btn-primary"><i
                                        class="bx bx-plus me-1"></i> Tambah</button>
                            </div>
                        </div>
                    </div>
                @endrole()
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-inverse table-responsive" id="installation">
                        <thead class="thead-inverse">
                            <tr>
                                <th>#</th>
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
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>


            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <form id="spkForm" action="#" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Add</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">NO SPK</label>
                                            <input type="text" class="form-control" name="title" id="spkInput" required  placeholder="Masukan No SPK">
                                        </div>
                                    </div>
                                    <div class="col mt-4">
                                        <button type="button" id="cekSpkBtn" class="btn btn-primary px-3 py-3">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                          <label for="po">PO</label>
                                          <input type="text"
                                            class="form-control" name="po" id="po" aria-describedby="helpId" placeholder="PO">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
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
                    url: "{{ route('getSpk') }}",
                    dataSrc: 'data'
                },
                scrollX: true,
                scrollCollapse: true,
                autoWidth: false,
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        data: 'PO'
                    },
                    {
                        data: 'SO'
                    },
                    {
                        data: 'SPK'
                    },
                    {
                        data: 'Kode'
                    },
                    {
                        data: 'Nama'
                    },
                    {
                        data: 'DC'
                    },
                    {
                        data: 'IDM'
                    },
                    {
                        data: 'Sub'
                    },
                    {
                        data: 'KF-15'
                    },
                    {
                        data: 'KF-20'
                    },
                    {
                        data: 'KF-23'
                    },
                    {
                        data: 'KF-26'
                    },
                    {
                        data: 'KF-34'
                    },
                    {
                        data: 'KF-50'
                    },
                    {
                        data: 'KF-70'
                    },
                    {
                        data: 'KF-100'
                    },
                    {
                        data: 'KF-120'
                    },
                    {
                        data: 'TGL PO'
                    },
                    {
                        data: 'Start'
                    },
                    {
                        data: 'Due'
                    },
                    {
                        data: 'SJ'
                    },
                    {
                        data: 'BAP'
                    },
                    {
                        data: 'Tipe'
                    },
                    {
                        data: 'Lok'
                    },
                    {
                        data: 'Ket'
                    },
                    {
                        data: 'cabut'
                    },
                    {
                        data: 'harga sewa'
                    }
                ],

                columnDefs: [{
                        targets: 0,
                        width: "50px"
                    }, // #
                    {
                        targets: 1,
                        width: "100px"
                    }, // PO
                    {
                        targets: 2,
                        width: "100px"
                    }, // SO
                    {
                        targets: 3,
                        width: "80px"
                    }, // SPK
                    {
                        targets: 4,
                        width: "90px"
                    }, // Kode
                    {
                        targets: 5,
                        width: "200px"
                    }, // Nama
                    {
                        targets: 6,
                        width: "70px"
                    }, // DC
                    {
                        targets: 7,
                        width: "90px"
                    }, // IDM
                    {
                        targets: 8,
                        width: "150px"
                    }, // Sub
                    {
                        targets: 9,
                        width: "70px"
                    }, // KF-15
                    {
                        targets: 14,
                        width: "70px"
                    }, // KF-50
                    {
                        targets: 18,
                        width: "120px"
                    }, // TGL PO
                    {
                        targets: 24,
                        width: "250px"
                    }, // Ket
                    {
                        targets: 27,
                        width: "120px"
                    } // Harga Sewa
                ]
            });
        });
    </script>
@endsection
