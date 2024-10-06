<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccountController extends Controller
{
    public function login()
   {
       return view('admin.Login.index');
   }

   public function Check_login(Request $request) 
   {
    $data = $request->validate([
        'email' => 'required|exists:users,email',
        'password' => 'required',
    ], [
        'email.required' => 'Vui lòng nhập email.',
        'email.exists' => 'Email không tồn tại trong hệ thống.',
        'password.required' => 'Vui lòng nhập mật khẩu.',
    ]);
   
    $user = User::where('email', $data['email'])->first();

    // Kiểm tra nếu tài khoản chưa xác nhận email
    if (is_null($user->email_verified_at)) {
        return back()->withErrors([
            'email' => 'Tài khoản của bạn chưa được xác nhận. Vui lòng kiểm tra email để xác nhận tài khoản.',
        ])->withInput();
    }
    // Kiểm tra thông tin đăng nhập
  
    if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
        // Đăng nhập thành công
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');

    }
    // Đăng nhập thất bại
    return back()->withErrors([
        'password' => 'Mật khẩu không chính xác.',
    ])->withInput();
   }

   // log out
 public function logout(Request $request)
 {
     Auth::logout();
     $request->session()->invalidate();
     $request->session()->regenerateToken();
     return redirect()->route('account.login')->with('success', 'Đăng xuất thành công!');
 }
}
