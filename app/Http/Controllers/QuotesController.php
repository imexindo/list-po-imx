<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quotes::all();
        return view('pages.quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'messages' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $quotes = new Quotes();
        $quotes->user_id = Auth::user()->id;
        $quotes->messages = $request->messages;
        $quotes->save();

        return redirect()->back()->with('success', 'Successfully');
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
        $request->validate([
            'messages' => 'required|string',
        ]);
    
        $quote = Quotes::findOrFail($id);
        $quote->messages = $request->input('messages');
        $quote->save();
    
        return redirect()->back()->with('success', 'Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quote = Quotes::findOrFail($id);
        $quote->delete();

        return redirect()->back()->with('success', 'Successfully!');
    }
}
