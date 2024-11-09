<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\Posts;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class PostClients extends Controller
{
    public function index(Request $request)
    {
        $query = Posts::where('status', 2); // Thêm điều kiện where để lọc bài viết có status = 2
        $allCate = PostCategory::all();
        $search = null;
        $search = $request->input('keywords');
        if ($search) {
            $query->where('title', 'like', '%'.$search.'%');
        }
        $list = $query->orderBy('id', 'DESC')->paginate(4)->withQueryString();
        return view('Client.blog', compact('list', 'allCate'));
    }

    public function show(Request $request, $id)
    {
        $query = Posts::where('status', 2);
        $search = $request->input('keywords');
    
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
    
        $post = $query->find($id);
    
        $allCate = PostCategory::orderBy("id", "desc")->get();
    
        if (!$post) {
            return redirect()->route('blog.index');
        }
    
        return view('Client.blogDetail', compact('post', 'allCate'));
    }
    
    public function ByCategory(Request $request, $id)
    {
        $category = PostCategory::find($id);
        $allCate = PostCategory::all();
    
        if (!$category) {
            return redirect()->route('blog.index');
        }
        $search = $request->input('keywords');
        $query = $category->posts()->where('status', 2);
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        $list = $query->orderBy('id', 'DESC')->paginate(6)->withQueryString();
    
        return view('Client.blog', compact('list', 'allCate'));
    }
    
}
