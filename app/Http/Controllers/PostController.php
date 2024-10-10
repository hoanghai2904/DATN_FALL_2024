<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\PostRequest;
use App\Models\admin\Posts;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index(){
        $list = Posts::all();
        $allCate = Category::all();
        return view('admin.posts.index', compact('list','allCate'));
    }
    public function create(){
        $title = "Tạo mới bài viết";
        $allCate = Category::all();
        return view('admin.posts.create',compact('title','allCate'));
    }
    public function store(PostRequest $req){
        $data = [
            'title' => $req->title,
            'user_id' => $req->user_id,
            'status' => $req->status,
            'category_id' => $req->category_id,
            'body' => $req->body,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        Posts::create($data);
        return redirect()->route('admin.posts.index')->with('msg',"Thêm mã giảm giá thành công");
    }
    public function destroy(){}
    public function update(){}
    public function updateStatus(Request $request)
    {
        $voucher = Posts::find($request->id);
        
        if ($voucher) {
            $voucher->status = $request->status;
            $voucher->save();
            
            return response()->json(null,204 );
        }
    
        return response()->json(['message' => 'Không tìm thấy post.'], 404);
    }
}
