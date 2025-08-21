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
                                <li class="breadcrumb-item"><a href="/relokasi">Relokasi</a></li>
                                <li class="breadcrumb-item active">Edit SPK</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="card">
                <div class="card-header">
                    <h5>Edit SPK</h5>
                </div>
                <form action="{{ route('relokasi.update', ['id' => encrypt($getPo->id)]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="spk">SPK</label>
                                    <input type="text" class="form-control" name="spk" id="spk"
                                        aria-describedby="helpId" placeholder="Input SPK" readonly
                                        value="{{ $getPo->spk }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="po">PO</label>
                                    <input type="text" class="form-control" name="po" id="po"
                                        aria-describedby="helpId" placeholder="Input PO" value="{{ $getPo->po }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="so">SO</label>
                                    <input type="text" class="form-control" name="so" id="so"
                                        aria-describedby="helpId" placeholder="Input SO" value="{{ $getPo->so }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="tgl_po">Tgl PO</label>
                                    <input type="date" class="form-control" name="tgl_po" id="tgl_po"
                                        aria-describedby="helpId" placeholder="Input Tgl PO" value="{{ $getPo->tgl_po }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="tipe">Tipe</label>
                                    <input type="text" class="form-control" name="tipe" id="tipe"
                                        aria-describedby="helpId" placeholder="Input Tipe" value="{{ $getPo->tipe }}" readonly>
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="kode">Kode</label>
                                    <input type="text" class="form-control" name="kode" id="kode"
                                        aria-describedby="helpId" placeholder="Input Kode" value="{{ $getPo->kode }}" readonly>
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        aria-describedby="helpId" placeholder="Input Nama" value="{{ $getPo->nama }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="dc">DC</label>
                                    <input type="text" class="form-control" name="dc" id="dc"
                                        aria-describedby="helpId" placeholder="Input DC" value="{{ $getPo->dc }}">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="idm">IDM</label>
                                    <input type="text" class="form-control" name="idm" id="idm"
                                        aria-describedby="helpId" placeholder="Input IDM" value="{{ $getPo->idm }}">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="subkon">Subkon</label>
                                    <input type="text" class="form-control" name="subkon" id="subkon"
                                        aria-describedby="helpId" placeholder="Input Subkon"
                                        value="{{ $getPo->subkon }}" readonly>
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="bap">BAP</label>
                                    <input type="text" class="form-control" name="bap" id="bap"
                                        aria-describedby="helpId" placeholder="Input BAP" value="{{ $getPo->bap }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-15">KF-15</label>
                                    <input type="text" class="form-control" name="kf-15" id="kf-15"
                                        aria-describedby="helpId" value="{{ $getPo->kf_15 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-20">KF-20</label>
                                    <input type="text" class="form-control" name="kf-20" id="kf-20"
                                        aria-describedby="helpId" value="{{ $getPo->kf_20 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-23">KF-23</label>
                                    <input type="text" class="form-control" name="kf-23" id="kf-23"
                                        aria-describedby="helpId" value="{{ $getPo->kf_23 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-26">KF-26</label>
                                    <input type="text" class="form-control" name="kf-26" id="kf-26"
                                        aria-describedby="helpId" value="{{ $getPo->kf_26 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-34">KF-34</label>
                                    <input type="text" class="form-control" name="kf-34" id="kf-34"
                                        aria-describedby="helpId" value="{{ $getPo->kf_34 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-50">KF-50</label>
                                    <input type="text" class="form-control" name="kf-50" id="kf-50"
                                        aria-describedby="helpId" value="{{ $getPo->kf_50 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-70">KF-70</label>
                                    <input type="text" class="form-control" name="kf-70" id="kf-70"
                                        aria-describedby="helpId" value="{{ $getPo->kf_70 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-100">KF-100</label>
                                    <input type="text" class="form-control" name="kf-100" id="kf-100"
                                        aria-describedby="helpId" value="{{ $getPo->kf_100 }}" readonly>
                                </div>
                            </div>
                            <div class="col-1 mt-3">
                                <div class="form-group">
                                    <label for="kf-120">KF-120</label>
                                    <input type="text" class="form-control" name="kf-120" id="kf-120"
                                        aria-describedby="helpId" value="{{ $getPo->kf_120 }}" readonly>
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="start">Start</label>
                                    <input type="date" class="form-control" name="start" id="start"
                                        aria-describedby="helpId" placeholder="Input Start" value="{{ $getPo->start }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="due">Due</label>
                                    <input type="date" class="form-control" name="due" id="due"
                                        aria-describedby="helpId" placeholder="Input Due" value="{{ $getPo->due }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="sj">SJ</label>
                                    <input type="text" class="form-control" name="sj" id="sj"
                                        aria-describedby="helpId" placeholder="Input SJ" value="{{ $getPo->sj }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="cabut">Cabut</label>
                                    <input type="text" class="form-control" name="cabut" id="cabut"
                                        aria-describedby="helpId" placeholder="Input Cabut" value="{{ $getPo->cabut }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="lok">Lok</label>
                                    <input type="text" class="form-control" name="lok" id="lok"
                                        aria-describedby="helpId" placeholder="Input Lok" value="{{ $getPo->lok }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                    <label for="harga_sewa">Harga Sewa</label>
                                    <input type="text" class="form-control" name="harga_sewa" id="harga_sewa"
                                        aria-describedby="helpId" placeholder="Input Harga Sewa"
                                        value="{{ $getPo->harga_sewa }}">
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label for="ket">Keterangan</label>
                                    <input type="text" class="form-control" name="ket" id="ket"
                                        aria-describedby="helpId" placeholder="Input Keterangan"
                                        value="{{ $getPo->ket }}">
                                </div>
                            </div>
                            <div class="col-4 mt-3">
                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select class="form-control" name="category_id" id="category_id" required>
                                        <option value="{{ $getPo->category_id }}">{{ $getPo->category_by_menu->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 mt-4">
                                <label for="spk">SPK</label><br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_spk" id="spk0" value="0"
                                            {{ old('l_spk', $getPo->l_spk) == 0 ? 'checked' : '' }}>
                                        Blank
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_spk" id="spk1" value="1"
                                            {{ old('l_spk', $getPo->l_spk) == 1 ? 'checked' : '' }}>
                                        Accepted
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_spk" id="spk2" value="2"
                                            {{ old('l_spk', $getPo->l_spk) == 2 ? 'checked' : '' }}>
                                        Canceled
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-4 mt-4">
                                <label for="bap">BAP</label><br>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_bap" id="bap0" value="0"
                                            {{ old('l_bap', $getPo->l_bap) == 0 ? 'checked' : '' }}>
                                        Blank
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_bap" id="bap1" value="1"
                                            {{ old('l_bap', $getPo->l_bap) == 1 ? 'checked' : '' }}>
                                        Accepted
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="l_bap" id="bap2" value="2"
                                            {{ old('l_bap', $getPo->l_bap) == 2 ? 'checked' : '' }}>
                                        Canceled
                                    </label>
                                </div>
                            </div>

                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_spk">Tgl Spk</label>
                                  <input type="date" class="form-control" name="tgl_spk" id="tgl_spk" value="{{ $getPo->tgl_spk }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_kirim_unit">Tgl Kirim Unit</label>
                                  <input type="date" class="form-control" name="tgl_kirim_unit" id="tgl_kirim_unit" value="{{ $getPo->tgl_kirim_unit }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_dok_sj">Tgl SJ diterima</label>
                                  <input type="date" class="form-control" name="tgl_dok_sj" id="tgl_dok_sj" value="{{ $getPo->tgl_dok_sj }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_pasang">Tgl Pasang</label>
                                  <input type="date" class="form-control" name="tgl_pasang" id="tgl_pasang" value="{{ $getPo->tgl_pasang }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_bap">Tgl BAP</label>
                                  <input type="date" class="form-control" name="tgl_bap" id="tgl_bap" value="{{ $getPo->tgl_bap }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="tgl_dok_terima">Tgl dok terima</label>
                                  <input type="date" class="form-control" name="tgl_dok_terima" id="tgl_dok_terima" value="{{ $getPo->tgl_dok_terima }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="no_info_cancel">No Info Cancel</label>
                                  <input type="text" class="form-control" name="no_info_cancel" id="no_info_cancel"  value="{{ $getPo->no_info_cancel }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="no_goods_issued">No Goods Issue</label>
                                  <input type="text" class="form-control" name="no_goods_issued" id="no_goods_issued" value="{{ $getPo->no_goods_issued }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="no_kapitalisasi">No Kapitalisasi</label>
                                  <input type="text" class="form-control" name="no_kapitalisasi" id="no_kapitalisasi" value="{{ $getPo->no_kapitalisasi }}">
                                </div>
                            </div>
                            <div class="col-3 mt-3">
                                <div class="form-group">
                                  <label for="bulan_po">Bulan PO</label>
                                  <input type="text" class="form-control" name="bulan_po" id="bulan_po" value="{{ $getPo->bulan_po }}" >
                                </div>
                            </div>
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                  <label for="keterangan">Keterangan</label>
                                  <input type="text" class="form-control" name="keterangan" id="keterangan" value="{{ $getPo->keterangan }}">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/relokasi" class="btn btn-secondary" >Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>



        </div>
    </div>
@endsection
