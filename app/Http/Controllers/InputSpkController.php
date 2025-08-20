<?php

namespace App\Http\Controllers;

use App\Models\PO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InputSpkController extends Controller
{
    public function index()
    {
        return view('pages.input_spk.index');
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

            $po->spk = $request->spk;
            $po->po = $request->po;
            $po->so = $request->so;
            $po->tgl_po = $request->tgl_po;
            $po->tipe = $request->tipe;
            $po->kode = $request->kode;
            $po->nama = $request->nama;
            $po->dc = $request->dc;
            $po->idm = $request->idm;
            $po->subkon = $request->subkon;
            $po->bap = $request->bap;
            $po->start = $request->start;
            $po->due = $request->due;
            $po->sj = $request->sj;
            $po->cabut = $request->cabut;
            $po->lok = $request->lok;
            $po->harga_sewa = $request->harga_sewa;
            $po->ket = $request->ket;

            foreach ($mapping as $reqKey => $dbKey) {
                if ($request->has($reqKey)) {
                    $po->$dbKey = $request->input($reqKey);
                }
            }

            $po->no_seri = $this->generateNoSeri();

            $po->save();

            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Throwable $th) {
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
