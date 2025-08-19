<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionsController extends Controller
{
    public function index()
    {
        // $response = Http::get(env('SAP_API') . '/api/customers');
        // if ($response->successful()) {
        //     $data = $response->json();
        // } else {
        //     $data = [];
        // }
        // return view('pages.transactions.index', ['data' => $data]);

        return view('pages.transactions.index');

        
    }
}
