<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliance;

class ApplianceController extends Controller
{
    public function index()
    {
        $appliances = Appliance::all();

        return view('welcome', compact('appliances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site' => 'required',
            'location' => 'required',
            'type' => 'required',
            'serial_number' => 'required',
            'production_date' => 'required|date',
        ]);

        for($i = 0; $i < $request->multiplication; $i++){
            $appliance = Appliance::updateOrCreate(['id' => $request->id], [
                'site' => $request->site,
                'location' => $request->location,
                'type' => $request->type,
                'serial_number' => $request->serial_number,
                'production_date' => $request->production_date,
                'description' => $request->description,
            ]);
        }
        return response()->json(['code'=>200, 'message'=>'Appliance Created successfully','data' => $appliance], 200);
        
    }

    public function edit($id)
    {
        $appliance = Appliance::find($id);

        return response()->json($appliance);
    }

    public function destroy(Appliance $appliance)
    {
        $appliance->controls()->delete();
        $appliance->delete();

        return response()->json(['success' => 'Appliance Deleted successfully']);
    }
}
