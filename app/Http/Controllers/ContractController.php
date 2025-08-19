<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\TypeContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::orderBy('created_at', 'desc')->get();

        return view('pages.master.contract.index', compact('contracts'));
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
            'title' => 'required|string|max:100',
            'year' => 'required|integer',
            'type' => 'required|array',
            'type.*' => 'required|string',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Extract the title
        $title = $request->input('title');
        $titleWords = explode(' ', $title);

        if (count($titleWords) == 1) {
            $titleCode = strtoupper(substr($titleWords[0], 0, 2));
        } else {
            $titleCode = strtoupper(substr($titleWords[0], 0, 1)) . strtoupper(substr($titleWords[1], 0, 1));
        }
        $year = $request->input('year');
        $yearCode = substr($year, -2);
        $code = $titleCode . $yearCode;

         // Check if a Contract with the same title already exists
        // $existingContract = Contract::where('code', $code)->first();
        // if ($existingContract) {
        //     foreach ($request->type as $key => $type) {
        //         $price = $request->price[$key];
        //         $existingTypeContract = TypeContract::where('type', $type)
        //             ->where('price', $price)
        //             ->first();
        //         if ($existingTypeContract) {
        //             return redirect()->back()->with('error', " $code, $type, price '$price' already exists!");
        //         }
        //     }
        // }
        $existingContract = Contract::where('code', $code)->first();

        if ($existingContract) {
            foreach ($request->type as $key => $type) {
                TypeContract::create([
                    'type' => $type,
                    'price' => $request->price[$key],
                    'm_contract_id' => $existingContract->id
                ]);
            }
        } else {
            $contract = new Contract();

            $contract->title = $request->title;
            $contract->code = $code; 
            $contract->year = $request->year;

            $contract->save();

            $getData = Contract::where('title', $request->title)->first();

            if ($getData->title == 'DALAM KOTA') {
                $contract->group_id = 1;
            } elseif($getData->title == 'JAWA') {
                $contract->group_id = 2;
            } else {
                $contract->group_id = 3;
            }

            $contract->save();

            foreach ($request->type as $key => $type) {
                TypeContract::create([
                    'type' => $type,
                    'price' => $request->price[$key],
                    'm_contract_id' => $contract->id
                ]);
            }

            foreach ($request->type as $key => $type) {
                TypeContract::create([
                    'type' => $type,
                    'price' => $request->price[$key],
                    'm_contract_id' => $contract->id
                ]);
            }
        }

       

        // Create type contracts
       

        return redirect()->back()->with('success', 'Contract created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contract = Contract::with('typeContracts')->findOrFail($id);

        if (!$contract) {
            return redirect()->back()->with('error', 'Not found!.');
        }

        return response()->json($contract->typeContracts);
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
        // Validasi input

        $request->validate([
            'title' => 'required|string|max:100',
        ]);

        $contract = Contract::findOrFail($id);

        if (!$contract) {
            return redirect()->back()->with('error', 'Not found!.');
        }

        $contract->update($request->only('title'));

        return redirect()->back()->with('success', 'Contract updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contract = Contract::findOrFail($id);

        if (!$contract) {
            return redirect()->back()->with('error', 'Not found!.');
        }
        
        TypeContract::where('m_contract_id', $contract->id)->delete();
        $contract->delete();

        return redirect()->back()->with('success', 'Contract deleted successfully');
    }
}
