<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Menu;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {

        $category = Menu::get();
        return view('pages.laporan.index', compact('category'));
    }

    public function export(Request $request)
    {
        $category = $request->category;
        return Excel::download(new LaporanExport($category), 'laporan_list_po.xlsx');
    }
}
