<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    
    //list and search by phonn and email Customer---------------------------------------------------------
 public function listCusstomer(Request $request) // Thêm Request vào tham số
{
    // Lấy dữ liệu tìm kiếm từ form (email và số điện thoại)
    $searchQuery = $request->input('query');

    // Kiểm tra nếu có giá trị tìm kiếm
    if ($searchQuery) {
        // Tìm kiếm theo email hoặc số điện thoại, loại bỏ những người dùng có vai trò và phân trang
        $listCustomer = User::doesntHave('roles')
            ->where(function($query) use ($searchQuery) {
                $query->where('email', 'like', "%{$searchQuery}%")
                      ->orWhere('phone', 'like', "%{$searchQuery}%");
            })
            ->paginate(7);
    } else {
        // Nếu không nhập gì, lấy toàn bộ người dùng không có vai trò và phân trang
        $listCustomer = User::doesntHave('roles')->paginate(7);
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


    // user-----------------------------------------------------------------------------
    public function listUser(Request $request)
{
    // Lấy ID của người dùng đang đăng nhập
    $currentUserId = auth()->id();

    // Khởi tạo truy vấn cho User với các vai trò, chỉ lấy những user có vai trò
    $query = User::with('roles')->has('roles')->where('id', '!=', $currentUserId);

     // Tìm kiếm theo trạng thái và vai trò nếu có
     if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    if ($request->has('role_id') && $request->role_id != '') {
        $query->whereHas('roles', function ($q) use ($request) {
            $q->where('roles.id', $request->role_id);
        });
    }

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // Phân trang kết quả
    $employees = $query->paginate(7);
    $roles = Role::all();

    // Truyền employees đến view
    return view('admin.user.listUser', compact('employees', 'roles'));
}


    // add user and roles
    public function addUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|min:10|max:10|unique:users',
            'password' => 'required|string|min:5',
            'birthday' => 'nullable|date',
            'roles' => 'required|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'full_name.required' => 'Vui lòng nhập tên đầy đủ.',
            'full_name.min' => 'Tên đầy đủ phải có ít nhất 6 ký tự.',
            'full_name.max' => 'Tên đầy đủ không được vượt quá 100 ký tự.',
            'cover.image' => 'Hãy chọn một tệp hình ảnh hợp lệ.',
            'cover.mimes' => 'Hãy chọn tệp hình ảnh có định dạng jpeg, png, jpg, gif hoặc svg.',
            'cover.max' => 'Kích thước tệp hình ảnh không được vượt quá 2MB.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 5 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',

        ]);

        try {
            // Tạo người dùng mới
            $user = User::create([
                'full_name' => $request->full_name, // Sửa từ 'name' thành 'full_name'
                'email' => $request->email,
                'phone' => $request->phone,
                'birthday' => $request->birthday, // Sửa từ 'dob' thành 'birthday'
                'password' => Hash::make($request->password), // Sử dụng Hash::make
                'cover' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null, // Sửa từ 'avatar' thành 'cover'
            ]);

            // Gán vai trò cho người dùng
            $user->roles()->sync($request->roles);

            return response()->json(['success' => true, 'message' => 'User added successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User creation failed: ' . $e->getMessage()]); // Thêm chi tiết lỗi
        }
    }

    // show user
    public function showUser($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id); // Lấy người dùng cùng với vai trò
            return response()->json($user); // Trả về JSON
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found.'], 404); // Trả về lỗi 404 nếu người dùng không tồn tại
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500); // Trả về lỗi 500 cho các trường hợp khác
        }
    }
    //update user
    public function updateUser(Request $request, $id)
    {
        // Validation rules tương tự như addUser nhưng không bắt buộc email và phone phải là unique (trừ khi chúng thay đổi)
        $request->validate([
            'full_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id . ',id',
            'phone' => 'required|string|min:10|max:10|unique:users,phone,' . $id . ',id',
            'birthday' => 'nullable|date',
            'roles' => 'required|array',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'full_name.required' => 'Vui lòng nhập tên đầy đủ.',
            'full_name.max' => 'Tên đầy đủ không được vượt quá 50 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.unique' => 'Email này đã được sử dụng.',
            'cover.image' => 'Hãy chọn một tệp hình ảnh hợp lệ.',
            'cover.mimes' => 'Hãy chọn tệp hình ảnh có định dạng jpeg, png, jpg, hoặc gif.',
            'cover.max' => 'Kích thước tệp hình ảnh không được vượt quá 2MB.',
        ]);

        try {
            // Tìm user theo ID
            $user = User::findOrFail($id);

            // Cập nhật thông tin user
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->birthday = $request->birthday;

            // Nếu có hình đại diện mới, cập nhật cover
            if ($request->hasFile('cover')) { // Thay đổi từ 'avatar' thành 'cover'
                // Xóa avatar cũ nếu có
                if ($user->cover) {
                    Storage::disk('public')->delete($user->cover);
                }
                // Lưu ảnh mới
                $user->cover = $request->file('cover')->store('avatars', 'public'); // Đảm bảo sử dụng 'cover'
            }

            // Lưu user
            $user->save();

            // Cập nhật vai trò của user
            $user->roles()->sync($request->roles);

            return response()->json(['success' => true, 'message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'User update failed: ' . $e->getMessage()]);
        }
    }

    // delete user
    public function destroyUser($id)
    {
        $user = User::with('roles')->findOrFail($id); // Tải người dùng cùng với vai trò
        // Xóa vai trò của người dùng
        $user->roles()->detach(); // Xóa tất cả vai trò của người dùng
        // Xóa người dùng
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User and roles deleted successfully.']);
    }
     //update status
    //  public function updateStatusUser(Request $request, $id)
    //  {
    //      $customer = User::find($id);
 
    //      if ($customer) {
    //          // Chuyển trạng thái dựa trên giá trị checkbox
    //          $customer->status = $request->input('status') === 'active' ? 'active' : 'inactive';
    //          $customer->save();
    //          return response()->json(['success' => true, 'status' => $customer->status]);
    //      }
    //      return response()->json(['success' => false], 404);
    //  }
 

    //role-------------------------------------------------------------------------------
    public function listRole(Request $request) // Thêm Request vào tham số
    {
        // Khởi tạo truy vấn cho Role với permissions
        $query = Role::with('permissions')->has('permissions');

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
