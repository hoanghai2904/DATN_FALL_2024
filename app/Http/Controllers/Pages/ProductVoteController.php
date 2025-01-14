<?php

namespace App\Http\Controllers\Pages;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Models\OrderDetail;
use App\Models\ProductVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductVoteController extends Controller
{
  public function index($id)
  {
    if (Auth::check() && Auth::user()->Role == 0) {
      // Lấy danh sách quảng cáo
      $advertises = Advertise::where([
        ['start_date', '<=', date('Y-m-d')],
        ['end_date', '>=', date('Y-m-d')],
        ['at_home_page', '=', false]
      ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

      $productVotes = OrderDetail::withTrashed()->whereHas('order', function ($query) use ($id) {
        $query->withTrashed()->where('user_id', $id) // Điều kiện user_id từ bảng orders
        ->where('status', OrderStatusEnum::COMPLETED);
      })->with(['order' => function($q) {
          $q->withTrashed();
      }, 'variants' => function($q) {
          $q->withTrashed();
      }, 'variants.product' => function($q) {
          $q->withTrashed(); 
      }, 'product_votes' => function($q) {
          $q->withTrashed();
      }, 'product_votes.user' => function($q) {
          $q->withTrashed();
      }])
        ->orderBy('created_at', 'DESC')
        ->paginate(10);

      // dd($productVotes);

      // Kiểm tra xem người dùng có đơn hàng không
      if ($productVotes->isNotEmpty()) {
        return view('pages.votes')->with('data', ['productVotes' => $productVotes, 'advertises' => $advertises]);
      } else {
        return redirect()->route('home_page')->with([
          'alert' => [
            'type' => 'info',
            'title' => 'Thông Báo',
            'content' => 'Vui lòng mua hàng để thực hiện chức năng này!'
          ]
        ]);
      }
    } else if (Auth::check()) {
      return redirect()->route('admin.dashboard')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn không có quyền truy cập vào trang này!'
        ]
      ]);
    } else {
      return redirect()->route('login')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Cảnh Báo',
          'content' => 'Bạn phải đăng nhập để sử dụng chức năng này!'
        ]
      ]);
    }
    // Lấy danh sách OrderDetail của tài khoản

  }

  public function store(Request $request)
  {
      // Kiểm tra các điều kiện cần thiết trước khi lưu
      if (!$request->order_detail_id || !$request->rate || !$request->content) {
          return response()->json(['status' => false, 'message' => 'Vui lòng điền đầy đủ thông tin đánh giá.']);
      }
  
      // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
      $existingVote = ProductVote::where('order_detail_id', $request->order_detail_id)
                                 ->where('user_id', auth()->id())
                                 ->first();
  
      if ($existingVote) {
          return response()->json(['status' => false, 'message' => 'Bạn đã đánh giá sản phẩm này rồi.']);
      }
  
      try {
          // Lưu đánh giá mới
          $productVote = ProductVote::create([
              'order_detail_id' => $request->order_detail_id,
              'rate' => $request->rate,
              'content' => $request->content,
              'user_id' => auth()->id(),
              'status' => 1,
          ]);
  
          // Nếu lưu thành công, trả về phản hồi thành công
          return response()->json([
              'status' => true,
              'message' => 'Đánh giá sản phẩm thành công.'
          ]);
      } catch (\Exception $e) {
          // Nếu có lỗi xảy ra trong quá trình lưu, trả về lỗi
          return response()->json([
              'status' => false,
              'message' => 'Đã xảy ra lỗi khi lưu đánh giá: ' . $e->getMessage()
          ]);
      }
  }
  
}
