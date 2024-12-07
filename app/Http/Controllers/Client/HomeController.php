<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
<<<<<<< HEAD
        return view('Client.main');
=======
        $products = Product::all();
        return view('Client.main',compact('products'));
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
    }
}

