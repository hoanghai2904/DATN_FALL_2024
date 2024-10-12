<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\PostRequest;
use App\Models\admin\Posts;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function index(Request $request){
        $query = Posts::query();
        $allCate = Category::all();
        $search = null;
        $search = $request->input('keywords');
          
        if ($search) {
            // Nếu có từ khóa tìm kiếm, thêm điều kiện join và where để lọc bình luận theo fullname trong bảng users
            $query->whereHas('user', function($q) use ($search){
            $q->where('full_name', 'like', '%'.$search.'%');
            });
        }
        $list= $query->orderBy('id','DESC')->paginate(5)->withQueryString();
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
        return redirect()->route('admin.posts.index');
    }
    public function destroy($id){
        $find=Posts::find($id);
        if (!$find) {
            return redirect()->route('admin.posts.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        $find->delete();
        return redirect()->route('admin.posts.index')->with('msg',"Xóa thành công");
    }
    public function edit($id)
    {
        $title = "Cập nhật giảm giá";
        $find=Posts::find($id);
        $allCate = Category::all();
        if (!$find) {
            return redirect()->route('admin.posts.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        return view('admin.posts.edit',compact('find','title','allCate'));
    }
    public function update(PostRequest $req,$id){
        $find = Posts::find($id);
        $data = [
            'title' => $req->title,
            'user_id' => $req->user_id,
            'status' => $req->status,
            'category_id' => $req->category_id,
            'body' => $req->body,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $find->update($data);
    
        return redirect()->route('admin.posts.index')->with('msg', "Sửa bài viết thành công");
    }
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
