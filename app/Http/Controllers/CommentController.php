<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function listComment()
    {
        $listComment = Comment::with('user', 'product')->paginate(5); // Lấy 10 bình luận mỗi trang
        return view('admin.comments.list-comment')->with(['listComment' => $listComment]);
    }
    
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $comment = Comment::findOrFail($request->id);
        // dd($product);
        $comment->status = $request->status == 'true' ? 1 : 0;
        $comment->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
    
}
