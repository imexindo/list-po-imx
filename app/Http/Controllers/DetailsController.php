<?php

namespace App\Http\Controllers;

use App\Exports\ContractsExport;
use App\Exports\ContractsExportCreated;
use App\Exports\ContractsExportRekap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class DetailsController extends Controller
{
    public function index()
    {

        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        return view('pages.reports.details', compact('dc'));
    }

    public function index_for_rekap()
    {
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        return view('pages.reports.details_rekap', compact('dc'));
    }

    public function exportContractsRekap()
    {
        set_time_limit(0);
        $filename = 'contracts_details_rekap.xlsx';
        return Excel::download(new ContractsExportRekap(), $filename);
    }


    public function exportContracts(Request $request)
    {
        // ini_set('max_execution_time', 3600);
        set_time_limit(0);
        $from = $request->query('from');
        $to = $request->query('to');
        $region_id = $request->query('region_id');

        $filename = 'contracts_details_' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExport($from, $to, $region_id), $filename);
    }

    public function exportContractsCreated(Request $request)
    {
        // ini_set('max_execution_time', 3600);
        set_time_limit(0);
        $from = $request->query('from');
        $to = $request->query('to');
        $region_id = $request->query('region_id');

        $filename = 'contracts_details_by_updated_' . $from . '_to_' . $to . '.xlsx';

        return Excel::download(new ContractsExportCreated($from, $to, $region_id), $filename);
    }
}
