<?php

namespace App\Http\Controllers\Pages;

use App\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SendOrderMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\ProductDetail;
use App\Models\Cart;
use App\Models\Advertise;
use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\OrderDetail;
use App\NL_Checkout;

class CartController extends Controller
{
  public function addCart(Request $request) {

    $product = ProductDetail::where('id',$request->id)
    ->with(['product' => function($query) {
      $query->select('id', 'name', 'image', 'sku_code');
    }])->select('id', 'product_id', 'color','size', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')->first();

    if(!$product) {
      $data['msg'] = 'Product Not Found!';
      return response()->json($data, 404);
    }

    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    if(!$cart->add($product, $product->id, $request->qty)) {
      $data['msg'] = 'Số lượng sản phẩm trong giỏ vượt quá số lượng sản phẩm trong kho!';
      return response()->json($data, 412);
    }
    Session::put('cart', value: $cart);

    $data['msg'] = "Thêm giỏ hàng thành công";
    $data['url'] = route('home_page');
    $data['response'] = Session::get('cart');

    return response()->json($data, 200);
  }

  public function updateFee(Request $request) {
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->fee = $request->fee;
    Session::put('cart', $cart);

    return response()->json(null, 200);
  }

  public function removeCart(Request $request) {

    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);

    if(!$cart->remove($request->id)) {
      $data['msg'] = 'Sản Phẩm không tồn tại!';
      return response()->json($data, 404);
    } else {
      Session::put('cart', $cart);

      $data['msg'] = "Xóa sản phẩm thành công";
      $data['url'] = route('home_page');
      $data['response'] = Session::get('cart');

      return response()->json($data, 200);
    }
  }

  public function updateCart(Request $request) {
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    if(!$cart->updateItem($request->id, $request->qty)) {
      $data['msg'] = 'Số lượng sản phẩm trong giỏ vượt quá số lượng sản phẩm trong kho!';
      return response()->json($data, 412);
    }
    Session::put('cart', $cart);

    $response = array(
      'id' => $request->id,
      'qty' => $cart->items[$request->id]['qty'],
      'price' => $cart->items[$request->id]['price'],
      'salePrice' => $cart->items[$request->id]['item']->sale_price,
      'totalPrice' => $cart->totalPrice,
      'totalQty' => $cart->totalQty,
      'maxQty'  =>  $cart->items[$request->id]['item']->quantity
    );
    $data['response'] = $response;
    return response()->json($data, 200);
  }

  public function updateMiniCart(Request $request) {
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    if(!$cart->updateItem($request->id, $request->qty)) {
      $data['msg'] = 'Số lượng sản phẩm trong giỏ vượt quá số lượng sản phẩm trong kho!';
      return response()->json($data, 412);
    }
    Session::put('cart', $cart);

    $response = array(
      'id' => $request->id,
      'qty' => $cart->items[$request->id]['qty'],
      'price' => $cart->items[$request->id]['price'],
      'totalPrice' => $cart->totalPrice,
      'totalQty' => $cart->totalQty,
      'maxQty'  =>  $cart->items[$request->id]['item']->quantity
    );
    $data['response'] = $response;
    return response()->json($data, 200);
  }

  public function showCart() {

    $advertises = Advertise::where([
      ['start_date', '<=', date('Y-m-d')],
      ['end_date', '>=', date('Y-m-d')],
      ['at_home_page', '=', false]
    ])->latest()->limit(5)->get(['product_id', 'title', 'image']);

    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    return view('pages.cart')->with(['cart' => $cart, 'advertises' => $advertises]);
  }

  public function showCheckout(Request $request)
  {
    // Redirect admin users to home page
    if (Auth::check() && Auth::user()->Role) {
        return redirect()->route('home_page')->with([
            'alert' => [
                'type' => 'error',
                'title' => 'Thông Báo',
                'content' => 'Bạn không có quyền truy cập vào trang này!'
            ]
        ]);
    }
    $payment_methods = PaymentMethod::select('id', 'name', 'describe')->get();
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->update();
    Session::put('cart', $cart);
    if($cart->items == null) {
      return redirect()->route('home_page')->with([
        'alert' => [
          'type' => 'warning',
          'title' => 'Thông Báo',
          'content' => 'Giỏ hàng của bạn đang trống!'
        ]
      ]);
    }
        // Retrieve user address if logged in
    $user_address = null;
    if (Auth::check()) {
        $user = Auth::user();
        $user_address = $user->address ?? null; // Replace 'address' with the actual field storing the user's address
    }
    // Handle 'buy_now' type
    if ($request->has('type') && $request->type == 'buy_now') {
        $product = ProductDetail::where('id', $request->id)
            ->with(['product' => function ($query) {
                $query->select('id', 'name', 'image', 'sku_code');
            }])
            ->select('id', 'product_id', 'color', 'quantity', 'sale_price', 'promotion_price', 'promotion_start_date', 'promotion_end_date')
            ->first();

        $cart = new Cart(null);

        // Check if the product can be added to the cart
        if (!$cart->add($product, $product->id, $request->qty)) {
            return back()->with([
                'alert' => [
                    'type' => 'warning',
                    'title' => 'Thông Báo',
                    'content' => 'Số lượng sản phẩm trong giỏ vượt quá số lượng sản phẩm trong kho!'
                ]
            ]);
        }

        return view('pages.checkout', [
            'cart' => $cart,
            'payment_methods' => $payment_methods,
            'buy_method' => $request->type,
            'user_address' => $user_address
        ]);
    }

     return view('pages.checkout', [
        'cart' => $cart,
        'payment_methods' => $payment_methods,
        'buy_method' => $request->type,
        'user_address' => $user_address
    ]);
  }
  function createVNPayUrl($order_code, $amount, $order_info, $ip_address)
  {
    $vnp_TmnCode = env('VNP_TMNCODE');
    $vnp_HashSecret = env('VNP_HASHSECRET');
    $vnp_Url = env('VNP_URL');
    $vnp_Returnurl = route('payment_response');
    $startTime = date("YmdHis");
    $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

    $inputData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => $vnp_TmnCode,
        "vnp_Amount" => $amount * 100, // Số tiền (VND) nhân 100 để phù hợp với yêu cầu VNPay
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $ip_address,
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => $order_info,
        "vnp_OrderType" => "billpayment",
        "vnp_ReturnUrl" => $vnp_Returnurl,
        "vnp_TxnRef" => $order_code,
        "vnp_ExpireDate"=>$expire
    ];

    // Sắp xếp dữ liệu theo thứ tự alphabet
    ksort($inputData);

    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }

    $vnp_Url = $vnp_Url . "?" . $query;
    if (isset($vnp_HashSecret)) {
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    }

      return $vnp_Url;
  }

  public function prepareDataSend($order)
  {
      // Ensure the order object includes the order_details and payment_method relationships
      $order->load(['order_details.product_detail.product', 'payment_method']);

      // Convert the order object to an array
      $dataSend = $order->toArray();

      // Add the payment method name to the dataSend array
      $dataSend['payment_method_name'] = $order->payment_method->name;

      return $dataSend;
  }

  public function payment(Request $request) {
    $payment_method = PaymentMethod::select('id', 'name')->where('id', $request->payment_method)->first();
    if(Str::contains($payment_method->name, 'COD')) {
      if($request->buy_method == 'buy_now'){
        $order = new Order;
        $order->user_id = Auth::user()?->id ?? NULL;
        $order->payment_method_id = $request->payment_method;
        $order->order_code = 'PSO'.str_pad(rand(0, pow(10, 5) - 1), 5, '0', STR_PAD_LEFT);
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->fee = $request?->fee ?? 30000;
        $order->coupon_id = $request->coupon_id ?? NULL;
        $order->discount = $request->discount_amount ?? 0;
        $order->status = OrderStatusEnum::PENDING;
        $order->save();
        if ($order->coupon_id) {
          $user = Auth::user();
          $user_coupon = $user->userCoupons()->where('coupon_id', $order->coupon_id)->first();
          if ($user_coupon) {
            $user_coupon->is_used = 1;
            $user_coupon->used_at = now();
            $user_coupon->save();
          }
        }

        $order_details = new OrderDetail;
        $order_details->order_id = $order->id;
        $order_details->product_detail_id = $request->product_id;
        $order_details->quantity = $request->totalQty;
        $order_details->price = $request->price;
        $order_details->save();

        $product = ProductDetail::find($request->product_id);
        $product->quantity = $product->quantity - $request->totalQty;
        $product->save();
        $dataSend = $this->prepareDataSend($order);
        SendOrderMail::dispatch($dataSend);

        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'success',
          'title' => 'Mua hàng thành công',
          'content' => 'Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi. Sản phẩm của bạn sẽ được chuyển đến trong thời gian sớm nhất.'
        ]]);
      } elseif ($request->buy_method == 'buy_cart') {
        $cart = Session::get('cart');
        if(!$cart) {
          return redirect()->route('home_page')->with(['alert' => [
            'type' => 'warning',
            'title' => 'Thông Báo',
            'content' => 'Giỏ hàng của bạn đang trống!'
          ]]);
        }

        $order = new Order;
        $order->user_id = Auth::user()->id ?? NULL;
        $order->payment_method_id = $request->payment_method;
        $order->order_code = 'PSO'.str_pad(rand(0, pow(10, 5) - 1), 5, '0', STR_PAD_LEFT);
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->fee = $cart?->fee ?? 30000;
        $order->coupon_id = $request->coupon_id ?? NULL;
        $order->discount = $request->discount_amount ?? 0;
        $order->status = OrderStatusEnum::PENDING;

        $order->save();
        if ($order->coupon_id) {
          $user = Auth::user();
          $user_coupon = $user->userCoupons()->where('coupon_id', $order->coupon_id)->first();
          if ($user_coupon) {
            $user_coupon->is_used = 1;
            $user_coupon->used_at = now();
            $user_coupon->save();
          }
        }

        foreach ($cart->items as $key => $item) {
          $order_details = new OrderDetail;
          $order_details->order_id = $order->id;
          $order_details->product_detail_id = $item['item']->id;
          $order_details->quantity = $item['qty'];
          $order_details->price = $item['price'];
          $order_details->save();

          $product = ProductDetail::find($item['item']->id);
          $product->quantity = $product->quantity - $item['qty'];
          $product->save();
        }

        $dataSend = $this->prepareDataSend($order);

        SendOrderMail::dispatch($dataSend);
        Session::forget('cart');
        return redirect()->route('home_page')->with(['alert' => [
          'type' => 'success',
          'title' => 'Mua hàng thành công',
          'content' => 'Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi. Sản phẩm của bạn sẽ được chuyển đến trong thời gian sớm nhất.'
        ]]);
      }
    } elseif(Str::contains($payment_method->name, 'Online Payment')) {
      if($request->buy_method == 'buy_now'){
        $order = new Order;
        $order->user_id = Auth::user()->id ?? NULL;
        $order->payment_method_id = $request->payment_method;
        $order->order_code = 'PSO'.str_pad(rand(0, pow(10, 5) - 1), 5, '0', STR_PAD_LEFT);
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->status = OrderStatusEnum::PENDING;
        $order->fee = $request?->fee ?? 30000;
        $order->coupon_id = $request->coupon_id ?? NULL;
        $order->discount = $request->discount_amount ?? 0;
        $order->save();
        if ($order->coupon_id) {
          $user = Auth::user();
          $user_coupon = $user->userCoupons()->where('coupon_id', $order->coupon_id)->first();
          if ($user_coupon) {
            $user_coupon->is_used = 1;
            $user_coupon->used_at = now();
            $user_coupon->save();
          }
        }

        $order_details = new OrderDetail;
        $order_details->order_id = $order->id;
        $order_details->product_detail_id = $request->product_id;
        $order_details->quantity = $request->totalQty;
        $order_details->price = $request->price;
        $order_details->save();

        $totalPayment = $request->price * $request->totalQty + $order->fee;
        $vnpUrl = $this->createVNPayUrl(
      $order->order_code,
      $totalPayment,
          "Thanh toán đơn hàng tại " . config('app.name'),
          $request->ip()
        );

        return redirect()->away($vnpUrl);


        // Tạo url thanh toán
        // $receiver = env('RECEIVER');
        // $order_code = $order->order_code;
        // $return_url = route('payment_response');
        // $cancel_url = route('payment_response');
        // $notify_url = route('payment_response');
        // $transaction_info = $order->id;
        // $currency = "vnd";
        // $quantity = $request->totalQty;
        // $price = $order_details->price * $order_details->quantity;
        // $tax =0;
        // $discount =0;
        // $fee_cal =0;
        // $fee_shipping =0;
        // $order_description ="Thanh toán đơn hàng ".config('app.name');
        // $buyer_info = $request->name."*|*".$request->email."*|*".$request->phone."*|*".$request->address;
        // $affiliate_code = "";

        // $nl= new NL_Checkout();
        // $nl->nganluong_url = env('NGANLUONG_URL');
        // $nl->merchant_site_code = env('MERCHANT_ID');
        // $nl->secure_pass = env('MERCHANT_PASS');

        // $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount , $fee_cal,    $fee_shipping, $order_description, $buyer_info , $affiliate_code);
        // $url .='&cancel_url='. $cancel_url . '&notify_url='.$notify_url;

        // return redirect()->away($url);
      } elseif ($request->buy_method == 'buy_cart') {
        $cart = Session::get('cart');
        if(!$cart) {
          return redirect()->route('home_page')->with(['alert' => [
            'type' => 'warning',
            'title' => 'Thông Báo',
            'content' => 'Giỏ hàng của bạn đang trống!'
          ]]);
        }

        $order = new Order;
        $order->user_id = Auth::user()?->id ?? NULL;
        $order->payment_method_id = $request->payment_method;
        $order->order_code = 'PSO'.str_pad(rand(0, pow(10, 5) - 1), 5, '0', STR_PAD_LEFT);
        $order->name = $request->name;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->status = OrderStatusEnum::PENDING;
        $order->fee = $cart?->fee ?? 30000;
        $order->coupon_id = $request->coupon_id ?? NULL;
        $order->discount = $request->discount_amount ?? 0;
        $order->save();
        if ($order->coupon_id) {
          $user = Auth::user();
          $user_coupon = $user->userCoupons()->where('coupon_id', $order->coupon_id)->first();
          if($user_coupon) {
            $user_coupon->is_used = 1;
            $user_coupon->used_at = now();
            $user_coupon->save();
          }
        }

        foreach ($cart->items as $key => $item) {
          $order_details = new OrderDetail;
          $order_details->order_id = $order->id;
          $order_details->product_detail_id = $item['item']->id;
          $order_details->quantity = $item['qty'];
          $order_details->price = $item['price'];
          $order_details->save();
        }

        $totalPayment = $cart->totalPrice + $order->fee - $request->discount_amount;
        $vnpUrl = $this->createVNPayUrl(
    $order->order_code,
            $totalPayment,
            "Thanh toán giỏ hàng tại " . config('app.name'),
            $request->ip()
        );
        session()->forget('cart');

        return redirect()->away($vnpUrl);


        // Tạo url thanh toán
        // $receiver = env('RECEIVER');
        // $order_code = $order->order_code;
        // $return_url = route('payment_response');
        // $cancel_url = route('payment_response');
        // $notify_url = route('payment_response');
        // $transaction_info = $order->id;
        // $currency = "vnd";
        // $quantity = $cart->totalQty;
        // $price = $cart->totalPrice;
        // $tax =0;
        // $discount =0;
        // $fee_cal =0;
        // $fee_shipping =0;
        // $order_description ="Thanh toán đơn hàng ".config('app.name');
        // $buyer_info = $request->name."*|*".$request->email."*|*".$request->phone."*|*".$request->address;
        // $affiliate_code = "";

        // $nl= new NL_Checkout();
        // $nl->nganluong_url = env('NGANLUONG_URL');
        // $nl->merchant_site_code = env('MERCHANT_ID');
        // $nl->secure_pass = env('MERCHANT_PASS');

        // $url= $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount , $fee_cal,    $fee_shipping, $order_description, $buyer_info , $affiliate_code);
        // $url .='&cancel_url='. $cancel_url . '&notify_url='.$notify_url;

        // Session::forget('cart');
        // return redirect()->away($url);
      }
    }
  }

  public function responsePayment(Request $request)
  {
    // Khóa bí mật từ VNPay (cần khai báo trong file .env)
    $vnp_HashSecret = env('VNP_HASHSECRET');

    // Lấy toàn bộ tham số trả về từ VNPay
    $inputData = array();
    foreach ($request->query() as $key => $value) {
        if (substr($key, 0, 4) == "vnp_") {
            $inputData[$key] = $value;
        }
    }

    // Tách SecureHash để kiểm tra
    $vnp_SecureHash = $inputData['vnp_SecureHash'];
    unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);

    // Sắp xếp tham số theo thứ tự key để kiểm tra chữ ký
    ksort($inputData);
    $i = 0;
    $hashData = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashData .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

    // Tạo chữ ký để đối chiếu với chữ ký từ VNPay
    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
    if ($secureHash === $vnp_SecureHash) {
        // Chữ ký hợp lệ, kiểm tra mã phản hồi
        if ($inputData['vnp_ResponseCode'] == "00") {
            // Thanh toán thành công
            $order_code = $inputData['vnp_TxnRef'];
            $order = Order::where('order_code', $order_code)->first();

            if ($order) {
                $order->status = OrderStatusEnum::CONFIRMED;
                $order->is_paid = true;
                $order->save();

                // Cập nhật số lượng sản phẩm
                foreach ($order->order_details as $order_detail) {
                    $product_detail = ProductDetail::where('id', $order_detail->product_detail_id)->first();
                    if ($product_detail) {
                        $product_detail->quantity -= $order_detail->quantity;
                        $product_detail->save();
                    }
                }
                $dataSend = $this->prepareDataSend($order);
                SendOrderMail::dispatch($dataSend);

                Session::forget('cart');

                return redirect()->route('home_page')->with(['alert' => [
                    'type' => 'success',
                    'title' => 'Thanh toán thành công!',
                    'content' => 'Cảm ơn bạn đã tin tưởng và lựa chọn chúng tôi.'
                ]]);
            } else {
                return redirect()->route('home_page')->with(['alert' => [
                    'type' => 'error',
                    'title' => 'Đơn hàng không tồn tại!',
                    'content' => 'Vui lòng liên hệ hỗ trợ để được xử lý.'
                ]]);
            }
        } else {
          $order_code = $inputData['vnp_TxnRef'];
          $order = Order::where('order_code', $order_code)->first();
          $order->status = OrderStatusEnum::PENDING;
          $order->save();
            // Thanh toán thất bại
            return redirect()->route('home_page')->with(['alert' => [
                'type' => 'error',
                'title' => 'Thanh toán không thành công!',
                'content' => 'VNPay từ chối giao dịch.'
            ]]);
        }
    } else {
        return redirect()->route('home_page')->with(['alert' => [
            'type' => 'error',
            'title' => 'Chữ ký không hợp lệ!',
            'content' => 'Có lỗi xảy ra trong quá trình xác thực giao dịch.'
        ]]);
    }
  }

  public function paymentNow($order_id) {
    $order = Order::where('id', $order_id)
        ->where('status', OrderStatusEnum::PENDING)
        ->where('is_paid', false)
        ->where('payment_method_id', 2)
        ->with('order_details')
        ->first();

    if (!$order) {
        return redirect()->route('orders_page')->with(['alert' => [
            'type' => 'error',
            'title' => 'Thanh toán không thành công!',
            'content' => 'Đơn hàng không tồn tại hoặc đã được thanh toán.'
        ]]);
    }

    // Calculate the total price from order details
    $totalPrice = $order->order_details->sum(function($detail) {
        return $detail->quantity * $detail->price;
    });

    // Add the fee from the order
    $totalPrice += $order->fee;
    // Add the discount from the order
    $totalPrice -= $order->discount;

    $vnpUrl = $this->createVNPayUrl(
        $order->order_code,
        $totalPrice,
        "Thanh toán đơn hàng tại " . config('app.name'),
        request()->ip()
    );

    return redirect()->away($vnpUrl);
  }


  // public function responsePayment(Request $request) {
  //   if ($request->filled('payment_id')) {

  //     // Lấy các tham số để chuyển sang Ngânlượng thanh toán:
  //     $transaction_info =$request->transaction_info;
  //     $order_code =$request->order_code;
  //     $price =$request->price;
  //     $payment_id =$request->payment_id;
  //     $payment_type =$request->payment_type;
  //     $error_text =$request->error_text;
  //     $secure_code =$request->secure_code;

  //     //Khai báo đối tượng của lớp NL_Checkout
  //     $nl= new NL_Checkout();
  //     $nl->merchant_site_code = env('MERCHANT_ID');
  //     $nl->secure_pass = env('MERCHANT_PASS');

  //     //Tạo link thanh toán đến nganluong.vn
  //     $checkpay= $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

  //     if ($checkpay) {
  //       $order = Order::where([['id', $transaction_info],['order_code', $order_code]])->first();
  //       $order->status = 1;
  //       $order->save();

  //       foreach ($order->order_details as $order_detail) {
  //         $product_detail = ProductDetail::where('id', $order_detail->product_detail_id)->first();
  //         $product_detail->quantity = $product_detail->quantity - $order_detail->quantity;
  //         $product_detail->save();
  //       }
  //       return redirect()->route('home_page')->with(['alert' => [
  //         'type' => 'success',
  //         'title' => 'Thanh toán thành công!',
  //         'content' => 'Cảm ơn bạn đã tin tưởng và lựa chọn chúng tối.'
  //       ]]);
  //     }else{
  //       return redirect()->route('home_page')->with(['alert' => [
  //         'type' => 'error',
  //         'title' => 'Thanh toán không thành công!',
  //         'content' => $error_text
  //       ]]);
  //     }
  //   } else {
  //     return redirect()->route('home_page')->with(['alert' => [
  //       'type' => 'error',
  //       'title' => 'Thanh toán không thành công!',
  //       'content' => 'Bạn đã hủy hoặc đã xẩy ra lỗi trong quá trình thanh toán.'
  //     ]]);
  //   }
  // }
}
