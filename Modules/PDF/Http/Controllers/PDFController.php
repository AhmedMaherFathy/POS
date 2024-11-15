<?php

namespace Modules\PDF\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Modules\Product\Models\Product;
use App\Http\Controllers\Controller;

class PDFController extends Controller
{
    
    public function index()
    {
        $products = Product::all();
        $pdf = Pdf::loadView('pdf', ['data'=> $products]);
        $encoded = base64_encode($pdf->output());
        return response()->json([
            'pdf' => $encoded,
            'message' => "Done",
        ]);
        // return $pdf->stream();
    }

}
