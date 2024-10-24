<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class ReviewController extends Controller
{
    public function listReview()
    {
        $listReview = Review::with('user', 'order','product')->paginate(5); // Lấy 10 bình luận mỗi trang
        return view('admin.review.index')->with(['listReview' => $listReview]);
    }
    
    public function deleteReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }

    public function changeStatus(Request $request)
    {
        // dd($request->id);
        $review = Review::findOrFail($request->id);
        // dd($product);
        $review->status = $request->status == 'true' ? 1 : 0;
        $review->save();

        return response(['message' => 'Cập nhật trạng thái thành công!']);
    }
}
