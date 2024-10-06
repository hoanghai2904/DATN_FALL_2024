@extends('Client.index')
@section('main')
 <!-- ...:::: Start Breadcrumb Section:::... -->
 <div class="breadcrumb-section breadcrumb-bg-color--golden">
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="breadcrumb-title">My Account</h3>
                    <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                        <nav aria-label="breadcrumb">
                            <ul>
                                <li><a href="index.html">Home</a></li>
                                <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                <li class="active" aria-current="page">My Account</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Breadcrumb Section:::... -->

 <!-- ...:::: Start Account Dashboard Section:::... -->
 <div class="account-dashboard">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-3 col-lg-3">
                <!-- Nav tabs -->
                <div class="dashboard_tab_button" data-aos="fade-up"  data-aos-delay="0">
                    <ul role="tablist" class="nav flex-column dashboard-list">
                        <li><a href="#dashboard" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover active">Tài khoản </a></li>
                        <li> <a href="#orders" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Đơn hàng</a></li>
                        <li><a href="#downloads" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Downloads</a></li>
                        <li><a href="#address" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Địa chỉ</a></li>
                        <li><a href="#account-password" data-bs-toggle="tab" class="nav-link btn btn-block btn-md btn-black-default-hover">Đổi mật khẩu</a></li>
                        <li><a href="{{route('account.logout')}}" class="nav-link btn btn-block btn-md btn-black-default-hover">Đăng xuât</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-12 col-md-9 col-lg-9">
                <!-- Tab panes -->
                <div class="tab-content dashboard_content" data-aos="fade-up"  data-aos-delay="200">
                    <div class="tab-pane fade show active" id="dashboard">
                        <h3>Tài khoản chi tiết</h3>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form action="#" method="POST" enctype="multipart/form-data">
                                        @csrf
                                    
                                        <div class="default-form-box mb-20">
                                            <label>Họ và tên</label>
                                            <input type="text" value="{{ $auth->full_name }}" name="full_name" required>
                                            @error('full_name')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        
                                        <div class="default-form-box mb-20">
                                            <label>Ảnh đại diện</label>
                                            <div style="display: flex; align-items: center;">
                                                <input type="file" name="cover" accept="image/*" onchange="previewAvatar(event)" style="margin-right: 10px; width: auto;">
                                                <img id="coverPreview" src="{{asset('storage/'. $auth->cover)}}" alt="Ảnh đại diện" style="display: block; width: 80px; height: 80px; object-fit: cover; margin-left: 10px;">
                                            </div>
                                        </div>
                                    
                                        <div class="default-form-box mb-20">
                                            <label>Số điện thoại</label>
                                            <div style="display: flex; align-items: center;">
                                                <input type="text" name="phone" value="{{ $auth->phone }}" placeholder="Số điện thoại" required>
                                                @error('phone')
                                                <small
                                                    style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                            @enderror
                                            </div>
                                        </div>
                                    
                                        <div class="default-form-box mb-20">
                                            <label>Ngày sinh</label>
                                            <input type="date" name="birthday" value="{{ $auth->birthday }}">
                                        </div>
                                    
                                        <div class="default-form-box mb-20">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $auth->email }}" required>
                                            @error('email')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    
                                        <div class="default-form-box mb-20">
                                            <label>Mật Khẩu</label>
                                            <input type="password" name="password" placeholder="Nhập mật khẩu để cập nhật ">
                                            @error('password')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    
                                        <div class="save_button mt-3">
                                            <button class="btn btn-md btn-black-default-hover" type="submit">Cập nhật</button>
                                        </div>
                                    </form>
                           
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="orders">
                        <h4>Orders</h4>
                        <div class="table_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>May 10, 2018</td>
                                        <td><span class="success">Completed</span></td>
                                        <td>$25.00 for 1 item </td>
                                        <td><a href="cart.html" class="view">view</a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>May 10, 2018</td>
                                        <td>Processing</td>
                                        <td>$17.00 for 1 item </td>
                                        <td><a href="cart.html" class="view">view</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="downloads">
                        <h4>Downloads</h4>
                        <div class="table_page table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Downloads</th>
                                        <th>Expires</th>
                                        <th>Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Shopnovilla - Free Real Estate PSD Template</td>
                                        <td>May 10, 2018</td>
                                        <td><span class="danger">Expired</span></td>
                                        <td><a href="#" class="view">Click Here To Download Your File</a></td>
                                    </tr>
                                    <tr>
                                        <td>Organic - ecommerce html template</td>
                                        <td>Sep 11, 2018</td>
                                        <td>Never</td>
                                        <td><a href="#" class="view">Click Here To Download Your File</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="address">
                        <h3>Địa Chỉ khách hàng</h3>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form action="#">
                                        @csrf
                                        <div class="default-form-box mb-20">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="first-name">
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Tỉnh/Thành phố </label>
                                            <input type="text" name="province">
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Quận/Huyện</label>
                                            <input type="text" name="district">
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Phường/Xã</label>
                                            <input type="text" name="ward">
                                        </div>
                                        <div class="save_button mt-3">
                                            <button class="btn btn-md btn-black-default-hover" type="submit">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="account-password">
                        <h3>Đổi mật khẩu</h3>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form action="{{route('account.Check_changePass')}}" method="POST">
                                        @csrf
                                        <div class="default-form-box mb-20">
                                            <label>Mật Khẩu cũ</label>
                                            <input type="password" name="password" placeholder="Nhập mật khẩu cũ ">
                                            @error('password')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Mật Khẩu mới</label>
                                            <input type="password" name="password_new" placeholder="Nhập mật khẩu mới ">
                                            @error('password_new')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <div class="default-form-box mb-20">
                                            <label>Xác nhận lại mật khẩu mới</label>
                                            <input type="password" name="password_confirm" placeholder="xác nhận mật khẩu mới ">
                                            @error('password_confirm')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                    
                                        <div class="save_button mt-3">
                                            <button class="btn btn-md btn-black-default-hover" type="submit">Cập nhật</button>
                                        </div>
                                    </form>   
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div> <!-- ...:::: End Account Dashboard Section:::... -->

<script>
    function previewAvatar(event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function () {
            const avatarPreview = document.getElementById('coverPreview');
            avatarPreview.src = reader.result;
            avatarPreview.style.display = 'block';
        }

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection