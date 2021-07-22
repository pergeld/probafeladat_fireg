<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;

class ControlController extends Controller
{
    public function show($id)
    {
        $controls = Control::where('appliance_id', $id)->get();

        return view('control', compact('controls', 'id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'maintenance' => 'required',
            'date' => 'required|date'
        ]);


        $control = Control::updateOrCreate(['id' => $request->id], [
            'maintenance' => $request->maintenance,
            'date' => $request->date,
            'appliance_id' => $request->appliance_id,
            'description' => $request->description
        ]);

        return response()->json(['code'=>200, 'message'=>'Control Created successfully','data' => $control], 200);

    }

    public function storecontrol(Request $request)
    {
        $request->validate([
            'maintenance' => 'required',
            'date' => 'required|date'
        ]);

        return redirect('/');
    }

    public function edit($id)
    {
        $control = Control::find($id);

        return response()->json($control);
    }

    public function destroy(Control $control)
    {
        $control->delete();

        return response()->json(['success' => 'Control Deleted successfully']);
    }
}
