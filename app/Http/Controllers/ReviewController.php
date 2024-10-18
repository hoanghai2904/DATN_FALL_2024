<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use App\Models\Order_statuses;
use Illuminate\Http\Request;
use Flasher\Notyf\Prime\NotyfInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class ReviewController extends Controller
{
    public $review;
    public function __construct()
    {
        $this->review = new Review();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $query = Review::query();
        // $listReview = $this->review->getAll();
        $listReview = Review::with('User:id,full_name,email','Order_statuses:id,order_id,status','Product:id,name')
        ->orderBy('id', 'DESC')
        ->get();
        // dd($listSanPham);
        // $review = $query->paginate(8);
        //gọi đến view muốn hiển thị ra
        return view('admin.review.index', ['reviews' => $listReview]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //lấy ra danh mục
        //sử dụng query builder
        $users = DB::table('users')->get();
        $order_statuses = DB::table('order_statuses')->get();
        $products = DB::table('products')->get();
        //hiện thị view add
        return view('admin.review.add', ['users' => $users],['order_statuses' => $order_statuses],['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $dataInsert = [
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];
        // dd($dataInsert);

        $this->review->createReview($dataInsert);
        return redirect()->route('review.index')->with(['message' => 'Thêm Thành Công']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //form sửa sản phâm/lấy sản phẩm theo id
        $review = $this->review->find($id);
        $users = DB::table('users')->get();
        $order_statuses = DB::table('order_statuses')->get();
        $products = DB::table('products')->get();

        if (!$review) {
            return redirect()->route('review.index');
        }
        return view('admin.review.update', compact('review', 'users','order_statuses','products'));
        // dd($san_pham);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //sử lý logic update
        //lấy lại thông tin sản phẩm
        $review = $this->review->find($id);
        //xử lý và lưu ảnh neus có ảnh mới upload
        $dataUpdate = [
            'user_id' => $request->user_id,
            'order_status_id' => $request->order_status_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        $review->updateReview($dataReview, $id);
        return redirect()->route('review.index')->with(['message' => 'Sửa Thành Công']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //xử lý logic xóa sản phẩm
        //tìm sản phẩm
        $review = $this->review->find($id);
        //xóa sản phẩm trong db
        $review->delete();

        return redirect()->route('admin.review.index')->with(['message' => 'Xóa Thành Công']);
    }
}
