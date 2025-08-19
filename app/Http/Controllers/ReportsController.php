<?php

namespace App\Http\Controllers;

use App\Exports\ContractsExportDc;
use App\Exports\ContractsExportDcAll;
use App\Exports\ContractsExportDcNon;
use App\Exports\ContractsExportKontrak;
use App\Exports\ContractsExportKontrakAll;
use App\Exports\ContractsExportKontrakNon;
use App\Exports\ContractsExportReport;
use App\Exports\ContractsExportReportAll;
use App\Exports\ContractsExportReportNon;
use App\Exports\ContractsExportSum;
use App\Models\Contract;
use App\Models\Contracts;
use App\Models\Reports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        $cardCodes = collect($dc)->pluck('cardcode');

        $total = Contracts::sum('total_pk');
        $totalSpk = Contracts::sum('total_spk');

        $wilayah = Contracts::select('region_id')
            ->distinct()
            ->get()
            ->count();

        if ($request->ajax()) {
            $summary = Contracts::query()
                ->orderBy('created_at', 'desc')
                ->where('tagihan', 1)
                ->whereIn('region_id', $cardCodes);

            return DataTables::of($summary)
                ->addIndexColumn()
                ->addColumn('no', function ($row) {
                    return $row->id;
                })
                ->addColumn('group_name', function ($row) {
                    return $row->group_name;
                })
                ->addColumn('contract_code', function ($row) {
                    return $row->contract->title . ' - ' . $row->contract->year;
                })
                ->addColumn('region_id', function ($row) use ($dc) {
                    $matchingDc = collect($dc)->firstWhere('cardcode', $row->region_id);
                    return $matchingDc ? $matchingDc['CardName'] : $row->region_id;
                })
                ->addColumn('total_spk', function ($row) {
                    return $row->total_spk;
                })
                ->addColumn('kf_00', function ($row) {
                    return $row->kf_00;
                })
                ->rawColumns(['total_spk'])
                ->make(true);
        }

        return view('pages.reports.summary', compact('total', 'totalSpk', 'wilayah'));
    }


    // all
    public function index_reports(Request $request)
    {
        $query = Contracts::where('tagihan', 1);

        if ($request->filled('from') && $request->filled('to')) {
            $from = $request->input('from');
            $to = $request->input('to');
            $query->whereBetween('tgl_bap', [$from, $to]);
        }

        $total = $query->sum('total_pk');
        $totalSpk = $query->sum('total_spk');

        $reports = $query->with('contract_group')
            ->select('group_contract_id')
            ->selectRaw('COUNT(DISTINCT contract_id) as count_contract_id')
            ->selectRaw('SUM(total_spk) as total_spk')
            ->selectRaw('SUM(db_60) as db_60')
            ->selectRaw('SUM(db_80) as db_80')
            ->selectRaw('SUM(db_100) as db_100')
            ->selectRaw('SUM(db_150) as db_150')
            ->selectRaw('SUM(db_200) as db_200')
            ->selectRaw('SUM(sd_70) as sd_70')
            ->selectRaw('SUM(sd_90) as sd_90')
            ->selectRaw('SUM(sd_120) as sd_120')
            ->selectRaw('SUM(kf_00) as kf_00')
            ->selectRaw('SUM(kf_15) as kf_15')
            ->selectRaw('SUM(kf_20) as kf_20')
            ->selectRaw('SUM(kf_23) as kf_23')
            ->selectRaw('SUM(kf_26) as kf_26')
            ->selectRaw('SUM(kf_34) as kf_34')
            ->selectRaw('SUM(kf_50) as kf_50')
            ->selectRaw('SUM(kf_70) as kf_70')
            ->selectRaw('SUM(kf_100) as kf_100')
            ->selectRaw('SUM(kf_120) as kf_120')
            ->selectRaw('SUM(total_pk) as total_biaya')
            ->selectRaw('MAX(created_at) as latest_creation_date')
            ->groupBy('group_contract_id')
            ->orderBy('latest_creation_date', 'desc')
            ->get();

        return view('pages.reports.index', compact('reports', 'total', 'totalSpk'));
    }


    // all details
    public function index_reports_details(Request $request, $contacts_id)
    {
        $from = $request->input('from');
        $to   = $request->input('to');

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        $details = Contracts::where('group_contract_id', $contacts_id)
            ->where('tagihan', 1)
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('tgl_bap', [$from, $to]);
            })
            ->get();

        $details->each(function ($detail) use ($dc) {
            $detail->region_name = $dc->firstWhere('cardcode', $detail->region_id)['CardName'] ?? 'Tidak Diketahui';
        });

        $groupedDetails = $details->groupBy('region_id')->map(function ($group) {
            return $group->reduce(function ($carry, $item) {
                $carry['db_60'] += (int) $item->db_60;
                $carry['db_80'] += (int) $item->db_80;
                $carry['db_100'] += (int) $item->db_100;
                $carry['db_150'] += (int) $item->db_150;
                $carry['db_200'] += (int) $item->db_200;
                $carry['sd_70'] += (int) $item->sd_70;
                $carry['sd_90'] += (int) $item->sd_90;
                $carry['sd_120'] += (int) $item->sd_120;
                $carry['kf_00'] += (int) $item->kf_00;
                $carry['kf_15'] += (int) $item->kf_15;
                $carry['kf_20'] += (int) $item->kf_20;
                $carry['kf_23'] += (int) $item->kf_23;
                $carry['kf_26'] += (int) $item->kf_26;
                $carry['kf_34'] += (int) $item->kf_34;
                $carry['kf_50'] += (int) $item->kf_50;
                $carry['kf_70'] += (int) $item->kf_70;
                $carry['kf_100'] += (int) $item->kf_100;
                $carry['kf_120'] += (int) $item->kf_120;
                $carry['total_biaya'] += (int) $item->total_pk;
                $carry['total_spk'] += (int) $item->total_spk;
                return $carry;
            }, [
                'db_60' => 0,
                'db_80' => 0,
                'db_100' => 0,
                'db_150' => 0,
                'db_200' => 0,
                'sd_70' => 0,
                'sd_90' => 0,
                'sd_120' => 0,
                'kf_00' => 0,
                'kf_15' => 0,
                'kf_20' => 0,
                'kf_23' => 0,
                'kf_26' => 0,
                'kf_34' => 0,
                'kf_50' => 0,
                'kf_70' => 0,
                'kf_100' => 0,
                'kf_120' => 0,
                'total_biaya' => 0,
                'total_spk' => 0
            ]);
        });

        return response()->json(
            $groupedDetails->map(function ($item, $region_id) use ($contacts_id, $dc) {
                $item['region_id'] = $region_id;
                $item['contacts_id'] = $contacts_id;
                $item['region_name'] = $dc->firstWhere('cardcode', $region_id)['CardName'] ?? 'Tidak Diketahui';
                return $item;
            })->values()
        );
    }


    // toko
    public function index_reports_toko(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $contractsQuery = Contracts::where('tagihan', 1)
            ->whereIn('group_name', ['indomaret']);

        if ($from && $to) {
            $contractsQuery->whereBetween('tgl_bap', [$from, $to]);
        }

        $total = (clone $contractsQuery)->sum('total_pk');
        $totalSpk = (clone $contractsQuery)->sum('total_spk');

        $kf15 = (clone $contractsQuery)->sum('kf_15');
        $kf20 = (clone $contractsQuery)->sum('kf_20');
        $kf23 = (clone $contractsQuery)->sum('kf_23');
        $kf26 = (clone $contractsQuery)->sum('kf_26');
        $kf34 = (clone $contractsQuery)->sum('kf_34');
        $kf50 = (clone $contractsQuery)->sum('kf_50');
        $kf70 = (clone $contractsQuery)->sum('kf_70');
        $kf100 = (clone $contractsQuery)->sum('kf_100');
        $kf120 = (clone $contractsQuery)->sum('kf_120');
        $sd70 = (clone $contractsQuery)->sum('sd_70');
        $sd90 = (clone $contractsQuery)->sum('sd_90');
        $sd120 = (clone $contractsQuery)->sum('sd_120');
        $db60 = (clone $contractsQuery)->sum('db_60');
        $db80 = (clone $contractsQuery)->sum('db_80');
        $db100 = (clone $contractsQuery)->sum('db_100');
        $db150 = (clone $contractsQuery)->sum('db_150');
        $db200 = (clone $contractsQuery)->sum('db_200');

        $reports = (clone $contractsQuery)
            ->with('contract')
            ->select('contract_id')
            ->selectRaw('COUNT(DISTINCT contract_id) as count_contract_id')
            ->selectRaw('SUM(total_spk) as total_spk')
            ->selectRaw('SUM(db_60) as db_60')
            ->selectRaw('SUM(db_80) as db_80')
            ->selectRaw('SUM(db_100) as db_100')
            ->selectRaw('SUM(db_150) as db_150')
            ->selectRaw('SUM(db_200) as db_200')
            ->selectRaw('SUM(sd_70) as sd_70')
            ->selectRaw('SUM(sd_90) as sd_90')
            ->selectRaw('SUM(sd_120) as sd_120')
            ->selectRaw('SUM(kf_00) as kf_00')
            ->selectRaw('SUM(kf_15) as kf_15')
            ->selectRaw('SUM(kf_20) as kf_20')
            ->selectRaw('SUM(kf_23) as kf_23')
            ->selectRaw('SUM(kf_26) as kf_26')
            ->selectRaw('SUM(kf_34) as kf_34')
            ->selectRaw('SUM(kf_50) as kf_50')
            ->selectRaw('SUM(kf_70) as kf_70')
            ->selectRaw('SUM(kf_100) as kf_100')
            ->selectRaw('SUM(kf_120) as kf_120')
            ->selectRaw('SUM(total_pk) as total_biaya')
            ->selectRaw('MAX(created_at) as latest_creation_date')
            ->groupBy('contract_id')
            ->orderBy('latest_creation_date', 'desc')
            ->get();

        return view('pages.reports.index_toko', compact(
            'reports',
            'total',
            'totalSpk',
            'kf15',
            'kf20',
            'kf23',
            'kf26',
            'kf34',
            'kf50',
            'kf70',
            'kf100',
            'kf120',
            'sd70',
            'sd90',
            'sd120',
            'db60',
            'db80',
            'db100',
            'db150',
            'db200'
        ));
    }


    // detail toko
    public function index_reports_details_toko(Request $request, $contacts_id)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        $details = Contracts::where('contract_id', $contacts_id)
            ->where('tagihan', 1)
            ->whereIn('group_name', ['indomaret']);

        if ($from && $to) {
            $details = $details->whereBetween('tgl_bap', [$from, $to]);
        }

        $details = $details->get();

        $details->each(function ($detail) use ($dc) {
            $detail->region_name = $dc->firstWhere('cardcode', $detail->region_id)['CardName'] ?? 'Tidak Diketahui';
        });

        $groupedDetails = $details->groupBy('region_id')->map(function ($group) {
            return $group->reduce(function ($carry, $item) {
                $carry['db_60'] += (int) $item->db_60;
                $carry['db_80'] += (int) $item->db_80;
                $carry['db_100'] += (int) $item->db_100;
                $carry['db_150'] += (int) $item->db_150;
                $carry['db_200'] += (int) $item->db_200;
                $carry['sd_70'] += (int) $item->sd_70;
                $carry['sd_90'] += (int) $item->sd_90;
                $carry['sd_120'] += (int) $item->sd_120;
                $carry['kf_00'] += (int) $item->kf_00;
                $carry['kf_15'] += (int) $item->kf_15;
                $carry['kf_20'] += (int) $item->kf_20;
                $carry['kf_23'] += (int) $item->kf_23;
                $carry['kf_26'] += (int) $item->kf_26;
                $carry['kf_34'] += (int) $item->kf_34;
                $carry['kf_50'] += (int) $item->kf_50;
                $carry['kf_70'] += (int) $item->kf_70;
                $carry['kf_100'] += (int) $item->kf_100;
                $carry['kf_120'] += (int) $item->kf_120;
                $carry['total_biaya'] += (int) $item->total_pk;
                $carry['total_spk'] += (int) $item->total_spk;
                return $carry;
            }, [
                'db_60' => 0,
                'db_80' => 0,
                'db_100' => 0,
                'db_150' => 0,
                'db_200' => 0,
                'sd_70' => 0,
                'sd_90' => 0,
                'sd_120' => 0,
                'kf_00' => 0,
                'kf_15' => 0,
                'kf_20' => 0,
                'kf_23' => 0,
                'kf_26' => 0,
                'kf_34' => 0,
                'kf_50' => 0,
                'kf_70' => 0,
                'kf_100' => 0,
                'kf_120' => 0,
                'total_biaya' => 0,
                'total_spk' => 0
            ]);
        });

        return response()->json(
            $groupedDetails->map(function ($item, $region_id) use ($contacts_id, $dc) {
                $item['region_id'] = $region_id;
                $item['contacts_id'] = $contacts_id;
                $item['region_name'] = $dc->firstWhere('cardcode', $region_id)['CardName'] ?? 'Tidak Diketahui';
                return $item;
            })->values()
        );
    }


    // Detail DC 
    public function index_reports_details_dc(Request $request, $contractId, $regionId)
    {

        $contractId = base64_decode($contractId);
        $regionId   = base64_decode($regionId);

        $from = $request->input('from');
        $to   = $request->input('to');

        
        $query = Contracts::with(['contract', 'type_contracts', 'region', 'category'])
            ->where('region_id', $regionId)
            ->where('contract_id', $contractId)
            ->where('tagihan', 1)
            ->whereIn('group_name', ['indomaret'])
            ->orderBy('created_at', 'asc');


        if ($from && $to) {
            $query->whereBetween('tgl_bap', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $data = $query->get();
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        $dcMapping = collect($dc)->pluck('CardName', 'cardcode');

        foreach ($data as $contract) {
            $contract->cardname = $dcMapping->get($contract->region_id, '');

            if ($contract->tgl_habis_sewa === null) {
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
                    $contract->remaining_months = ($remainingTime->y * 12) + $remainingTime->m;
                    $contract->remaining_weeks = floor($remainingTime->days / 7);
                    $contract->remaining_days = $remainingTime->days % 7;
                } else {
                    $contract->remaining_months = 0;
                    $contract->remaining_weeks = 0;
                    $contract->remaining_days = 0;
                }
            }
        }


        return view('pages.reports.detail_dc.index', compact('data', 'from', 'to'));
    }


    // NON TOKO
    public function index_reports_NON(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = Contracts::where('tagihan', 1)->whereNotIn('group_name', ['indomaret']);

        if ($from && $to) {
            $query->whereBetween('tgl_bap', [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
        }

        $total = (clone $query)->sum('total_pk');
        $totalSpk = (clone $query)->sum('total_spk');

        $kf15 = (clone $query)->sum('kf_15');
        $kf20 = (clone $query)->sum('kf_20');
        $kf23 = (clone $query)->sum('kf_23');
        $kf26 = (clone $query)->sum('kf_26');
        $kf34 = (clone $query)->sum('kf_34');
        $kf50 = (clone $query)->sum('kf_50');
        $kf70 = (clone $query)->sum('kf_70');
        $kf100 = (clone $query)->sum('kf_100');
        $kf120 = (clone $query)->sum('kf_120');

        $sd70 = (clone $query)->sum('sd_70');
        $sd90 = (clone $query)->sum('sd_90');
        $sd120 = (clone $query)->sum('sd_120');

        $db60 = (clone $query)->sum('db_60');
        $db80 = (clone $query)->sum('db_80');
        $db100 = (clone $query)->sum('db_100');
        $db150 = (clone $query)->sum('db_150');
        $db200 = (clone $query)->sum('db_200');

        $reportsQuery = (clone $query)->with('contract')
            ->select('contract_id')
            ->selectRaw('COUNT(DISTINCT contract_id) as count_contract_id')
            ->selectRaw('SUM(total_spk) as total_spk')
            ->selectRaw('SUM(db_60) as db_60')
            ->selectRaw('SUM(db_80) as db_80')
            ->selectRaw('SUM(db_100) as db_100')
            ->selectRaw('SUM(db_150) as db_150')
            ->selectRaw('SUM(db_200) as db_200')
            ->selectRaw('SUM(sd_70) as sd_70')
            ->selectRaw('SUM(sd_90) as sd_90')
            ->selectRaw('SUM(sd_120) as sd_120')
            ->selectRaw('SUM(kf_00) as kf_00')
            ->selectRaw('SUM(kf_15) as kf_15')
            ->selectRaw('SUM(kf_20) as kf_20')
            ->selectRaw('SUM(kf_23) as kf_23')
            ->selectRaw('SUM(kf_26) as kf_26')
            ->selectRaw('SUM(kf_34) as kf_34')
            ->selectRaw('SUM(kf_50) as kf_50')
            ->selectRaw('SUM(kf_70) as kf_70')
            ->selectRaw('SUM(kf_100) as kf_100')
            ->selectRaw('SUM(kf_120) as kf_120')
            ->selectRaw('SUM(total_pk) as total_biaya')
            ->selectRaw('MAX(created_at) as latest_creation_date')
            ->groupBy('contract_id')
            ->orderBy('latest_creation_date', 'desc');

        $reports = $reportsQuery->get();

        return view('pages.reports.index_non', compact(
            'reports',
            'total',
            'totalSpk',
            'kf15',
            'kf20',
            'kf23',
            'kf26',
            'kf34',
            'kf50',
            'kf70',
            'kf100',
            'kf120',
            'sd70',
            'sd90',
            'sd120',
            'db60',
            'db80',
            'db100',
            'db150',
            'db200'
        ));
    }

    // DETAIL ALL
    public function index_reports_details_all(Request $request, $contractId, $regionId)
    {

        $contractId = base64_decode($contractId);
        $regionId   = base64_decode($regionId);

        $from = $request->input('from');
        $to   = $request->input('to');

        $query = Contracts::with(['contract', 'type_contracts', 'region', 'category'])
            ->where('region_id', $regionId)
            ->where('group_contract_id', $contractId)
            ->where('tagihan', 1)
            ->orderBy('created_at', 'asc');


        if ($from && $to) {
            $query->whereBetween('tgl_bap', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $data = $query->get();
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        $dcMapping = collect($dc)->pluck('CardName', 'cardcode');

        foreach ($data as $contract) {
            $contract->cardname = $dcMapping->get($contract->region_id, '');

            if ($contract->tgl_habis_sewa === null) {
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
                    $contract->remaining_months = ($remainingTime->y * 12) + $remainingTime->m;
                    $contract->remaining_weeks = floor($remainingTime->days / 7);
                    $contract->remaining_days = $remainingTime->days % 7;
                } else {
                    $contract->remaining_months = 0;
                    $contract->remaining_weeks = 0;
                    $contract->remaining_days = 0;
                }
            }
        }


        return view('pages.reports.detail_dc_all.index', compact('data', 'from', 'to'));
    }



    // Detail Dc Non Toko
    public function index_reports_details_non_toko_dc(Request $request, $contractId, $regionId) {

        $contractId = base64_decode($contractId);
        $regionId   = base64_decode($regionId);

        $from = $request->input('from');
        $to   = $request->input('to');

        $query = Contracts::with(['contract', 'type_contracts', 'region', 'category'])
            ->where('region_id', $regionId)
            ->where('contract_id', $contractId)
            ->where('tagihan', 1)
            ->whereNotIn('group_name', ['indomaret'])
            ->orderBy('created_at', 'asc');


        if ($from && $to) {
            $query->whereBetween('tgl_bap', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $data = $query->get();
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? $responseDc->json() : collect();

        $dcMapping = collect($dc)->pluck('CardName', 'cardcode');

        foreach ($data as $contract) {
            $contract->cardname = $dcMapping->get($contract->region_id, '');

            if ($contract->tgl_habis_sewa === null) {
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
                    $contract->remaining_months = ($remainingTime->y * 12) + $remainingTime->m;
                    $contract->remaining_weeks = floor($remainingTime->days / 7);
                    $contract->remaining_days = $remainingTime->days % 7;
                } else {
                    $contract->remaining_months = 0;
                    $contract->remaining_weeks = 0;
                    $contract->remaining_days = 0;
                }
            }
        }


        return view('pages.reports.detail_dc_non.index', compact('data', 'from', 'to'));
    }



    public function index_reports_details_NON($contacts_id, Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        $query = Contracts::where('contract_id', $contacts_id)
            ->where('tagihan', 1)
            ->whereNotIn('group_name', ['indomaret']);

        if ($from && $to) {
            $query->whereBetween('tgl_bap', [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay()
            ]);
        }

        $details = $query->get();

        $details->each(function ($detail) use ($dc) {
            $detail->region_name = $dc->firstWhere('cardcode', $detail->region_id)['CardName'] ?? 'Tidak Diketahui';
        });

        $groupedDetails = $details->groupBy('region_id')->map(function ($group) {
            return $group->reduce(function ($carry, $item) {
                $carry['db_60'] += $item->db_60;
                $carry['db_80'] += $item->db_80;
                $carry['db_100'] += $item->db_100;
                $carry['db_150'] += $item->db_150;
                $carry['db_200'] += $item->db_200;
                $carry['sd_70'] += $item->sd_70;
                $carry['sd_90'] += $item->sd_90;
                $carry['sd_120'] += $item->sd_120;
                $carry['kf_00'] += $item->kf_00;
                $carry['kf_15'] += $item->kf_15;
                $carry['kf_20'] += $item->kf_20;
                $carry['kf_23'] += $item->kf_23;
                $carry['kf_26'] += $item->kf_26;
                $carry['kf_34'] += $item->kf_34;
                $carry['kf_50'] += $item->kf_50;
                $carry['kf_70'] += $item->kf_70;
                $carry['kf_100'] += $item->kf_100;
                $carry['kf_120'] += $item->kf_120;
                $carry['total_biaya'] += (int) $item->total_pk;
                $carry['total_spk'] += $item->total_spk;
                return $carry;
            }, [
                'db_60' => 0,
                'db_80' => 0,
                'db_100' => 0,
                'db_150' => 0,
                'db_200' => 0,
                'sd_70' => 0,
                'sd_90' => 0,
                'sd_120' => 0,
                'kf_00' => 0,
                'kf_15' => 0,
                'kf_20' => 0,
                'kf_23' => 0,
                'kf_26' => 0,
                'kf_34' => 0,
                'kf_50' => 0,
                'kf_70' => 0,
                'kf_100' => 0,
                'kf_120' => 0,
                'total_biaya' => 0,
                'total_spk' => 0
            ]);
        });

        return response()->json(
            $groupedDetails->map(function ($item, $region_id) use ($contacts_id, $dc) {
                $item['region_id'] = $region_id;
                $item['contacts_id'] = $contacts_id;
                $item['region_name'] = $dc->firstWhere('cardcode', $region_id)['CardName'] ?? 'Tidak Diketahui';
                return $item;
            })->values()
        );
    }


    public function store($contract)
    {
        $newData = [
            'total_spk' => 1,
            'db_60' => 0,
            'db_80' => 0,
            'db_100' => 0,
            'db_150' => 0,
            'db_200' => 0,
            'sd_70' => 0,
            'sd_90' => 0,
            'sd_120' => 0,
            'kf_00' => 0,
            'kf_15' => (int) $contract->kf_15,
            'kf_20' => (int) $contract->kf_20,
            'kf_23' => (int) $contract->kf_23,
            'kf_26' => (int) $contract->kf_26,
            'kf_34' => (int) $contract->kf_34,
            'kf_50' => (int) $contract->kf_50,
            'kf_70' => (int) $contract->kf_70,
            'kf_100' => (int) $contract->kf_100,
            'kf_120' => (int) $contract->kf_120,
            'total_biaya' => $contract->total_pk,
            'region_id' => $contract->region_id,
            'contacts_id' => $contract->contract_id,
            'category_cabut_id' => $contract->category_cabut_id,
            'group_name' => $contract->group_name,
            'spk' => $contract->spk,
            'group_contract_id' => $contract->group_contract_id,
            'tgl_bap' => $contract->tgl_bap ? Carbon::parse($contract->tgl_bap)->format('Y-m-d') : '',
        ];

        try {
            // Instantiate a new Reports object
            $report = new Reports();

            // Assign each value to the corresponding attribute
            $report->total_spk = $newData['total_spk'];
            $report->db_60 = $newData['db_60'];
            $report->db_80 = $newData['db_80'];
            $report->db_100 = $newData['db_100'];
            $report->db_150 = $newData['db_150'];
            $report->db_200 = $newData['db_200'];
            $report->sd_70 = $newData['sd_70'];
            $report->sd_90 = $newData['sd_90'];
            $report->sd_120 = $newData['sd_120'];
            $report->kf_00 = $newData['kf_00'];
            $report->kf_15 = $newData['kf_15'];
            $report->kf_20 = $newData['kf_20'];
            $report->kf_23 = $newData['kf_23'];
            $report->kf_26 = $newData['kf_26'];
            $report->kf_34 = $newData['kf_34'];
            $report->kf_50 = $newData['kf_50'];
            $report->kf_70 = $newData['kf_70'];
            $report->kf_100 = $newData['kf_100'];
            $report->kf_120 = $newData['kf_120'];
            $report->total_biaya = $newData['total_biaya'];
            $report->region_id = $newData['region_id'];
            $report->contacts_id = $newData['contacts_id'];
            $report->category_cabut_id = $newData['category_cabut_id'];
            $report->group_name = $newData['group_name'];
            $report->spk = $newData['spk'];
            $report->group_contract_id = $newData['group_contract_id'];
            $report->tgl_bap = $newData['tgl_bap'];

            // Save the report
            $report->save();

            // Success response with status code 200 (OK)
            return redirect()->back()->with('success', 'Report processed successfully!')->setStatusCode(200);
        } catch (\Throwable $th) {
            // Log the error for debugging purposes
            Log::error('Report insert failed: ' . $th->getMessage());

            // Error response with status code 500 (Internal Server Error)
            return redirect()->back()->with('error', 'Failed to process report: ' . $th->getMessage())->setStatusCode(500);
        }
    }

    public function storeNonAktif($contract)
    {

        $newData = [
            'spk' => $contract->spk,
            'total_biaya' => $contract->total_pk,
            'region_id' => $contract->region_id,
            'contacts_id' => $contract->contract_id,
            'db_60' => $contract->db_60,
            'db_80' => $contract->db_80,
            'db_100' => $contract->db_100,
            'db_150' => $contract->db_150,
            'db_200' => $contract->db_200,
            'sd_70' => $contract->sd_70,
            'sd_90' => $contract->sd_90,
            'sd_120' => $contract->sd_120,
            'kf_00' => $contract->kf_00,
            'kf_15' => $contract->kf_15,
            'kf_20' => $contract->kf_20,
            'kf_23' => $contract->kf_23,
            'kf_26' => $contract->kf_26,
            'kf_34' => $contract->kf_34,
            'kf_50' => $contract->kf_50,
            'kf_70' => $contract->kf_70,
            'kf_100' => $contract->kf_100,
            'kf_120' => $contract->kf_120,
        ];

        Reports::create([
            'spk' => $newData['spk'],
            'total_biaya' => $newData['total_biaya'],
            'region_id' => $newData['region_id'],
            'contacts_id' => $newData['contacts_id'],
            'tagihan' => 0,
            'db_60' => $newData['db_60'],
            'db_80' => $newData['db_80'],
            'db_100' => $newData['db_100'],
            'db_150' => $newData['db_150'],
            'db_200' => $newData['db_200'],
            'sd_70' => $newData['sd_70'],
            'sd_90' => $newData['sd_90'],
            'sd_120' => $newData['sd_120'],
            'kf_00' => $newData['kf_00'],
            'kf_15' => $newData['kf_15'],
            'kf_20' => $newData['kf_20'],
            'kf_23' => $newData['kf_23'],
            'kf_26' => $newData['kf_26'],
            'kf_34' => $newData['kf_34'],
            'kf_50' => $newData['kf_50'],
            'kf_70' => $newData['kf_70'],
            'kf_100' => $newData['kf_100'],
            'kf_120' => $newData['kf_120'],
        ]);
    }

    public function tagihanNonAktif($contract)
    {
        $newData = [
            'spk' => $contract->spk,
            'region_id' => $contract->region_id,
            'contacts_id' => $contract->contract_id,
        ];

        try {
            $existingReport = Reports::where('spk', $newData['spk'])
                ->where('region_id', $newData['region_id'])
                ->where('contacts_id', $newData['contacts_id'])
                ->first();

            if ($existingReport) {
                $existingReport->tagihan = 0;
                $existingReport->save();

                return redirect()->back()->with('success', 'Report processed successfully!');
            } else {
                return redirect()->back()->with('error', 'No report found for the given region and contact.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Failed to process report: ' . $th->getMessage());
        }
    }

    public function updateReportFromContracts($contract)
    {
        $newData = [
            'spk' => $contract->spk,
            'total_biaya' => $contract->total_pk,
            'region_id' => $contract->region_id,
            'contacts_id' => $contract->contract_id,
            'db_60' => $contract->db_60,
            'db_80' => $contract->db_80,
            'db_100' => $contract->db_100,
            'db_150' => $contract->db_150,
            'db_200' => $contract->db_200,
            'sd_70' => $contract->sd_70,
            'sd_90' => $contract->sd_90,
            'sd_120' => $contract->sd_120,
            'kf_00' => $contract->kf_00,
            'kf_15' => $contract->kf_15,
            'kf_20' => $contract->kf_20,
            'kf_23' => $contract->kf_23,
            'kf_26' => $contract->kf_26,
            'kf_34' => $contract->kf_34,
            'kf_50' => $contract->kf_50,
            'kf_70' => $contract->kf_70,
            'kf_100' => $contract->kf_100,
            'kf_120' => $contract->kf_120,
            'tagihan' => $contract->tagihan,
            'contract_id' => $contract->contract_id,
        ];

        Reports::where('spk', $newData['spk'])->update($newData);
    }


    public function exportContractsSum(Request $request)
    {

        $from = $request->query('from');
        $to = $request->query('to');

        $filename = 'summary_kontrak' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExportSum($from, $to), $filename);
    }

    public function exportContractsReport(Request $request)
    {

        $from = $request->query('from');
        $to = $request->query('to');

        $filename = 'reports_kontrak' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExportReport($from, $to), $filename);
    }

    public function exportContractsReportNon(Request $request)
    {

        $from = $request->query('from');
        $to = $request->query('to');

        $filename = 'reports_kontrak_non' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExportReportNon($from, $to), $filename);
    }

    public function exportContractsReportAll(Request $request)
    {

        $from = $request->query('from');
        $to = $request->query('to');

        $filename = 'reports_kontrak_all' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExportReportAll($from, $to), $filename);
    }

    public function exportContractsReportDC($contacts_id, $region_id, Request $request)
    {
        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_dc_details_'
                . $getMaster->code . '_&_' . $region_id
                . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_dc_details_'
                . $getMaster->code . '_&_' . $region_id . '.xlsx';
        }

        return Excel::download(
            new ContractsExportDc($contacts_id, $region_id, $from, $to),
            $filename
        );
    }

    public function exportContractsReportDCNon($contacts_id, $region_id, Request $request)
    {
        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_dc_details_non_toko'
                . $getMaster->code . '_&_' . $region_id
                . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_dc_details_non_toko'
                . $getMaster->code . '_&_' . $region_id . '.xlsx';
        }

        return Excel::download(
            new ContractsExportDcNon($contacts_id, $region_id, $from, $to),
            $filename
        );
    }

    public function exportContractsReportDCAll($contacts_id, $region_id, Request $request)
    {
        
        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_dc_details_all'
                . $getMaster->code . '_&_' . $region_id
                . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_dc_details_all'
                . $getMaster->code . '_&_' . $region_id . '.xlsx';
        }

        return Excel::download(
            new ContractsExportDcAll($contacts_id, $region_id, $from, $to),
            $filename
        );
    }


    public function exportContractsReportKontrak(Request $request, $contacts_id)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_toko_'
                . $getMaster->code . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_toko_'
                . $getMaster->code . '.xlsx';
        }

        return Excel::download(
            new ContractsExportKontrak($contacts_id, $from, $to),
            $filename
        );
    }

    public function exportContractsReportKontrakNon(Request $request ,$contacts_id)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');

        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_non_toko_'
                . $getMaster->code . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_non_toko_'
                . $getMaster->code . '.xlsx';
        }

        $filename = 'reports_kontrak_non_toko_' . $getMaster->code . '.xlsx';

        return Excel::download(
            new ContractsExportKontrakNon($contacts_id, $from, $to),
            $filename
        );
    }

    public function exportContractsReportKontrakAll(Request $request, $contacts_id)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '512M');
        
        $getMaster = Contract::find($contacts_id);

        $from = $request->query('from');
        $to   = $request->query('to');

        if (!empty($from) && !empty($to)) {
            $filename = 'reports_kontrak_all_'
                . $getMaster->title . '_' . $from . '_to_' . $to . '.xlsx';
        } else {
            $filename = 'reports_kontrak_all_'
                . $getMaster->title . '.xlsx';
        }
        return Excel::download(
            new ContractsExportKontrakAll($contacts_id, $from, $to),
            $filename
        );
    }
}
