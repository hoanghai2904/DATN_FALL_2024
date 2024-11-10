<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $postCate=PostCategory::all();
        return view('Client.main',compact('postCate'));
    }
}
