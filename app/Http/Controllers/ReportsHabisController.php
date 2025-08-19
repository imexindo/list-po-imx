<?php

namespace App\Http\Controllers;

use App\Exports\ContractsExportHabis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportsHabisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.reports.habis.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function exportContractsHabis(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $filename = 'laporan_habis_sewa_' . $from . '_to_' . $to . '.xlsx';
        return Excel::download(new ContractsExportHabis($from, $to), $filename);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
