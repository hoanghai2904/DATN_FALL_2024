<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function listComment(Request $request)
    {
        // Lấy các tham số tìm kiếm từ yêu cầu
        $query = $request->input('query'); // Từ khóa tìm kiếm bình luận
        $userQuery = $request->input('user_query'); // Từ khóa tìm kiếm người dùng
        $status = $request->input('status'); // Trạng thái bình luận
        $date = $request->input('date'); // Ngày để tìm kiếm bình luận
    
        // Tìm kiếm và phân trang bình luận
        $listComment = Comment::with('user', 'product')
            // Tìm kiếm theo bình luận
            // ->when($query, function ($queryBuilder) use ($query) {
            //     return $queryBuilder->where('comment', 'like', "%{$query}%");
            // })
            // Tìm kiếm theo tên người dùng
            ->when($userQuery, function ($queryBuilder) use ($userQuery) {
                return $queryBuilder->whereHas('user', function ($userQueryBuilder) use ($userQuery) {
                    $userQueryBuilder->where('full_name', 'like', "%{$userQuery}%"); // Tìm kiếm theo tên người dùng
                });
            })
            // Kiểm tra nếu có trạng thái tìm kiếm
            ->when($status, function ($queryBuilder) use ($status) {
                return $queryBuilder->where('status', $status === 'active' ? 1 : 0); // Lọc theo trạng thái
            })
            // Kiểm tra nếu có ngày tìm kiếm
            ->when($date, function ($queryBuilder) use ($date) {
                return $queryBuilder->whereDate('created_at', $date); // Lọc theo ngày
            })
            // Phân trang với 5 bình luận mỗi trang
            ->paginate(5);
    
        // Trả về view với danh sách bình luận
        return view('admin.comments.list-comment', compact('listComment'));
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
