<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasangBaruController extends Controller
{
    public function index()
    {

        return view('pages.pasang_baru.index');
    }


    public function getSpk()
    {

        $response = Http::get(env('SAP_API') . '/api/spks');
        $data = $response->successful() ? $response->json() : [];

        return response()->json($data);
    }
}
