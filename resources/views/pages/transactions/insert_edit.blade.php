@extends('layouts.main')

<title>LIST SEWA | Edit Kontrak AC</title>

<style>
   .label-pk {
    font-size: 11px;
   }
   .pk-input {
    text-align: center
   }
</style>

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Transaksi Edit</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transaksi</li>
                        <li class="breadcrumb-item active">Edit Kontrak AC</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('insert-contract.modal.update', $contracts->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="tagihan">Tagihan</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="tagihan" value="0">
                                        <input class="form-check-input" type="checkbox" role="switch" id="tagihan" name="tagihan" value="1" {{ old('tagihan', $contracts['tagihan']) == 1 ? 'checked' : '' }} style="height: 30px; width: 60px">
                                        <label class="form-check-label" for="tagihan" style="margin-left: 20px;">
                                            {{ old('tagihan', $contracts['tagihan']) == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="kode" class="form-label">Kode</label>
                                    <input type="text" class="form-control" name="kode" value="{{$contracts['kode']}}" readonly required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="spk" class="form-label">SPK</label>
                                    <input type="text" class="form-control" name="spk" value="{{$contracts['spk']}}" readonly required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="tgl_bap" class="form-label">Tgl Bap</label>
                                    <input type="text" class="form-control" name="tgl_bap" value="{{ \Carbon\Carbon::parse($contracts['tgl_bap'])->format('d-m-Y') }}" readonly required>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="mb-3">
                                    <label for="total_pk" class="form-label">Total PK</label>
                                    <input type="text" class="form-control" name="total_pk" value="{{ number_format($contracts['total_pk'], 0, ',', '.') }}" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="kode_idm" class="form-label">Kode IDM</label>
                                    <input type="text" class="form-control" name="kode_idm" value="{{$contracts['kode_idm']}}" readonly required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tgl_habis_sewa" class="form-label">Tanggal Habis Sewa</label>
                                    <input type="date" class="form-control" name="tgl_habis_sewa" value="{{$contracts['tgl_habis_sewa']}}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="tgl_cabut" class="form-label">Tanggal Cabut</label>
                                    <input type="date" class="form-control" name="tgl_cabut" value="{{$contracts['tgl_cabut']}}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <div class="form-group">
                                      <label for="">Pilih Keterangan</label>
                                      <select class="form-control" name="category_cabut_id" >
                                        <option value="{{null}}">Pilih</option>
                                        @foreach ($categoryCabut as $item)
                                            <option value="{{$item->id}}" {{ $contracts['category_cabut_id'] == $item->id ? 'selected' : '' }}>{{$item->category}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                  <label for="files">Upload Dokumen</label>
                                  @if (!is_null($contracts['files']))
                                    <a href="{{ asset('storage/' . $contracts['files']) }}" target="_blank">Lihat File</a>
                                  @endif
                                  <input type="file" class="form-control mb-1" name="files" >

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="KF-15" class="form-label label-pk">KF-15</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_15']}}" name="kf_15">
                                </div>
                                <div class="col">
                                    <label for="KF-20" class="form-label label-pk">KF-20</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_20']}}" name="kf_20">
                                </div>
                                <div class="col">
                                    <label for="KF-23" class="form-label label-pk">KF-23</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_23']}}" name="kf_23">
                                </div>
                                <div class="col">
                                    <label for="KF-26" class="form-label label-pk">KF-26</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_26']}}" name="kf_26">
                                </div>
                                <div class="col">
                                    <label for="KF-26" class="form-label label-pk">KF-34</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_34']}}" name="kf_34">
                                </div>
                                <div class="col">
                                    <label for="KF-15" class="form-label label-pk">KF-50</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_50']}}" name="kf_50">
                                </div>
                                <div class="col">
                                    <label for="KF-20" class="form-label label-pk">KF-70</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_70']}}" name="kf_70">
                                </div>
                                <div class="col">
                                    <label for="KF-23" class="form-label label-pk">KF-100</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_100']}}"  name="kf_100">
                                </div>
                                <div class="col">
                                    <label for="KF-120" class="form-label label-pk">KF-120</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['kf_120']}}"  name="kf_120">
                                </div>
                                <div class="col">
                                    <label for="SD-70" class="form-label label-pk">SD-70</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['sd_70']}}" name="sd_70">
                                </div>
                                <div class="col">
                                    <label for="SD-90" class="form-label label-pk">SD-90</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['sd_90']}}" name="sd_90">
                                </div>
                                <div class="col">
                                    <label for="SD-120" class="form-label label-pk">SD-120</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['sd_120']}}"  name="sd_120" >
                                </div>
                                <div class="col">
                                    <label for="DB-60" class="form-label label-pk">DB-60</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['db_60']}}" name="db_60">
                                </div>
                                <div class="col">
                                    <label for="DB-80" class="form-label label-pk">DB-80</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['db_80']}}" name="db_80">
                                </div>
                                <div class="col">
                                    <label for="DB-100" class="form-label label-pk">DB-100</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['db_100']}}"  name="db_100" >
                                </div>
                                <div class="col">
                                    <label for="DB-150" class="form-label label-pk">DB-150</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['db_150']}}"  name="db_150" >
                                </div>
                                <div class="col">
                                    <label for="DB-200" class="form-label label-pk">DB-200</label>
                                    <input type="text" class="form-control pk-input" value="{{$contracts['db_200']}}"  name="db_200" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{$contracts['nama']}}" readonly required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">Kontrak</label>
                                    <select class="form-control" name="contract_id" disabled>
                                        <option value="{{ null }}">--Pilih--</option>
                                        @foreach ($masterContracts as $item)
                                            <option value="{{ $item->id }}" {{ $contracts['contract_id'] == $item->id ? 'selected' : '' }}>{{ $item->code }} - {{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="">DC</label>
                                    <select class="form-control" name="region_id" id="region_id" disabled>
                                        <option value="{{ null }}">--Pilih--</option>
                                        @foreach ($dc as $item)
                                        <option value="{{ $item['cardcode'] }}" {{ $contracts['region_id'] == $item['cardcode'] ? 'selected' : '' }}>{{ $item['CardName'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <label for="group_name" class="form-label">Group</label>
                                <select id="group_name" name="group_name" class="form-select" required>
                                    <option value="">-----Pilih Group-----</option>
                                    @foreach ($groupedDataDcGroup as $item)
                                        <option value="{{ $item['GroupName'] }}" {{ $contracts['group_name'] == $item['GroupName'] ? 'selected' : '' }}> {{ $item['GroupName'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" cols="10" rows="10" class="form-control" placeholder="Berikan Keterangan">{{$contracts['keterangan']}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
