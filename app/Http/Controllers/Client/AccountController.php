<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\VerifyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class AccountController extends Controller

{
   public function login()
   {
      return view('Client.Login');
   }

   public function check_login() {}

   public function rigester()
   {
      return view('Client.Rigester');
   }

   public function Check_rigester(Request $request) {
      // Xác thực dữ liệu đầu vào
      $data = $request->validate([
          'full_name' => 'required|min:6|max:100',
          'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
          'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,phone',
          'password' => 'required|min:8|max:255',
          'email' => 'required|email|unique:users,email',
          'gender' => 'nullable|in:1,2,3',
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
          'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
          'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
          'email.required' => 'Vui lòng nhập địa chỉ email.',
          'email.email' => 'Địa chỉ email không hợp lệ.',
          'email.unique' => 'Email này đã được sử dụng.',
          'gender.in' => 'Giới tính không hợp lệ.',
      ]);
  
      // Kiểm tra xem có file cover hay không
      if ($request->hasFile('cover')) {
          // Lưu hình ảnh vào thư mục 'images' và lấy đường dẫn
          $path_cover_art = $request->file('cover')->store('images');
          $data['cover'] = $path_cover_art; // Cập nhật đường dẫn hình ảnh vào dữ liệu
      }
  
      // Mã hóa mật khẩu từ dữ liệu đầu vào
      $data['password'] = bcrypt($request->input('password')); // Mã hóa mật khẩu
      $data['verification_token'] = Str::random(50); // Tạo mã token xác thực
  
      // Tạo tài khoản người dùng
      if ($acc = User::create($data)) {
          // Gửi email xác thực
          Mail::to($acc->email)->send(new VerifyAccount($acc));
          return redirect()->route('account.rigester')->with('success', 'Đăng ký thành công! Một email xác thực đã được gửi đến bạn.');
      }
  
      return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
  }

  public function verifyAccount($token) {
   // Tìm người dùng có mã token xác thực
   $user = User::where('verification_token', $token)->first();

   if (!$user) {
       // Nếu không tìm thấy người dùng với mã token, trả về thông báo lỗi
       return redirect()->route('account.rigester')->with('error', 'Mã xác thực không hợp lệ hoặc đã hết hạn.');
   }

   // Cập nhật trạng thái xác thực cho người dùng
   $user->email_verified_at = now(); // Thiết lập thời gian xác thực email
   $user->verification_token = null; // Xóa mã token để không thể sử dụng lại
   $user->save(); // Lưu thay đổi vào cơ sở dữ liệu

   // Trả về thông báo thành công
   return redirect()->route('account.login')->with('success', 'Tài khoản của bạn đã được xác thực thành công.');
}
  
  

   public function profile()
   {
      return view('Client.Login');
   }

   public function check_profile() {}

   public function change_pass()
   {
      return view('Client.Login');
   }

   public function Check_changePass() {}

   public function forgot_pass()
   {
      return view('Client.Login');
   }

   public function Check_forgotPass() {}

   public function reset_pass()
   {
      return view('Client.Login');
   }

   public function Check_resetPass() {}
}
