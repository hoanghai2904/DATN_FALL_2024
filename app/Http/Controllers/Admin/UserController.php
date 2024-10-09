<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
     public function listRole(Request $request) // Thêm Request vào tham số
     {
         // Khởi tạo truy vấn cho Role với permissions
         $query = Role::with('permissions');
     
         // Tìm kiếm theo vai trò
         if ($request->has('query') && $request->input('query') !== '') {
             $query->where('name', 'like', '%' . $request->input('query') . '%');
         }
     
         // Tìm kiếm theo trạng thái
         if ($request->has('status') && $request->input('status') !== '') {
             $query->where('status', $request->input('status'));
         }
     
         // Phân trang kết quả
         $roles = $query->paginate(7);
     
         // Lấy tất cả quyền
         $permissions = Permission::all();
     
         // Truyền cả roles và permissions đến view
         return view('admin.user.roleUser', compact('roles', 'permissions'));
     }
     
     
// tạo mới role
public function store(Request $request)
{
    // Validate các trường đầu vào
    $request->validate([
        'role_name' => [
            'required',
            'max:50',
            Rule::unique('roles', 'name')->whereNull('deleted_at'),
        ],
        'permission_name' => 'nullable|unique:permissions,name|max:50',
        'permissions' => 'required|array',
    ], [
        'role_name.required' => 'Vui lòng nhập tên vai trò.',
        'role_name.unique' => 'Tên vai trò này đã được sử dụng.',
        'role_name.max' => 'Tên vai trò không được vượt quá 50 ký tự.',
        'permission_name.unique' => 'Tên quyền này đã được sử dụng.',
        'permission_name.max' => 'Tên quyền không được vượt quá 50 ký tự.',
        'permissions.required' => 'Vui lòng chọn ít nhất một quyền.',
    ]);

    // Kiểm tra xem vai trò đã bị xóa mềm có tồn tại không
    $existingRole = Role::withTrashed()->where('name', $request->role_name)->first();

    if ($existingRole) {
        // Khôi phục vai trò đã xóa mềm
        $existingRole->restore();
        // Cập nhật các quyền cho vai trò đã khôi phục
        $existingRole->permissions()->sync($request->permissions);
    } else {
        // Tạo vai trò mới
        $role = Role::create(['name' => $request->role_name]);

        // Tạo mới quyền (nếu có)
        if ($request->permission_name) {
            $permission = Permission::create(['name' => $request->permission_name]);
            $role->permissions()->attach($permission->id);
        }

        // Gán các quyền đã chọn vào vai trò
        $role->permissions()->attach($request->permissions);
    }

    return redirect()->route('admin.listRole')->with('success', 'Thêm vai trò và quyền thành công!');
}
// xóa role
public function deleteRole($id)
{
    $role = Role::findOrFail($id); // Tìm vai trò theo ID, nếu không có sẽ trả về lỗi
    if ($role) {
    $role->permissions()->detach();
    $role->delete();
    // Trả về phản hồi thành công
    return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}

// update status role
public function updateStatusRole(Request $request, $id)
{
    $role = Role::find($id);

    if ($role) {
        // Chuyển trạng thái dựa trên giá trị checkbox
        $role->status = $request->input('status') === 'active' ? 'active' : 'inactive';
        $role->save();
        return response()->json(['success' => true, 'status' => $role->status]);
    }
    return response()->json(['success' => false], 404);
}

// edit
public function edit($id)
{
    $role = Role::with('permissions')->findOrFail($id); // Lấy vai trò theo ID
    $allPermissions = Permission::all(); // Lấy tất cả quyền

    return response()->json([
        'role' => $role,
        'all_permissions' => $allPermissions,
        'permissions' => $role->permissions->pluck('id')->toArray() // Chỉ lấy ID của các quyền
    ]);
}

// update
public function update(Request $request, $id)
{
    $request->validate([
        'permissions' => 'required|array', // Bắt buộc phải chọn quyền
    ]);

    $role = Role::findOrFail($id);
    // Gán quyền mới cho vai trò
    $role->permissions()->sync($request->permissions); // Cập nhật quyền

    return response()->json(['message' => 'Cập nhật quyền thành công!']);
}





}
