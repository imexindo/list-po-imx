<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('pages.master.region.index', compact('regions'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'dc_name' => 'required',
            // 'dc_group' => 'required',
        ]);
        
        $region = new Region();

        $letters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);
        $digits = substr(str_shuffle('0123456789'), 0, 2);
        $code = $letters . $digits;
        $existingRegion = Region::where('code', $code)->first();

        if ($existingRegion) {
            $code .= rand(0, 9);
            while (Region::where('code', $code)->exists()) {
                $code = $letters . $digits . rand(0, 9);
            }
        }
        $region->code = $code;    
        $region->dc_name = $request->dc_name;
        // $region->group_name = $request->dc_group;
        $region->save();

        return redirect()->route('region.index')->with('success', 'Region created successfully');
    }

    public function update(Request $request, $id)
    {
        $region = Region::find($id);
        $region->dc_name = $request->dc_name;
        // $region->group_name = $request->dc_group;
        $region->save();
        return redirect()->route('region.index')->with('success', 'Region updated successfully');
    }

    public function destroy($id)
    {
        $region = Region::find($id);
        $region->delete();
        return redirect()->route('region.index')->with('success', 'Region deleted successfully');
    }

}
