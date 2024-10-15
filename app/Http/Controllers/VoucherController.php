<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\VoucherRequest;
use App\Models\admin\Vouchers;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Vouchers::query();
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
            $query->where('name', 'like', '%'.$search.'%');
        }
        $list= $query->orderBy('id','DESC')->paginate(5)->withQueryString();
        return view('admin.vouchers.index', compact('list'));
    }
    public function create()
    {
        $title = "Tạo mới mã giảm giá";
        return view('admin.vouchers.create', compact('title'));
    }
    public function store(VoucherRequest $req)
    {
        $discount = (int) str_replace('.', '', $req->discount);
        $qty = (int) str_replace('.', '', $req->qty);
        $data = [
            'code' => $req->code,
            'name' => $req->name,
            'discount_type' => $req->discount_type,
            'status' => $req->status,
            'discount' => $discount,
            'qty' => $qty,
            'start' => $req->start,
            'end' => $req->end,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        Vouchers::create($data);
        return redirect()->route('admin.vouchers.index')->with('success', 'Thêm mới mã giảm giá thành công.');
    }
    // public function show($id){
    //     $find = Vouchers::find($id);
    //     if($find){
    //         if($find->status){
    //             $find->status = 0;
    //         }
    //         else{
    //             $find->status = 1;
    //         }
    //         $find->save();
    //     }
    //     return back();
    // }
    public function destroy($id){
        $find=Vouchers::find($id);
        if (!$find) {
            return redirect()->route('admin.vouchers.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        $find->delete();
        return response(['status' => 'success', 'Xóa thành công!']);
    }
    public function edit($id)
    {
        $title = "Cập nhật giảm giá";
        $find=Vouchers::find($id);
        if (!$find) {
            return redirect()->route('admin.vouchers.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        return view('admin.vouchers.edit',compact('find','title'));
    }
    public function update(VoucherRequest $req, $id) {
        $find = Vouchers::find($id);
        
        // Chuyển đổi giá trị discount và qty thành số nguyên bằng cách loại bỏ dấu chấm
        $discount = (int) str_replace('.', '', $req->discount);
        $qty = (int) str_replace('.', '', $req->qty);
    
        $data = [
            'code' => $req->code,
            'name' => $req->name,
            'discount_type' => $req->discount_type,
            'status' => $req->status,
            'discount' => $discount, // Sử dụng giá trị đã được xử lý
            'qty' => $qty, // Sử dụng giá trị đã được xử lý
            'start' => $req->start,
            'end' => $req->end,
            'updated_at' => now(), // Thay vì sử dụng date('Y-m-d H:i:s'), dùng now() cho dễ đọc hơn
        ];
    
        $find->update($data);
    
        return redirect()->route('admin.vouchers.index')->with('msg', "Sửa mã giảm giá thành công");
    }
    
    public function updateStatus(Request $request)
{
    $voucher = Vouchers::find($request->id);
    
    $voucher->status = $request->status == 'true' ? 2:1;
    $voucher->save();

    return response(['message' => 'Cập nhật trạng thái thành công!']);
        
}

}
