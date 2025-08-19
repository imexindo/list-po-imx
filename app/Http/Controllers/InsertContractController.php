<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Contracts;
use App\Models\Contract;
use App\Models\CategoryContract;
use App\Exports\ContractsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractsExportAPI;
use App\Models\TypeContract;
use App\Models\Region;
use App\Http\Controllers\ReportsController;
use App\Models\Category;
use App\Models\Reports;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class InsertContractController extends Controller
{
    public function index()
    {
        $contracts = Contracts::orderBy('created_at', 'asc')->get();
        $masterContracts = Contract::all();
        $categoryContracts = CategoryContract::all();
        $region = Region::all();
        $categoryCabut = Category::all();

        $response = Http::get(env('SAP_API') . '/api/pk');
        if ($response->successful()) {
            $pkData = $response->json();

            $groupedData = collect($pkData)
                ->groupBy('U_SOL_PK')
                ->map(function ($group) {
                    return $group->first();
                })
                ->sortByDesc('Id')
                ->values();
        } else {
            $groupedData = collect();
        }

        $responseDcGroup = Http::get(env('SAP_API') . '/api/dc-group');
        if ($responseDcGroup->successful()) {
            $groupedDataDcGroup = $responseDcGroup->json();
        } else {
            $groupedData = collect();
        }

        // Fetch DC data from the API
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        return view('pages.transactions.insert', compact('contracts', 'masterContracts', 'categoryContracts', 'region', 'groupedData', 'groupedDataDcGroup', 'dc', 'categoryCabut'));
    }

    public function index_edit($spk)
    {
        $decodedSpk = base64_decode($spk);
        $contracts = Contracts::where('spk', $decodedSpk)->first();
        $masterContracts = Contract::all();
        $categoryContracts = CategoryContract::all();
        $region = Region::all();
        $categoryCabut = Category::all();

        $response = Http::get(env('SAP_API') . '/api/pk');
        if ($response->successful()) {
            $pkData = $response->json();

            $groupedData = collect($pkData)
                ->groupBy('U_SOL_PK')
                ->map(function ($group) {
                    return $group->first();
                })
                ->sortByDesc('Id')
                ->values();
        } else {
            $groupedData = collect();
        }

        $responseDcGroup = Http::get(env('SAP_API') . '/api/dc-group');
        if ($responseDcGroup->successful()) {
            $groupedDataDcGroup = $responseDcGroup->json();
        } else {
            $groupedData = collect();
        }

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        // dd($contracts);
        return view('pages.transactions.insert_edit', compact('contracts', 'categoryCabut', 'groupedDataDcGroup', 'masterContracts', 'categoryContracts', 'region', 'groupedData', 'dc'));
    }

    public function exportContracts(Request $request)
    {
        set_time_limit(300);

        $from = $request->query('from');
        $to = $request->query('to');
        $region_id = $request->query('region_id');

        $filename = 'contracts_details_' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExport($from, $to, $region_id), $filename);
    }


    public function getContracts(Request $request)
    {
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value', '');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $tagihan = $request->input('tagihan');

        $query = Contracts::with(['contract', 'type_contracts', 'region', 'category'])
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('so', 'like', "%{$search}%")
                    ->orWhere('spk', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('ket', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%")
                    ->orWhere('kode_idm', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('tipe', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('category', 'like', "%{$search}%");
                    });
            });
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tgl_bap', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay()
            ]);

            if (!is_null($tagihan)) {
                $query->where('tagihan', $tagihan);
            }
        }

        $totalRecords = $query->count();
        $contracts = $query->skip($start)->take($length)->get();

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        $dcMapping = collect($dc)->pluck('CardName', 'cardcode');

        $contracts = $contracts->map(function ($contract) use ($dcMapping) {
            // Add cardname based on region_id
            $contract->cardname = $dcMapping->get($contract->region_id, '');

            // Check if tgl_bap is expired
            if ($contract->tgl_habis_sewa === null) {
                // Jika tgl_habis_sewa adalah null, atur semua properti terkait ke null atau nilai default
                $contract->is_expired = null;
                $contract->remaining_months = null;
                $contract->remaining_weeks = null;
                $contract->remaining_days = null;
            } else {
                $expiryDate = Carbon::parse($contract->tgl_habis_sewa);
                $contract->is_expired = $expiryDate->isPast();

                if (!$contract->is_expired) {
                    $now = Carbon::now();
                    $remainingTime = $expiryDate->diff($now);
                    $contract->remaining_months = $remainingTime->y * 12 + $remainingTime->m;
                } else {
                    $contract->remaining_months = 0;
                    $contract->remaining_weeks = 0;
                    $contract->remaining_days = 0;
                }
            }


            return $contract;
        });

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $contracts
        ]);
    }


    public function show($id)
    {
        $contract = Contracts::with('category')
            ->with('contract')
            ->find($id);
        if (!$contract) {
            return response()->json(['message' => 'Contract not found'], 404);
        }

        return response()->json($contract);
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'so' => 'nullable|string|max:50',
            'spk' => 'required|string|max:200',
            'tgl_bap' => 'nullable|string|max:50',
            'kode' => 'nullable|string|max:50',
            'nama' => 'nullable|string|max:50',
            'dc' => 'nullable|string|max:50',
            'lok' => 'nullable|string|max:50',
            'npwp' => 'nullable|string|max:50',
            'total' => 'nullable|numeric',
            'nnpwp' => 'nullable|string|max:50',
            'tipe' => 'nullable|string|max:50',
            'ref' => 'nullable|string|max:150',
            'anpwp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'ket' => 'nullable|string',
            'ruangan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'kf_15' => 'nullable|string|max:5',
            'kf_20' => 'nullable|string|max:5',
            'kf_23' => 'nullable|string|max:5',
            'kf_26' => 'nullable|string|max:5',
            'kf_34' => 'nullable|string|max:5',
            'kf_50' => 'nullable|string|max:5',
            'kf_70' => 'nullable|string|max:5',
            'kf_100' => 'nullable|string|max:5',
            'kf_120' => 'nullable|string|max:5',
            'region_id' => 'required',
            'contract_id' => 'required|integer',
            'group_name' => 'required|string',
            // 'tgl_habis_sewa' => 'required',
            'total_sap' => 'required|string',
        ]);

        $valiadsiSpk = Contracts::where('spk', $request->spk)->first();

        if ($valiadsiSpk) {
            return response()->json(['error' => 'SPK is already in use.'], 500);
        }

        try {
            $contract = new Contracts();

            $contract->so = $request->so;
            $contract->spk = $request->spk;

            $contract->tgl_bap = $request->bap;
            $contract->tgl_habis_sewa = Carbon::parse($contract->tgl_bap)->addYears(5)->format('Y-m-d');
            // dd($contract);
            $contract->kode = $request->kode;
            $contract->nama = $request->nama;
            $contract->dc = $request->dc;
            $contract->lok = $request->lok;
            $contract->npwp = $request->npwp;
            $contract->total = $request->total;
            $contract->nnpwp = $request->nnpwp;
            $contract->tipe = $request->tipe;
            $contract->ref = $request->ref;
            $contract->anpwp = $request->anpwp;
            $contract->alamat = $request->alamat;
            $contract->ket = $request->ket;
            $contract->tagihan = 1;
            $contract->ruangan = $request->ruangan;
            $contract->keterangan = $request->keterangan;

            $contract->kf_15 = $request->kf_15;
            $contract->kf_20 = $request->kf_20;
            $contract->kf_23 = $request->kf_23;
            $contract->kf_26 = $request->kf_26;
            $contract->kf_34 = $request->kf_34;
            $contract->kf_50 = $request->kf_50;
            $contract->kf_70 = $request->kf_70;
            $contract->kf_100 = $request->kf_100;
            $contract->kf_120 = $request->kf_120;

            $contract->sd_70 = $request->sd_70;
            $contract->sd_90 = $request->sd_90;
            $contract->sd_120 = $request->sd_120;

            $contract->db_60 = $request->db_60;
            $contract->db_80 = $request->db_80;
            $contract->db_100 = $request->db_100;
            $contract->db_150 = $request->db_150;
            $contract->db_200 = $request->db_200;

            $contract->kode_idm = $request->kode_idm;

            $contract->contract_id = $request->contract_id;
            $contract->region_id = $request->region_id;
            $contract->group_name = $request->group_name;

            $group = Contract::where('id', $contract->contract_id)->first();

            if ($group) {
                $contract->group_contract_id = $group->group_id;
            }

            $contract->total_sap = $request->total_sap;
            $type = TypeContract::where('m_contract_id', $contract->contract_id)
                ->orderBy('id')
                ->get();

            if (!$type) {
                return redirect()->back()->with('error', 'Input Type Contract!');
            }

            $kfValues = [
                'kf_00' => (int) $contract->kf_00,
                'kf_15' => (int) $contract->kf_15,
                'kf_20' => (int) $contract->kf_20,
                'kf_23' => (int) $contract->kf_23,
                'kf_26' => (int) $contract->kf_26,
                'kf_34' => (int) $contract->kf_34,
                'kf_50' => (int) $contract->kf_50,
                'kf_70' => (int) $contract->kf_70,
                'kf_100' => (int) $contract->kf_100,
                'kf_120' => (int) $contract->kf_120,
                'sd_70' => (int) $contract->sd_70,
                'sd_90' => (int) $contract->sd_90,
                'sd_120' => (int) $contract->sd_120,
                'db_60' => (int) $contract->db_60,
                'db_80' => (int) $contract->db_80,
                'db_100' => (int) $contract->db_100,
                'db_150' => (int) $contract->db_150,
                'db_200' => (int) $contract->db_200,

            ];

            $total = 0;
            foreach ($type as $value) {
                $kfType = strtolower(str_replace('-', '_', $value->type));
                if (isset($kfValues[$kfType]) && $kfValues[$kfType] > 0) {
                    $total += $value->price * $kfValues[$kfType];
                }
            }

            // dd($contract->group_contract_id);

            $contract->total_pk = $total;
            $contract->save();

            $reportsController = new ReportsController();
            $reportsController->store($contract);

            return redirect()->back()->with('success', 'Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed!');
        }
    }

    public function countTotal($contract)
    {

        $type = TypeContract::where('m_contract_id', $contract)
            ->orderBy('id')
            ->get();

        if (!$type) {
            return redirect()->back()->with('error', 'Input Type Contract!');
        }

        $kfValues = [
            'kf_00' => (int) $contract->kf_00,
            'kf_15' => (int) $contract->kf_15,
            'kf_20' => (int) $contract->kf_20,
            'kf_23' => (int) $contract->kf_23,
            'kf_26' => (int) $contract->kf_26,
            'kf_34' => (int) $contract->kf_34,
            'kf_50' => (int) $contract->kf_50,
            'kf_70' => (int) $contract->kf_70,
            'kf_100' => (int) $contract->kf_100,
            'kf_120' => (int) $contract->kf_120,
            'sd_70' => (int) $contract->sd_70,
            'sd_90' => (int) $contract->sd_90,
            'sd_120' => (int) $contract->sd_120,
            'db_60' => (int) $contract->db_60,
            'db_80' => (int) $contract->db_80,
            'db_100' => (int) $contract->db_100,
            'db_150' => (int) $contract->db_150,
            'db_200' => (int) $contract->db_200,

        ];
        $total = 0;
        foreach ($type as $value) {
            $kfType = strtolower(str_replace('-', '_', $value->type));
            if (isset($kfValues[$kfType]) && $kfValues[$kfType] > 0) {
                $total += $value->price * $kfValues[$kfType];
            }
        }

        $contract->total_pk = $total;

        return response()->json($total);
    }

    public function showToko($kode)
    {

        $getToko = Contracts::where('kode', $kode)->get();
        return response()->json($getToko);
    }

    public function updateModal(Request $request, $id)
    {

        $request->validate([
            'tagihan' => 'required|in:0,1',
        ]);

        try {
            $contract = Contracts::findOrFail($id);

            if (!$contract) {
                return redirect()->back()->with('error', 'SPK not found!');
            }
            $contract->tagihan = $request->tagihan;
            if ($request->tagihan == 0) {
                $contract->total_pk = 0;
            } else {

                $type = TypeContract::where('m_contract_id', $contract->contract_id)
                    ->orderBy('id')
                    ->get();

                if (!$type) {
                    return redirect()->back()->with('error', 'Input Type Contract!');
                }

                $kfValues = [
                    'kf_00' => (int) $request->kf_00,
                    'kf_15' => (int) $request->kf_15,
                    'kf_20' => (int) $request->kf_20,
                    'kf_23' => (int) $request->kf_23,
                    'kf_26' => (int) $request->kf_26,
                    'kf_34' => (int) $request->kf_34,
                    'kf_50' => (int) $request->kf_50,
                    'kf_70' => (int) $request->kf_70,
                    'kf_100' => (int) $request->kf_100,
                    'kf_120' => (int) $request->kf_120,
                    'sd_70' => (int) $request->sd_70,
                    'sd_90' => (int) $request->sd_90,
                    'sd_120' => (int) $request->sd_120,
                    'db_60' => (int) $request->db_60,
                    'db_80' => (int) $request->db_80,
                    'db_100' => (int) $request->db_100,
                    'db_150' => (int) $request->db_150,
                    'db_200' => (int) $request->db_200,

                ];

                $total = 0;
                foreach ($type as $value) {
                    $kfType = strtolower(str_replace('-', '_', $value->type));
                    if (isset($kfValues[$kfType]) && $kfValues[$kfType] > 0) {
                        $total += $value->price * $kfValues[$kfType];
                    }
                }
                $contract->total_pk = $total;
            }
            $contract->kf_15 = $request->kf_15;
            $contract->kf_20 = $request->kf_20;
            $contract->kf_23 = $request->kf_23;
            $contract->kf_26 = $request->kf_26;
            $contract->kf_34 = $request->kf_34;
            $contract->kf_50 = $request->kf_50;
            $contract->kf_70 = $request->kf_70;
            $contract->kf_100 = $request->kf_100;
            $contract->kf_120 = $request->kf_120;

            $contract->sd_70 = $request->sd_70;
            $contract->sd_90 = $request->sd_90;
            $contract->sd_120 = $request->sd_120;

            $contract->db_60 = $request->db_60;
            $contract->db_80 = $request->db_80;
            $contract->db_100 = $request->db_100;
            $contract->db_150 = $request->db_150;
            $contract->db_200 = $request->db_200;
            $contract->keterangan = $request->keterangan;
            // $contract->region_id = $request->region_id;
            $contract->tgl_habis_sewa = $request->tgl_habis_sewa;
            $contract->tgl_cabut = $request->tgl_cabut;
            $contract->category_cabut_id = $request->category_cabut_id;
            // $contract->contract_id = $request->contract_id;
            $contract->group_name = $request->group_name;

            if ($request->hasFile('files')) {

                $request->validate([
                    'files' => 'file|mimes:png,jpg,jpeg,pdf|max:2048',
                ]);

                $uniqueCode = mt_rand(1000000000, 9999999999);
                $file = $request->file('files');
                $extension = $file->getClientOriginalExtension();
                $filename = $uniqueCode . '_' . time() . '.' . $extension;
                $path = $file->storeAs('transactions', $filename, 'public');
                $contract->files = $path;
            }
            $contract->user_id = Auth::id();
            $contract->save();

            return redirect()->back()->with('success', 'Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th);
            // throw $th;
        }
    }


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'total_pk' => 'required|string|max:10',
            'tagihan' => 'required|in:0,1',
            'keterangan' => 'nullable|string',
        ]);

        try {
            $contract = Contracts::findOrFail($id);

            if (!$contract) {
                return redirect()->back()->with('error', 'SPK not found!');
            }
            $contract->kode_idm = $request->kode_idm;
            $contract->keterangan = $request->keterangan;
            $contract->ruangan = $request->ruangan;
            $contract->tagihan = $request->tagihan;
            $contract->region_id = $request->region_id;
            $contract->tgl_cabut = $request->tgl_cabut;
            $contract->category_cabut_id = $request->category_cabut_id;
            $contract->group_name = $request->group_name;
            $contract->contract_id = $request->contract_id;
            $contract->tgl_habis_sewa = $request->tgl_habis_sewa;

            $contract->kf_15 = $request->kf_15;
            $contract->kf_20 = $request->kf_20;
            $contract->kf_23 = $request->kf_23;
            $contract->kf_26 = $request->kf_26;
            $contract->kf_34 = $request->kf_34;
            $contract->kf_50 = $request->kf_50;
            $contract->kf_70 = $request->kf_70;
            $contract->kf_100 = $request->kf_100;
            $contract->kf_120 = $request->kf_120;

            $contract->sd_70 = $request->sd_70;
            $contract->sd_90 = $request->sd_90;
            $contract->sd_120 = $request->sd_120;

            $contract->db_60 = $request->db_60;
            $contract->db_80 = $request->db_80;
            $contract->db_100 = $request->db_100;
            $contract->db_150 = $request->db_150;
            $contract->db_200 = $request->db_200;


            if ($request->tagihan == 0) {
                $reportsController = new ReportsController();
                $reportsController->tagihanNonAktif($contract);
                $contract->total_pk = 0;
            } else {
                $type = TypeContract::where('m_contract_id', $contract->contract_id)
                    ->orderBy('id')
                    ->get();

                if (!$type) {
                    return redirect()->back()->with('error', 'Input Type Contract!');
                }

                $kfValues = [
                    'kf_00' => (int) $contract->kf_00,
                    'kf_15' => (int) $contract->kf_15,
                    'kf_20' => (int) $contract->kf_20,
                    'kf_23' => (int) $contract->kf_23,
                    'kf_26' => (int) $contract->kf_26,
                    'kf_34' => (int) $contract->kf_34,
                    'kf_50' => (int) $contract->kf_50,
                    'kf_70' => (int) $contract->kf_70,
                    'kf_100' => (int) $contract->kf_100,
                    'kf_120' => (int) $contract->kf_120,
                    'sd_70' => (int) $contract->sd_70,
                    'sd_90' => (int) $contract->sd_90,
                    'sd_120' => (int) $contract->sd_120,
                    'db_60' => (int) $contract->db_60,
                    'db_80' => (int) $contract->db_80,
                    'db_100' => (int) $contract->db_100,
                    'db_150' => (int) $contract->db_150,
                    'db_200' => (int) $contract->db_200,

                ];

                $total = 0;
                foreach ($type as $value) {
                    $kfType = strtolower(str_replace('-', '_', $value->type));
                    if (isset($kfValues[$kfType]) && $kfValues[$kfType] > 0) {
                        $total += $value->price * $kfValues[$kfType];
                    }
                }
                $contract->total_pk = $total;
                // $contract->total_pk = str_replace('.', '', $request->total_pk);
            }


            if ($request->hasFile('files')) {
                $request->validate([
                    'files' => 'file|mimes:png,jpg,jpeg,pdf|max:2048',
                ]);

                $uniqueCode = mt_rand(1000000000, 9999999999);
                $file = $request->file('files');
                $extension = $file->getClientOriginalExtension();
                $filename = $uniqueCode . '_' . time() . '.' . $extension;
                $path = $file->storeAs('transactions', $filename, 'public');
                $contract->files = $path;
            }

            $contract->user_id = Auth::id();
            $contract->total_pk = str_replace('.', '', $request->total_pk);
            $contract->save();

            // $updateReport = Reports::where('spk', $contract->spk)->first();

            // if ($updateReport) {
            //     $updateReport->update([
            //         'total_biaya' => $contract->total_pk,
            //         'region_id' => $contract->region_id,
            //         'contacts_id' => $contract->contract_id,
            //         'db_60' => $contract->db_60,
            //         'db_80' => $contract->db_80,
            //         'db_100' => $contract->db_100,
            //         'db_150' => $contract->db_150,
            //         'db_200' => $contract->db_200,
            //         'sd_70' => $contract->sd_70,
            //         'sd_90' => $contract->sd_90,
            //         'sd_120' => $contract->sd_120,
            //         'kf_00' => $contract->kf_00,
            //         'kf_15' => $contract->kf_15,
            //         'kf_20' => $contract->kf_20,
            //         'kf_23' => $contract->kf_23,
            //         'kf_26' => $contract->kf_26,
            //         'kf_34' => $contract->kf_34,
            //         'kf_50' => $contract->kf_50,
            //         'kf_70' => $contract->kf_70,
            //         'kf_100' => $contract->kf_100,
            //         'kf_120' => $contract->kf_120,
            //         'tagihan' => $contract->tagihan,
            //         'contract_id' => $contract->contract_id,
            //     ]);
            // }

            return redirect()->back()->with('success', 'Successfully!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed!');
        }
    }

    public function updateTglCabut(Request $request)
    {

        $ids = $request->ids;
        $tagihan = $request->tagihan;
        $userId = Auth::id();

        Contracts::whereIn('id', $ids)
            ->update([
                'tagihan' => $tagihan,
                'user_id' => $userId
            ]);

        return response()->json(['success' => 'Records updated successfully']);
    }
}
