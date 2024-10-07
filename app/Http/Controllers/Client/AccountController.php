<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\VerifyAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class AccountController extends Controller

{
   public function login()
   {
      return view('Client.Login');
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
     $remember = $request->has('remember'); // Kiểm tra nếu checkbox "Remember me" được chọn

     if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']], $remember)) {
         // Đăng nhập thành công
         $request->session()->regenerate();
         return redirect()->route('home.index')->with('success', 'Đăng nhập thành công!');

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
          'password' => 'required|min:4|max:20',
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
          'password.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
          'password.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
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
    $auth = auth()->user();
      return view('Client.myAccount',compact('auth'));
   }

   public function check_profile(Request $request) 
{
    $auth = auth()->user(); 
    $data = $request->validate([
        'full_name' => 'required|min:6|max:100',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10|unique:users,phone,' . $auth->id,
        'email' => 'required|email|unique:users,email,' . $auth->id,
        'birthday' => 'nullable|date',
        'password' => 'required',
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
        'password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
    ]);

    // Kiểm tra mật khẩu hiện tại
    if (!Hash::check($request->password, $auth->password)) {
        return back()->withErrors(['password' => 'Mật khẩu của bạn không chính xác']);
    }

    // Kiểm tra xem có file cover hay không
    if ($request->hasFile('cover')) {
        // Xóa ảnh cũ nếu có
        if ($auth->cover) {
            Storage::delete($auth->cover);
        }
        // Lưu hình ảnh mới vào thư mục 'images' và lấy đường dẫn
        $path_cover_art = $request->file('cover')->store('images');
        $data['cover'] = $path_cover_art;
    }

    // Xóa trường password khỏi dữ liệu
    unset($data['password']);

    // Cập nhật thông tin người dùng
    $auth->update($data);

    // Chuyển hướng về trang tài khoản với thông báo thành công
    return redirect()->route('home.index')->with('success', 'Cập nhật thông tin thành công!');
}

   

   public function change_pass()
   {
      return view('account.Check_changePass');
   }

   public function Check_changePass(Request $request) 
{
    $auth = auth()->user(); 
    $data = $request->validate([
        'password' => 'required',
        'password_new' => 'required|min:4|max:20',
        'password_confirm' => 'required|same:password_new',
    ], [
        'password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'password_new.required' => 'Vui lòng nhập mật khẩu mới.',
        'password_new.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
        'password_new.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
        'password_confirm.required' => 'Vui lòng xác nhận lại mật khẩu.',
        'password_confirm.same' => 'Mật khẩu không đúng với mật khẩu mới.',
    ]);

    if (!Hash::check($request->password, $auth->password)) {
        return back()->withErrors(['password' => 'Mật khẩu của bạn không chính xác']);
    }

    // Mã hóa mật khẩu mới
    $auth->password = bcrypt($request->input('password_new'));

    // Update vào database
    if ($auth->update()) {
        auth()->logout();
        // Chuyển hướng về trang index với thông báo thành công
        return redirect()->route('home.index')->with('success', 'Bạn đã đổi mật khẩu thành công, bạn hãy đăng nhập lại!');
    } else {
        return redirect()->route('home.index')->with('error', 'Đã có lỗi xảy ra, vui lòng kiểm tra lại!');
    }
}



   public function Check_forgotPass()
    {
        
    }

   public function reset_pass()
   {
      return view('Client.Login');
   }

   public function Check_resetPass() {}
}
