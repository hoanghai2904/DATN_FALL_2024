<?php

namespace App\Http\Controllers;

use App\Models\UserAddress; // Nhập mô hình UserAddress
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Nhập Storage để lưu trữ hình ảnh
use Illuminate\Support\Facades\Auth; // Nhập Auth

class UserAddressController extends Controller
{
    // Phương thức để hiển thị danh sách địa chỉ
    public function index()
    {
        $userAddresses = UserAddress::all(); // Lấy tất cả địa chỉ người dùng
        return view('admin.user_addresses.index', compact('userAddresses'));
    }

    // Phương thức để hiển thị form thêm địa chỉ
    public function create()
    {
        return view('admin.user_addresses.create');
    }

    // Xử lý lưu địa chỉ mới
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'email' => 'required|email',
            'province_id' => 'required|integer',
            'district_id' => 'required|string',
            'ward_id' => 'required|string',
            'is_default' => 'boolean',
            'cover' => 'nullable|image|max:2048',
        ]);
    
 
        $address = new UserAddress();
       
        $address->full_name = $request->full_name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->email = $request->email;
        $address->province_id = $request->province_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->is_default = $request->is_default ? 1 : 0;
    
        if ($request->hasFile('cover')) {
            $address->cover = $request->file('cover')->store('covers', 'public');
        }
    
        $address->save();
    
        return redirect()->route('user_addresses.index')->with('success', 'Địa chỉ đã được thêm thành công.');
    }
    

    // Phương thức để hiển thị form chỉnh sửa địa chỉ
    public function edit($id)
    {
        $address = UserAddress::findOrFail($id);
        return view('admin.user_addresses.edit', compact('address'));
    }

    // Xử lý cập nhật địa chỉ
    public function update(Request $request, $id)
    {
        $address = UserAddress::findOrFail($id); // Lấy địa chỉ cần cập nhật
    
        // Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'email' => 'required|email',
            'province_id' => 'required|integer',
            'district_id' => 'required|string',
            'ward_id' => 'required|string',
            'is_default' => 'boolean',
        ]);
    
        // Cập nhật các trường dữ liệu
        $address->full_name = $request->full_name;
        $address->phone = $request->phone;
        $address->address = $request->address;
        $address->email = $request->email;
        $address->province_id = $request->province_id;
        $address->district_id = $request->district_id;
        $address->ward_id = $request->ward_id;
        $address->is_default = $request->has('is_default') ? 1 : 0;
    
        // Xử lý hình ảnh
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers');
            $address->cover = $path;
        }
    
        $address->save(); // Lưu thay đổi
    
        return redirect()->route('admin.user_addresses.index')->with('success', 'Cập nhật địa chỉ thành công.');
    }
    
    // Phương thức để xóa địa chỉ
    public function destroy($id)
    {
        $address = UserAddress::findOrFail($id);
        // Xóa ảnh nếu có
        if ($address->cover) {
            Storage::delete($address->cover);
        }
        $address->delete(); // Xóa địa chỉ
        return redirect()->route('user_addresses.index')->with('success', 'Địa chỉ đã được xóa thành công!');
    }
}
