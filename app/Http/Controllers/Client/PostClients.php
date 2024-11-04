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
        $list= $query->orderBy('id','DESC')->paginate(2)->withQueryString();
        return view('Client.blog',compact('list','allCate'));

    }
    public function show($id){
    $post = Posts::findOrFail($id);
    $allCate = PostCategory::orderBy("id", "desc")->get();
    return view('Client.blogDetail',compact('post','allCate'));
    }
    public function ByCategory($id){
    $category = PostCategory::find($id);
    $allCate = PostCategory::all();
    if (!$category) {
        return redirect()->route('blog.index');
    }
    $list = $category->posts()->orderBy('id', 'DESC')->paginate(6)->withQueryString();
    return view('Client.blog', compact('list','allCate'));
    }
}
