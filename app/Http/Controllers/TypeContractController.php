<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use App\Models\TypeContract;

class TypeContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeContracts = TypeContract::orderBy('created_at', 'desc')->get();
        return view('pages.master.type_contract.index', compact('typeContracts'));
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

        return redirect()->back()->with('error', 'Failed!');

        $request->validate([
            'type' => 'required|string|max:10',
            'price' => 'required|max:50',
        ]);

        $type = new TypeContract();
        $type->type = $request->type;
        $type->price = $request->price;
        $type->m_contract_id = $request->m_contract_id;
        $type->save();

        return redirect()->back()->with('success', 'Type Contract created successfully.');
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            // 'title' => 'required|string|max:50',
            // 'year' => 'required|integer|digits:4',
            // 'type' => 'required|string|max:10',
            'price' => 'required|numeric',
        ]);

        $typeContract = TypeContract::findOrFail($id);

        if (!$typeContract) {
            return redirect()->back()->with('error', 'Contract not found.');
        }

        $contract = $typeContract->contract;
        // $title = $request->title;
        // $titleWords = explode(' ', $title);

        // if (count($titleWords) == 1) {
        //     $titleCode = strtoupper(substr($titleWords[0], 0, 2));
        // } else {
        //     $titleCode = strtoupper(substr($titleWords[0], 0, 1)) . strtoupper(substr($titleWords[1], 0, 1));
        // }
        // $year = $request->year;
        // $yearCode = substr($year, -2);
        // $code = $titleCode . $yearCode;

        $cont = Contract::where('id', $request->m_contract_id)->first();

        if ($cont) {
            $existingTypeContract = TypeContract::where('type', $request->type)
                                                ->where('price', $request->price)
                                                ->first();
            if ($existingTypeContract) {
                return redirect()->back()->with('error', "$existingTypeContract->type' price '$existingTypeContract->price' already exists!.")->withInput();
            }
        }

        // if ($contract) {
        //     $contract->update([
        //         // 'code' => $code,
        //         // 'title' => $request->title,
        //         'year' => $request->year,
        //     ]);
        // }

        $typeContract->update([
            // 'type' => $request->type,
            'price' => $request->price,
        ]);

        
        return redirect()->back()->with('success', 'Type Contract updated successfully.');
    }


    public function destroy($id)
    {
        $typeContract = TypeContract::findOrFail($id);

        if (!$typeContract) {
            return redirect()->back()->with('error', 'Not found!.');
        }
        $typeContract->delete();
        return redirect()->back()->with('success', 'Type Contract deleted successfully.');
    }
}
