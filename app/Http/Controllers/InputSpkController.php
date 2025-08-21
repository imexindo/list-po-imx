<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $response = Http::get(env('SAP_API') . '/api/search-spk', [
            'search' => $search
        ]);

        return response()->json($response->json());
    }

    public function getSpk(Request $request)
    {

        $search = $request->query('search');

        $response = Http::get(env('SAP_API') . '/api/verify-spk', [
            'search' => $search
        ]);

        return $response->json();
    }


    public function store(Request $request)
    {
        // dd($request->all());
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

            foreach ($mapping as $reqKey => $dbKey) {
                if ($request->has($reqKey)) {
                    $po->$dbKey = $request->input($reqKey);
                }
            }

            $po->no_seri = $this->generateNoSeri();

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

    private function generateNoSeri()
    {
        $year = date('y');
        $month = date('m');
        $prefix = "BP{$year}{$month}";

        do {
            
            $random = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $noSeri = $prefix . $random;
            
            $exists = PO::where('no_seri', $noSeri)->exists();
        } while ($exists);

        return $noSeri;
    }
}
