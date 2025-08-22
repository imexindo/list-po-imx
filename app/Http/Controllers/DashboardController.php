<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PO;

class DashboardController extends Controller
{

    public function index()
    {
        return view('pages.dashboard');
    }

    public function getPoByCategory()
    {
        $getData = PO::with('category_by_menu')
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->get();

        $labels = $getData->map(fn($row) => $row->category_by_menu?->name ?? 'Unknown');
        $series = $getData->map(fn($row) => $row->total);

        return response()->json([
            'labels' => $labels,
            'series' => $series,
        ]);
    }

    public function getPoBySpk()
    {
        $getData = PO::selectRaw("
            MONTH(created_at) as bulan,
            l_spk,
            COUNT(*) as total
        ")
            ->groupBy('bulan', 'l_spk')
            ->orderBy('bulan')
            ->get();

        $months = range(1, 12);
        $status = [
            0 => 'Blank',
            1 => 'Accepted',
            2 => 'Canceled'
        ];

        $result = [];
        foreach ($status as $key => $label) {
            foreach ($months as $m) {
                $result[$label][$m] = 0;
            }
        }

        foreach ($getData as $row) {
            $label = $status[$row->l_spk] ?? 'Unknown';
            $result[$label][$row->bulan] = $row->total;
        }

        $series = [];
        foreach ($status as $label) {
            $series[] = [
                'name' => $label,
                'data' => array_values($result[$label])
            ];
        }

        return response()->json([
            'series' => $series,
            'labels' => array_map(function ($m) {
                return date("M", mktime(0, 0, 0, $m, 1));
            }, $months)
        ]);
    }

    
}
