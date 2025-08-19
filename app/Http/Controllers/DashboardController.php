<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Contracts;
use App\Models\Region;
use App\Models\Reports;
use App\Models\TypeContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $toko = Contracts::where('tagihan', 1)
            ->distinct('kode')
            ->count('region_id');

        $contracts = Contracts::where('tagihan', 1)->count();
        $contract = Contract::count();
        $contractTipe = TypeContract::count();
        $region = Region::count();

        $currentYear = Carbon::now()->year;

        $monthlyContractsBar = Contracts::select(DB::raw('COUNT(*) as count'), DB::raw('MONTH(tgl_bap) as month'))
            ->whereYear('tgl_bap', $currentYear)
            ->where('tagihan', 1)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();


        $monthlyDataBar = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyDataBar[] = $monthlyContractsBar[$i] ?? 0;
        }


        $startYear = 2018;
        $currentYear = Carbon::now()->year;

        $yearlyContractsLine = Contracts::where('tagihan', 1)->select(DB::raw('SUM(total_pk) as total'), DB::raw('YEAR(tgl_bap) as year'))
            ->whereBetween('tgl_bap', [
                Carbon::create($startYear, 1, 1)->startOfDay(),
                Carbon::create($currentYear, 12, 31)->endOfDay()
            ])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $yearlyTotals = [];
        $yearLabels = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $yearlyTotals[] = $yearlyContractsLine[$year] ?? 0;
            $yearLabels[] = $year;
        }


        // start Total SPK
        $currentYear = Carbon::now()->year;

        $yearlyContractsLineSpk = Contracts::select(DB::raw('COUNT(*) as total'), DB::raw('YEAR(tgl_bap) as year'))
            ->whereYear('tgl_bap', '>=', $startYear)
            ->where('tagihan', 1)
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $yearlyTotalsSpk = [];
        for ($i = $startYear; $i <= $currentYear; $i++) {
            $yearlyTotalsSpk[] = $yearlyContractsLineSpk[$i] ?? 0;
        }
        // end total PK

        $laporan = Contracts::where('tagihan', 1)
            ->sum('total_pk');

        $nonAktif = Contracts::where('tagihan', 0)->count();
        $aktif = Contracts::where('tagihan', 1)->count();

        return view('pages.dashboard', compact('contracts', 'toko', 'contract', 'contractTipe', 'region', 'yearlyTotals', 'yearLabels', 'laporan', 'nonAktif', 'aktif', 'yearlyTotalsSpk', 'startYear', 'currentYear'));
    }

    public function getYearlyContractsJson()
    {
        $startYear = 2018;
        $currentYear = Carbon::now()->year;

        $yearlyContractsLine = Contracts::where('tagihan', 1)
            ->select(
            DB::raw('SUM(total_pk) as total'),
            DB::raw('YEAR(tgl_bap) as year')
        )
            ->whereBetween('tgl_bap', [
                Carbon::create($startYear, 1, 1)->startOfDay(),
                Carbon::create($currentYear, 12, 31)->endOfDay()
            ])
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $yearlyTotals = [];
        $yearLabels = [];
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $yearlyTotals[] = $yearlyContractsLine[$year] ?? 0;
            $yearLabels[] = $year;
        }

        return response()->json([
            'labels' => $yearLabels,
            'data' => $yearlyTotals,
        ]);
    }


    public function getChartData()
    {
        $dkContracts = Contracts::where('tagihan', 1)
            ->where('group_contract_id', 1)
            ->count(); // DK
        $jContracts = Contracts::where('tagihan', 1)
            ->where('group_contract_id', 2)
            ->count(); // J
        $ljContracts = Contracts::where('tagihan', 1)
            ->where('group_contract_id', 3)
            ->count(); // LJ


        return response()->json([
            'status' => 200,
            'data' => [
                'DK' => $dkContracts,
                'J' => $jContracts,
                'LJ' => $ljContracts
            ]
        ]);
    }


    public function getKFChartData()
    {
        $startYear = 2018;
        $currentYear = date('Y');

        $kfData = Contracts::select(
            DB::raw('SUM(kf_15) as KF_15'),
            DB::raw('SUM(kf_20) as KF_20'),
            DB::raw('SUM(kf_23) as KF_23'),
            DB::raw('SUM(kf_26) as KF_26'),
            DB::raw('SUM(kf_34) as KF_34'),
            DB::raw('SUM(kf_50) as KF_50'),
            DB::raw('SUM(kf_70) as KF_70'),
            DB::raw('SUM(kf_100) as KF_100'),
            DB::raw('SUM(kf_120) as KF_120'),
            DB::raw('SUM(sd_70) as SD_70'),
            DB::raw('SUM(sd_90) as SD_90'),
            DB::raw('SUM(db_60) as DB_60'),
            DB::raw('SUM(db_80) as DB_80'),
            DB::raw('SUM(db_100) as DB_100'),
            DB::raw('SUM(db_150) as DB_150'),
            DB::raw('SUM(db_200) as DB_200'),
            DB::raw('YEAR(tgl_bap) as year')
        )
            ->where('tagihan', 1)
            ->whereYear('tgl_bap', '>=', $startYear)
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->toArray();


        return response()->json([
            'status' => 200,
            'data' => $kfData
        ]);
    }


    public function countKFTotal()
    {
        $kfTotals = Contracts::select(
            DB::raw('SUM(kf_15) as KF_15_Total'),
            DB::raw('SUM(kf_20) as KF_20_Total'),
            DB::raw('SUM(kf_23) as KF_23_Total'),
            DB::raw('SUM(kf_26) as KF_26_Total'),
            DB::raw('SUM(kf_34) as KF_34_Total'),
            DB::raw('SUM(kf_50) as KF_50_Total'),
            DB::raw('SUM(kf_70) as KF_70_Total'),
            DB::raw('SUM(kf_100) as KF_100_Total'),
            DB::raw('SUM(kf_120) as KF_120_Total'),
            DB::raw('SUM(sd_70) as SD_70_Total'),
            DB::raw('SUM(sd_90) as SD_90_Total'),
            DB::raw('SUM(sd_120) as SD_120_Total'),
            DB::raw('SUM(db_60) as DB_60_Total'),
            DB::raw('SUM(db_80) as DB_80_Total'),
            DB::raw('SUM(db_100) as DB_100_Total'),
            DB::raw('SUM(db_150) as DB_150_Total'),
            DB::raw('SUM(db_200) as DB_200_Total')
        )
            ->whereYear('tgl_bap', '>=', 2018)
            ->where('tagihan', 1)
            ->get()
            ->first();


        return response()->json([
            'status' => 200,
            'data' => $kfTotals
        ]);
    }
}
