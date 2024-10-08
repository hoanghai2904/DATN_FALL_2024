<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //list and search by phonn and email
    public function listCusstomer(Request $request) // Thêm Request vào tham số
    {
        // Lấy dữ liệu tìm kiếm từ form (email và số điện thoại)
        $searchQuery = $request->input('query');
    
        // Kiểm tra nếu có giá trị tìm kiếm
        if ($searchQuery) {
            // Tìm kiếm theo email hoặc số điện thoại và phân trang (mỗi trang có 10 người dùng)
            $listCustomer = User::where('email', 'like', "%{$searchQuery}%")
                ->orWhere('phone', 'like', "%{$searchQuery}%")
                ->paginate(1);
        } else {
            // Nếu không nhập gì, lấy toàn bộ người dùng và phân trang
            $listCustomer = User::paginate(1);
        }
    
        return view('admin.user.listCusstomer', compact('listCustomer'));
    }
    
    
    //delete
    public function deleteCustomer($id)
    {
        $customer = User::find($id);
        if ($customer) {
            $customer->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    //update status
    public function updateStatus(Request $request, $id)
    {
        $customer = User::find($id);
    
        if ($customer) {
            // Chuyển trạng thái dựa trên giá trị checkbox
            $customer->status = $request->input('status') === 'active' ? 'active' : 'inactive';
            $customer->save();
    
            return response()->json(['success' => true, 'status' => $customer->status]);
        }
    
        return response()->json(['success' => false], 404);
    }


    // user


    
     public function listUser() // Thêm Request vào tham số
    {
    
        return view('admin.user.listUser');
    }
    
     //role
    public function listRole() // Thêm Request vào tham số
    {
        return view('admin.user.roleUser');
    }



}
