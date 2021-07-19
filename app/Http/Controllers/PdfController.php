<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appliance;
use PDF;

class PdfController extends Controller
{
    public function print()
    {
        $appliances = Appliance::all();

        $pdf = PDF::loadView('probafeladat', compact('appliances'));

        //return response()->download($pdf);
        return $pdf->download('probafeladat.pdf');
    }
}
