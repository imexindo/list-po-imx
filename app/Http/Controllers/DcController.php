<?php

namespace App\Http\Controllers;

use App\Models\PO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DcController extends Controller
{
    public function index() {
        return view('pages.dc.index');
    }

    public function getPO()
    {
        $query = PO::query()
            ->where('category_id', 2)
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('kf_15', fn($row) => $row->kf_15)
            ->editColumn('kf_20', fn($row) => $row->kf_20)
            ->editColumn('kf_23', fn($row) => $row->kf_23)
            ->editColumn('kf_26', fn($row) => $row->kf_26)
            ->editColumn('kf_34', fn($row) => $row->kf_34)
            ->editColumn('kf_50', fn($row) => $row->kf_50)
            ->editColumn('kf_70', fn($row) => $row->kf_70)
            ->editColumn('kf_100', fn($row) => $row->kf_100)
            ->editColumn('kf_120', fn($row) => $row->kf_120)
            ->editColumn('harga_sewa', fn($row) => number_format($row->harga_sewa, 0, ',', '.'))
            ->make(true);
    }


    public function getPOById($id)
    {
        try {
            $decryptId = base64_decode($id);

            $getPo = PO::with(['category_by_menu:id,name'])->find($decryptId);

            return view('pages.edit-dc.index', compact('getPo'));

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        
        $decryptId = decrypt($id);

        try {
            $pasangBaru = PO::findOrFail($decryptId);

            $pasangBaru->update([
                'po'         => $request->po,
                'so'         => $request->so,
                'tgl_po'     => $request->tgl_po,
                'tipe'       => $request->tipe,
                'kode'       => $request->kode,
                'nama'       => $request->nama,
                'dc'         => $request->dc,
                'idm'        => $request->idm,
                'subkon'     => $request->subkon,
                'bap'        => $request->bap,
                'kf_15'      => $request->{'kf-15'},
                'kf_20'      => $request->{'kf-20'},
                'kf_23'      => $request->{'kf-23'},
                'kf_26'      => $request->{'kf-26'},
                'kf_34'      => $request->{'kf-34'},
                'kf_50'      => $request->{'kf-50'},
                'kf_70'      => $request->{'kf-70'},
                'kf_100'     => $request->{'kf-100'},
                'kf_120'     => $request->{'kf-120'},
                'start'      => $request->start,
                'due'        => $request->due,
                'sj'         => $request->sj,
                'cabut'      => $request->cabut,
                'lok'        => $request->lok,
                'harga_sewa' => $request->harga_sewa,
                'ket'        => $request->ket,
                'l_spk'      => $request->l_spk,
                'l_bap'      => $request->l_bap,
                'tgl_spk'      => $request->tgl_spk,
                'tgl_kirim_unit'      => $request->tgl_kirim_unit,
                'tgl_dok_sj'      => $request->tgl_dok_sj,
                'tgl_pasang'      => $request->tgl_pasang,
                'tgl_bap'      => $request->tgl_bap,
                'tgl_dok_terima'      => $request->tgl_dok_terima,
                'no_info_cancel'      => $request->no_info_cancel,
                'no_goods_issued'      => $request->no_goods_issued,
                'no_kapitalisasi'      => $request->no_kapitalisasi,
                'keterangan'      => $request->keterangan,
                'bulan_po'      => $request->bulan_po,
            ]);

            return redirect()->back()->with('success', 'Data berhasil diperbarui!');

            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }
}
