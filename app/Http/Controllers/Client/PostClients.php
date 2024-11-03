<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\Posts;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostClients extends Controller
{
    public function index(){
        $query = Posts::query();
        $allCate = PostCategory::all();
        $list= $query->orderBy('id','DESC')->paginate(5)->withQueryString();
        return view('Client.blog',compact('list','allCate'));

    }
    
}
