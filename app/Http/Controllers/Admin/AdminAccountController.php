<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\Ward;
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
   
       // Lấy người dùng dựa trên email
       $user = User::where('email', $data['email'])->first();
   
       // Kiểm tra trạng thái tài khoản
       if ($user->status === 'inactive') {
           return back()->withErrors([
               'email' => 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.',
           ])->withInput();
       }
   
       // Kiểm tra thông tin đăng nhập
       if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
           // Kiểm tra xem người dùng có ít nhất một vai trò hay không
           if ($user->roles->isEmpty()) {
               Auth::logout(); // Đăng xuất nếu không có vai trò
               return back()->withErrors([
                   'email' => 'Bạn không có quyền truy cập vào trang quản trị.',
               ])->withInput();
           }
   
           // Lấy quyền của người dùng và lưu vào session
           $permissions = $user->roles()
               ->with('permissions')
               ->get()
               ->pluck('permissions.*.name')
               ->flatten()
               ->unique();
           session(['user_permissions' => $permissions]);
   
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
    $provinces = Province::all();
     return view('admin.Login.profile',compact('auth','provinces'));
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

 
 //còn chức năng change password

 public function Check_changePass(Request $request) 
{
    $auth = auth()->user(); 

    // Validate dữ liệu đầu vào
    $data = $request->validate([
        'oldPassword' => 'required',
        'newPassword' => 'required|min:4|max:20',
        'confirmPassword' => 'required|same:newPassword',
    ], [
        'oldPassword.required' => 'Vui lòng nhập mật khẩu hiện tại.',
        'newPassword.required' => 'Vui lòng nhập mật khẩu mới.',
        'newPassword.min' => 'Mật khẩu phải có ít nhất 4 ký tự.',
        'newPassword.max' => 'Mật khẩu không được vượt quá 20 ký tự.',
        'confirmPassword.required' => 'Vui lòng xác nhận lại mật khẩu.',
        'confirmPassword.same' => 'Mật khẩu không đúng với mật khẩu mới.',
    ]);

    // Kiểm tra mật khẩu cũ có khớp không
    if (!Hash::check($request->oldPassword, $auth->password)) {
        return response()->json(['message' => 'Mật khẩu hiện tại không chính xác.'], 422);
    }

    // Kiểm tra xem mật khẩu mới có trùng mật khẩu cũ không
    if (Hash::check($request->newPassword, $auth->password)) {
        return response()->json(['message' => 'Mật khẩu mới không được trùng với mật khẩu hiện tại.'], 422);
    }

    // Mã hóa mật khẩu mới và lưu vào database
    $auth->password = Hash::make($request->newPassword);

    if ($auth->save()) {
        // Trả về JSON nếu thành công
        return response()->json(['message' => 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.']);
    }

    // Trả về JSON nếu lưu thất bại
    return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại sau.'], 500);
}
 //addresses

 public function getDistricts($provinceId)
 {
     $districts = District::where('province_id', $provinceId)->get();
     return response()->json($districts);
 }

 public function getWards($districtId)
{
    $wards = Ward::where('district_id', $districtId)->get(); // Lấy phường/xã theo district_id
    return response()->json($wards);
}


public function store(Request $request)
{
    $request->validate([
        'province_id' => 'required|exists:provinces,id',
        'district_id' => 'required|exists:districts,id',
        'ward_id' => 'required|exists:wards,id',
        'address_detail' => 'required|string|max:255',
    ], [
        'province_id.required' => 'Vui lòng chọn tỉnh/thành phố.',
        'province_id.exists' => 'Tỉnh/thành phố không tồn tại.',
        'district_id.required' => 'Vui lòng chọn quận/huyện.',
        'district_id.exists' => 'Quận/huyện không tồn tại.',
        'ward_id.required' => 'Vui lòng chọn phường/xã.',
        'ward_id.exists' => 'Phường/xã không tồn tại.',
        'address_detail.required' => 'Vui lòng nhập địa chỉ chi tiết.',
        'address_detail.string' => 'Địa chỉ chi tiết phải là một chuỗi ký tự.',
        'address_detail.max' => 'Địa chỉ chi tiết không được vượt quá 255 ký tự.',
    ]);

    UserAddress::create([
        'user_id' => auth()->id(),  // Lấy ID của user đã đăng nhập
        'province_id' => $request->province_id,
        'district_id' => $request->district_id,
        'ward_id' => $request->ward_id,
        'address' => $request->address_detail,
    ]);

    return response()->json(['message' => 'Địa chỉ đã được thêm thành công']);
}

 //còn chức năng forgot password
}
