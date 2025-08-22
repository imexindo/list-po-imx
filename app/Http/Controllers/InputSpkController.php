<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class InputSpkController extends Controller
{
    public function index()
    {
        $category = Menu::get();
        return view('pages.input_spk.index', compact('category'));
    }

    public function searchSpk(Request $request)
    {
        $search = $request->query('search');

        $response = Http::get(env('SAP_API') . '/api/list-po/search-spk', [
            'search' => $search
        ]);

        return response()->json($response->json());
    }

    public function getSpk(Request $request)
    {

        $search = $request->query('search');

        $response = Http::get(env('SAP_API') . '/api/list-po/verify-spk', [
            'search' => $search
        ]);

        return $response->json();
    }

    public function getPO()
    {
        $query = PO::query()
            ->with('category_by_menu')
            ->orderBy('created_at', 'desc')
            ->limit(10);

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

            $getPo = PO::with(['category_by_menu:id,name'])
                ->find($decryptId);

            return view('pages.edit-input.index', compact('getPo'));

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


    public function store(Request $request)
    {
        $validated = $request->validate([
            'spk' => 'required|unique:t_po',
            'po' => 'nullable',
            'so' => 'nullable',
            'tgl_po' => 'nullable|date',
            'tipe' => 'nullable',
            'kode' => 'nullable',
            'nama' => 'nullable',
            'dc' => 'nullable',
            'idm' => 'nullable',
            'subkon' => 'nullable',
            'bap' => 'nullable',
            'start' => 'nullable|date',
            'due' => 'nullable|date',
            'sj' => 'nullable',
            'cabut' => 'nullable',
            'lok' => 'nullable',
            'harga_sewa' => 'nullable|numeric',
            'ket' => 'nullable',
            'category_id' => 'required',
        ]);

        try {
            $mapping = [
                'kf-15' => 'kf_15',
                'kf-20' => 'kf_20',
                'kf-23' => 'kf_23',
                'kf-26' => 'kf_26',
                'kf-34' => 'kf_34',
                'kf-50' => 'kf_50',
                'kf-70' => 'kf_70',
                'kf-100' => 'kf_100',
                'kf-120' => 'kf_120',
            ];

            $prefixMapping = [
                1 => 'PB',
                2 => 'DC',
                3 => 'RK',
                4 => 'EX',
                5 => 'PS',
                6 => 'GS',
            ];

            $po = new PO();
            $po->spk = $validated['spk'];
            $po->category_id = $validated['category_id'];
            $po->l_spk = $request->l_spk;
            $po->l_bap = $request->l_bap;
            $po->po = $validated['po'];
            $po->so = $validated['so'];
            $po->tgl_po = $validated['tgl_po'];
            $po->tipe = $validated['tipe'];
            $po->kode = $validated['kode'];
            $po->nama = $validated['nama'];
            $po->dc = $validated['dc'];
            $po->idm = $validated['idm'];
            $po->subkon = $validated['subkon'];
            $po->bap = $validated['bap'];
            $po->start = $validated['start'];
            $po->due = $validated['due'];
            $po->sj = $validated['sj'];
            $po->cabut = $validated['cabut'];
            $po->lok = $validated['lok'];
            $po->harga_sewa = $validated['harga_sewa'];
            $po->ket = $validated['ket'];

            $bulan = $request->bulan_po;
            $namaBulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
            $po->bulan_po = $namaBulan[$bulan] ?? null;

            foreach ($mapping as $reqKey => $dbKey) {
                if ($request->has($reqKey)) {
                    $po->$dbKey = $request->input($reqKey);
                }
            }

            $prefix = $prefixMapping[$validated['category_id']] ?? '-';

            $po->no_seri = $this->generateNoSeri($prefix);

            if (!$po->save()) {
                Log::error('Gagal menyimpan data PO', ['data' => $po]);
                return redirect()->back()->with('error', 'Gagal menyimpan data.');
            }

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
            Log::error('Error saat menyimpan data PO', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $th->getMessage());
        }
    }

    private function generateNoSeri($prefix = 'BP')
    {
        $year = date('y');
        $month = date('m');
        $prefix = "{$prefix}{$year}{$month}";

        do {
            $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $noSeri = $prefix . $random;
            $exists = PO::where('no_seri', $noSeri)->exists();
        } while ($exists);

        return $noSeri;
    }
}
