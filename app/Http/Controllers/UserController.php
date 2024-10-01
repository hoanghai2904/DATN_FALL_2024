<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Hiển thị form tạo người dùng
    public function create()
    {
        return view('users.create');
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            // Thêm các validation khác nếu cần
        ]);

        User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Mã hóa mật khẩu
            // Thêm các trường khác nếu cần
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Cập nhật người dùng
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Thêm các validation khác nếu cần
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            // Nếu bạn muốn thay đổi mật khẩu
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            // Thêm các trường khác nếu cần
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Xóa người dùng
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
