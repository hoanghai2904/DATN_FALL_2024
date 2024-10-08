<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
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
                ->paginate(7);
        } else {
            // Nếu không nhập gì, lấy toàn bộ người dùng và phân trang
            $listCustomer = User::paginate(7);
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
     public function listRole() // Thêm Request vào tham số nếu cần
     {
         $permissions = Permission::all(); // Lấy tất cả quyền
         $roles = Role::with('permissions')->paginate(7); // Lấy tất cả các vai trò cùng với permissions của chúng
         return view('admin.user.roleUser', compact('roles', 'permissions')); // Truyền cả roles và permissions đến view
     }
     

    public function store(Request $request)
{
    $request->validate([
        'role_name' => 'required|unique:roles,name|max:255',
        'permission_name' => 'nullable|unique:permissions,name|max:255',
        'permissions' => 'required|array', // Bắt buộc chọn quyền
    ], [
        'role_name.required' => 'Vui lòng nhập tên vai trò.',
        'role_name.unique' => 'Tên vai trò này đã được sử dụng.',
        'role_name.max' => 'Tên vai trò không được vượt quá 255 ký tự.',
        'permission_name.unique' => 'Tên quyền này đã được sử dụng.',
        'permission_name.max' => 'Tên quyền không được vượt quá 255 ký tự.',
        'permissions.required' => 'Vui lòng chọn ít nhất một quyền.', 
    ]);
    
    // Tạo vai trò mới
    $role = Role::create(['name' => $request->role_name]);

    // Nếu có quyền mới, tạo quyền mới
    if ($request->filled('permission_name')) {
        $permission = Permission::create(['name' => $request->permission_name]);
        // Gán quyền cho vai trò
        $role->permissions()->attach($permission->id);
    }

    // Gán các quyền đã chọn cho vai trò
    if ($request->has('permissions')) {
        $role->permissions()->attach($request->permissions);
    }
    return redirect()->route('admin.listRole')->with('success', 'Thêm vai trò và quyền thành công!');
}
}
