<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\VoucherRequest;
use App\Models\admin\Vouchers;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $list = Vouchers::all();
        return view('admin.vouchers.index', compact('list'));
    }
    public function create()
    {
        return view('admin.vouchers.create');
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
            'description' => $req->description,
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
        $find->delete();
        return redirect()->route('admin.vouchers.index')->with('msg',"Xóa thành công");
    }
}
