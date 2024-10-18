<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\PostRequest;
use App\Models\admin\Posts;
use App\Models\Category;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;
use Flasher\Laravel\Facade\Flasher;
use CodeWithDennis\FilamentSelectTree\SelectTree;


class PostController extends Controller
{
    //
    public function index(Request $request){
        $query = Posts::query();
        $allCate = Category::all();
        $search = null;
        $search = $request->input('keywords');
        if ($request->has('status') && is_numeric($request->status)) {
            $status = (int) $request->status; // Convert to integer
            $query->where('status', '=', $status);
            if ($query->count() == 0) {
                return redirect()->back()->with('msg', 'Không tìm thấy mã giảm giá với trạng thái này.');
            }
        } else {
            $query->where('status', '!=', 0); 
            if (!$request->has('status')) {
            }
        } 
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
    public function store(Request $req){
        $vali= $req->validate([
            'title' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'body' => 'required',
        ],[
            'title.required'=>'Tiêu đề không được bỏ trống',
            'user_id.required'=>'Tác giả không được bỏ trống',
            'status.required'=>'Trạng thái không được bỏ trống',
            'category_id.required'=>'Danh mục không được bỏ trống',
            'body.required'=>'Nội dung không được bỏ trống',
        ]);
        $data = [
            'title' => $vali['title'],
            'user_id' => $vali['user_id'],
            'status' =>  $vali['status'],
            'category_id' => $vali['category_id'],
            'body' => $vali['body'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        Posts::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'Thêm mới bài viết thành công.');
    }
    public function destroy($id){
        $find = Posts::findOrFail($id);
        $find->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }
    public function edit($id)
    {
        $title = "Cập nhật bài viết";
        $find=Posts::find($id);
        $allCate = Category::all();
        if (!$find) {
            return redirect()->route('admin.posts.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        return view('admin.posts.edit',compact('find','title','allCate'));
    }
    public function update(Request $req,$id){
        $find = Posts::find($id);
        $vali= $req->validate([
            'title' => 'required',
            'user_id' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'body' => 'required',
        ],[
            'title.required'=>'Tiêu đề không được bỏ trống',
            'user_id.required'=>'Tác giả không được bỏ trống',
            'status.required'=>'Trạng thái không được bỏ trống',
            'category_id.required'=>'Danh mục không được bỏ trống',
            'body.required'=>'Nội dung không được bỏ trống',
        ]);
        $data = [
            'title' => $vali['title'],
            'user_id' => $vali['user_id'],
            'status' =>  $vali['status'],
            'category_id' => $vali['category_id'],
            'body' => $vali['body'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $find->update($data);
    
        return redirect()->route('admin.posts.index')->with('success', "Sửa bài viết thành công");
    }
    public function updateStatus(Request $request)
    {
        $find = Posts::find($request->id);
    
        $find->status = $request->status == 'true' ? 2:1;
        $find->save();
    
        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
    public function show($id){
        $find = Posts::find($id);
        return view('admin.posts.show',compact('find'));

    }
}
