<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\VoucherRequest;
use App\Models\admin\Vouchers;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $query = Vouchers::query();
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
        $data = [
            'code' => $req->code,
            'name' => $req->name,
            'discount_type' => $req->discount_type,
            'status' => $req->status,
            'discount' => $req->discount,
            'qty' => $req->qty,
            'start' => $req->start,
            'end' => $req->end,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        Vouchers::create($data);
        return redirect()->route('admin.vouchers.index')->with('msg',"Thêm mã giảm giá thành công");
    }
    public function show($id){
        $find = Vouchers::find($id);
        if($find){
            if($find->status){
                $find->status = 0;
            }
            else{
                $find->status = 1;
            }
            $find->save();
        }
        return back();
    }
    public function destroy($id){
        $find=Vouchers::find($id);
        if (!$find) {
            return redirect()->route('admin.vouchers.index')->with('msg_warning', 'Giảm giá không tồn tại');
        }
        $find->delete();
        return redirect()->route('admin.vouchers.index')->with('msg',"Xóa thành công");
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
    public function update(VoucherRequest $req,$id){
        $find=Vouchers::find($id);
        $data = [
            'code' => $req->code,
            'name' => $req->name,
            'discount_type' => $req->discount_type,
            'status' => $req->status,
            'discount' => $req->discount,
            'qty' => $req->qty,
            'start' => $req->start,
            'end' => $req->end,
            'updated_at' => date('Y-m-d H:i:s'),
        ]; 
        $find->update($data);
        return redirect()->route('admin.vouchers.index')->with('msg', "Sửa mã giảm giá thành công");
    }
}
