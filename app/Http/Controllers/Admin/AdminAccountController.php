<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
       
       // Kiểm tra thông tin đăng nhập
       if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
           // Kiểm tra xem người dùng có ít nhất một vai trò hay không
           if ($user->roles->isEmpty()) {
               Auth::logout(); // Đăng xuất nếu không có vai trò
               return back()->withErrors([
                   'email' => 'Bạn không có quyền truy cập vào trang quản trị.',
               ])->withInput();
           }
           
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
     return redirect()->route('admin.login')->with('success', 'Đăng xuất thành công!');
 }


 public function profile()
 {
    $auth  = auth()->user();
     return view('admin.Login.profile',compact('auth'));
 }

 public function check_profile(Request $request) 
 {
     $auth = auth()->user();
 
     // Validate dữ liệu từ yêu cầu
     $data = $request->validate([
         'full_name' => 'required|min:6|max:100',
         'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
         'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,phone,' . $auth->id,
         'email' => 'required|email|unique:users,email,' . $auth->id,
         'birthday' => 'nullable|date',
         'gender' => 'nullable',
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
         'email.required' => 'Vui lòng nhập địa chỉ email.',
         'email.email' => 'Địa chỉ email không hợp lệ.',
         'email.unique' => 'Email này đã được sử dụng.',
     ]);
     // Map giới tính từ chuỗi sang số
     $genderMap = [
         'Nam' => 1,
         'Nữ' => 2,
         'Khác' => 3
     ];
     $data['gender'] = isset($genderMap[$request->input('gender')]) ? $genderMap[$request->input('gender')] : null;
     // Cập nhật thông tin người dùng
     $auth->update($data);
     // Chuyển hướng về trang tài khoản với thông báo thành công
     return redirect()->route('admin.profile')->with('success', 'Cập nhật thông tin thành công!');
 }

 
 //còn chức năng forgot password

 // còn chức năng phân quyền

 //còn chức năng tạo tài khoản nhân viên (super admin tạo và phân quyền)

}
