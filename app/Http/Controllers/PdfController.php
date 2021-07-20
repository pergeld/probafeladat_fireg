<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliance;
use PDF;

class PdfController extends Controller
{
    public function create()
    {    
        $appliances = Appliance::all();

        $pdf = PDF::loadView('probafeladat', compact('appliances'));
        $filename = base_path('probafeladat.pdf');
        $pdf->save($filename);

        return \Response::download($filename);
    }
}
