@extends('layouts.main')

<title>INPUT SPK | IMX</title>


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
                                <li class="breadcrumb-item active">Input SPK</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-10">
                    <div class="mb-3 position-relative">
                        <label for="spk_input" class="form-label">NO SPK</label>
                        <input type="text" class="form-control" name="spk_input" id="spkInput"
                            placeholder="Input no SPK" autocomplete="off">
                        <div id="spkResults" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>
                </div>
                <div class="col-2 mt-4">
                    <button type="button" class="btn btn-primary px-3 py-3 btn-search-spk">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>



            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <form id="spkForm" action="{{ route('spkStore') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Input SPK</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="spk">SPK</label>
                                            <input type="text" class="form-control" name="spk" id="spk"
                                                aria-describedby="helpId" placeholder="Input SPK" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="po">PO</label>
                                            <input type="text" class="form-control" name="po" id="po"
                                                aria-describedby="helpId" placeholder="Input PO">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="so">SO</label>
                                            <input type="text" class="form-control" name="so" id="so"
                                                aria-describedby="helpId" placeholder="Input SO">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="tgl_po">Tgl PO</label>
                                            <input type="date" class="form-control" name="tgl_po" id="tgl_po"
                                                aria-describedby="helpId" placeholder="Input Tgl PO">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="tipe">Tipe</label>
                                            <input type="text" class="form-control" name="tipe" id="tipe"
                                                aria-describedby="helpId" placeholder="Input Tipe">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="kode">Kode</label>
                                            <input type="text" class="form-control" name="kode" id="kode"
                                                aria-describedby="helpId" placeholder="Input Kode">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" name="nama" id="nama"
                                                aria-describedby="helpId" placeholder="Input Nama">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="dc">DC</label>
                                            <input type="text" class="form-control" name="dc" id="dc"
                                                aria-describedby="helpId" placeholder="Input DC">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="idm">IDM</label>
                                            <input type="text" class="form-control" name="idm" id="idm"
                                                aria-describedby="helpId" placeholder="Input IDM">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="subkon">Subkon</label>
                                            <input type="text" class="form-control" name="subkon" id="subkon"
                                                aria-describedby="helpId" placeholder="Input Subkon">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="Bulan Po">Bulan PO</label>
                                            <input type="text" class="form-control" name="bulan_po" id="bulan-po"
                                                aria-describedby="helpId" placeholder="Bulan PO">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="bap">BAP</label>
                                            <input type="text" class="form-control" name="bap" id="bap"
                                                aria-describedby="helpId" placeholder="Input BAP">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-15">KF-15</label>
                                            <input type="text" class="form-control" name="kf-15" id="kf-15"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-20">KF-20</label>
                                            <input type="text" class="form-control" name="kf-20" id="kf-20"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-23">KF-23</label>
                                            <input type="text" class="form-control" name="kf-23" id="kf-23"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-26">KF-26</label>
                                            <input type="text" class="form-control" name="kf-26" id="kf-26"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-34">KF-34</label>
                                            <input type="text" class="form-control" name="kf-34" id="kf-34"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-50">KF-50</label>
                                            <input type="text" class="form-control" name="kf-50" id="kf-50"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-70">KF-70</label>
                                            <input type="text" class="form-control" name="kf-70" id="kf-70"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-100">KF-100</label>
                                            <input type="text" class="form-control" name="kf-100" id="kf-100"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-1 mt-3">
                                        <div class="form-group">
                                            <label for="kf-120">KF-120</label>
                                            <input type="text" class="form-control" name="kf-120" id="kf-120"
                                                aria-describedby="helpId">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="start">Start</label>
                                            <input type="date" class="form-control" name="start" id="start"
                                                aria-describedby="helpId" placeholder="Input Start">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="due">Due</label>
                                            <input type="date" class="form-control" name="due" id="due"
                                                aria-describedby="helpId" placeholder="Input Due">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="sj">SJ</label>
                                            <input type="text" class="form-control" name="sj" id="sj"
                                                aria-describedby="helpId" placeholder="Input SJ">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="cabut">Cabut</label>
                                            <input type="text" class="form-control" name="cabut" id="cabut"
                                                aria-describedby="helpId" placeholder="Input Cabut">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="lok">Lok</label>
                                            <input type="text" class="form-control" name="lok" id="lok"
                                                aria-describedby="helpId" placeholder="Input Lok">
                                        </div>
                                    </div>
                                    <div class="col-3 mt-3">
                                        <div class="form-group">
                                            <label for="harga_sewa">Harga Sewa</label>
                                            <input type="text" class="form-control" name="harga_sewa" id="harga_sewa"
                                                aria-describedby="helpId" placeholder="Input Harga Sewa">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <div class="form-group">
                                            <label for="ket">Keterangan</label>
                                            <input type="text" class="form-control" name="ket" id="ket"
                                                aria-describedby="helpId" placeholder="Input Keterangan">
                                        </div>
                                    </div>
                                    <div class="col-4 mt-3">
                                        <div class="form-group">
                                            <label for="category_id">Kategori</label>
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4">
                                        <label for="spk">SPK</label><br>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_spk"
                                                    id="spk0" value="0" checked>
                                                Blank
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_spk"
                                                    id="spk1" value="1">
                                                Checked
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_spk"
                                                    id="spk2" value="2">
                                                Close
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-4">
                                        <label for="bap">BAP</label><br>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_bap"
                                                    id="bap0" value="0" checked>
                                                Blank
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_bap"
                                                    id="bap1" value="1">
                                                Checked
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="l_bap"
                                                    id="bap2" value="2">
                                                Close
                                            </label>
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
            // search
            $("#spkInput").on("keyup", function() {
                let search = $(this).val().trim();

                if (search.length < 1) {
                    $("#spkResults").html("");
                    return;
                }

                $.ajax({
                    url: "{{ route('searchSpk') }}",
                    method: "GET",
                    data: {
                        search: search
                    },
                    success: function(data) {
                        $("#spkResults").html("");

                        if (data.length === 0) {
                            $("#spkResults").append(
                                `<div class="list-group-item">SPK tidak ditemukan</div>`);
                            return;
                        }

                        data.forEach(function(item) {
                            let div = $("<div>")
                                .addClass("list-group-item list-group-item-action")
                                .text(item.SPK)
                                .on("click", function() {
                                    $("#spkInput").val(item.SPK);
                                    $("#spkResults").html("");
                                });

                            $("#spkResults").append(div);
                        });
                    },
                    error: function(err) {
                        console.error("Error fetch SPK:", err);
                    }
                });
            });

            // get spk
            $(".btn-search-spk").on("click", function() {
                let spk = $("#spkInput").val().trim();

                if (spk === "") {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Silakan isi No SPK terlebih dahulu!"
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('verifySpk') }}",
                    method: "GET",
                    data: {
                        search: spk
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "Sedang mengambil data...",
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(res) {
                        Swal.close();

                        if (!res || res.length === 0) {
                            Swal.fire({
                                icon: "error",
                                title: "SPK tidak ditemukan",
                                text: "Pastikan No SPK yang Anda masukkan benar."
                            });
                            return;
                        }

                        let data = res[0];

                        function formatDate(dateStr) {
                            return dateStr ? dateStr.split("T")[0] : "";
                        }

                        $("#spk").val(data.SPK || "");
                        $("#po").val(data.PO || "");
                        $("#so").val(data.SO || "");
                        $("#tgl_po").val(formatDate(data["TGL PO"]));
                        $("#tipe").val(data.Tipe || "");
                        $("#kode").val(data.Kode || "");
                        $("#nama").val(data.Nama || "");
                        $("#dc").val(data.DC || "");
                        $("#idm").val(data.IDM || "");
                        $("#subkon").val(data.Sub || "");
                        $("#bap").val(data.BAP || "");
                        $("#kf-15").val(data["KF-15"] || 0);
                        $("#kf-20").val(data["KF-20"] || 0);
                        $("#kf-23").val(data["KF-23"] || 0);
                        $("#kf-26").val(data["KF-26"] || 0);
                        $("#kf-34").val(data["KF-34"] || 0);
                        $("#kf-50").val(data["KF-50"] || 0);
                        $("#kf-70").val(data["KF-70"] || 0);
                        $("#kf-100").val(data["KF-100"] || 0);
                        $("#kf-120").val(data["KF-120"] || 0);
                        $("#start").val(formatDate(data.Start));
                        $("#due").val(formatDate(data.Due));
                        $("#sj").val(data.SJ || "");
                        $("#cabut").val(data.cabut || "");
                        $("#lok").val(data.Lok || "");
                        $("#harga_sewa").val(data["harga sewa"] || 0);
                        $("#ket").val(data.Ket || "");
                        $("#bulan-po").val(data["Bln PO"] || 0);

                        $("#createModal").modal("show");
                    },
                    error: function(err) {
                        Swal.close();
                        console.error("Error fetch verify SPK:", err);
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan",
                            text: "Gagal mengambil data SPK dari server."
                        });
                    }
                });
            });

            $('#spkForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('spkStore') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire('Success', 'Data berhasil disimpan!', 'success');
                        $('#createModal').modal('hide');
                    },
                    error: function(err) {
                        if (err.responseJSON && err.responseJSON.errors && err.responseJSON
                            .errors.spk) {
                            Swal.fire('Error', 'Gagal simpan data: ' + err.responseJSON.errors
                                .spk[0], 'error');
                        } else {
                            Swal.fire('Error', 'Gagal simpan data: ' + err.responseText,
                                'error');
                        }
                    }
                });
            });




        });
    </script>
@endsection
