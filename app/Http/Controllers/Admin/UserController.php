<?php

namespace App\Http\Controllers\Admin;

<<<<<<< HEAD
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
                ->paginate(10);
        } else {
            // Nếu không nhập gì, lấy toàn bộ người dùng và phân trang
            $listCustomer = User::paginate(10);
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



    
    



=======
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\ProductVote;
use App\Models\Order;
use App\Mail\Admin\ActiveAccountMail;

class UserController extends Controller
{
  public function index()
  {
    $users = User::select('id', 'name', 'email', 'phone', 'address', 'provider', 'avatar_image', 'active', 'created_at')->where('admin', '<>', true)->get();
    return view('admin.user.index')->with('users', $users);
  }

  public function new(Request $request)
  {
    $rules = array(
      'email' => array('required', 'regex:/^[a-z](\.?[a-z0-9]){5,}@gmail\.com$/', 'unique:users')
    );
    $messsages = array(
      'email.required'  =>  'Email không được để trống!',
      'email.regex'  =>  'Email không đúng định dạng!',
      'email.unique'  =>  'Email đã tồn tại!'
    );
    $validator = Validator::make($request->all(), $rules, $messsages);
    if ($validator->fails()) {

      return response()->json($validator->messages(), 400);
    } else {

      $password = str::random(8);

      $user = new User;
      $user->name = 'New Account';
      $user->email = $request->email;
      $user->password = Hash::make($password);
      $user->active_token = str::random(40);

      $user->save();

      $data['token'] = $user->active_token;
      $data['password'] = $password;

      Mail::to($user)->send(new ActiveAccountMail($data));

      $data['type'] = 'success';
      $data['title'] = 'Thành Công';
      $data['content'] = 'Thêm tài khoản thành công!';

      return response()->json($data, 200);
    }
  }

  public function delete(Request $request)
  {
    $user = User::where([['id', $request->user_id],['active', false]])->first();
    if(!$user) {

      $data['type'] = 'error';
      $data['title'] = 'Thất Bại';
      $data['content'] = 'Bạn không thể xóa tài khoản đã kích hoạt hoặc tài khoản không tồn tại!';
    } else {

      $user->delete();

      $data['type'] = 'success';
      $data['title'] = 'Thành Công';
      $data['content'] = 'Xóa tài khoản thành công!';
    }

    return response()->json($data, 200);
  }

  public function show($id)
  {
    $user = User::select('id', 'name', 'email', 'phone', 'address', 'provider', 'avatar_image', 'active', 'created_at')->where([['id', $id], ['admin', false]])->first();
    if(!$user) abort(404);
    $product_votes = ProductVote::where('user_id', $user->id)->with(['product' => function($query) {
      $query->select('id', 'name', 'image');
    }])->latest()->get();

    $orders = Order::where('user_id', $user->id)->with([
      'payment_method' => function($query) {
        $query->select('id', 'name');
      },
      'order_details' => function($query) {
        $query->select('id', 'order_id', 'product_detail_id', 'quantity', 'price')
        ->with([
          'product_detail' => function ($query) {
            $query->select('id', 'product_id', 'color')
            ->with([
              'product' => function ($query) {
                $query->select('id', 'name', 'image', 'sku_code');
              }
            ]);
          }
        ]);
      }
    ])->latest()->get();
    return view('admin.user.show')->with(['user' => $user, 'product_votes' => $product_votes, 'orders' => $orders]);
  }

  public function send($id)
  {
    $user = User::where([['id', $id], ['active', false], ['admin', false]])->first();
    if(!$user) abort(404);

    $data['token'] = $user->active_token;
    $data['password'] = null;

    Mail::to($user)->send(new ActiveAccountMail($data));

    return back()->with(['alert' => [
      'type' => 'success',
      'title' => 'Thành Công',
      'content' => 'Gửi email kích hoạt tài khoản thành công.'
    ]]);
  }
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
}
