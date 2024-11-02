<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\Product;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featureProduct = Product::where('status', 1)
            ->where('product_type', 'Sale')
            ->latest()
            ->limit(10)
            ->get();

        return view('Client.main', compact('featureProduct'));
    }
}
