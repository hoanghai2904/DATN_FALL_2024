@extends('admin.layouts.master')
@section('content')
    <div class="container-fluid">

        <div class="position-relative mx-n4 mt-n4">
            <div class="profile-wid-bg profile-setting-img">
                <img src="{{ asset('theme/admin/assets') }}/images/profile-bg.jpg" class="profile-wid-img" alt="">
                <div class="overlay-content">
                    <div class="text-end p-3">
                        <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                            <input id="profile-foreground-img-file-input" type="file"
                                class="profile-foreground-img-file-input">
                            <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                                <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-4">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                @if (auth()->check() && auth()->user()->cover)
                                    {{-- Nếu người dùng đã đăng nhập và có ảnh đại diện, hiển thị ảnh --}}
                                    <img src="{{ asset('storage/' . auth()->user()->cover) }}"
                                        class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="Avatar">
                                @else
                                    {{-- Nếu không có ảnh đại diện, hiển thị biểu tượng người dùng --}}
                                    <i class="icon-user"></i>
                                @endif
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1">{{ auth()->user()->full_name }}</h5>
                            <span class="badge bg-success-subtle text-success">Role user</span>

                        </div>
                    </div>
                </div>
                <!--end card-->

                {{-- thay thế profile --}}
                <div class="card mb-3">
                    <div class="card-body">

                        <div class="table-card">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium">Thông tin</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td class="fw-medium">Số điện thoại :</td>
                                        <td>{{ $auth->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Email :</td>
                                        <td><span class="badge bg-danger-subtle text-danger">{{ $auth->email }}</span></td>
                                    </tr>
                                    {{-- <tr>
                                        <td class="fw-medium">Địa chỉ :</td>
                                        <td><span class="badge bg-secondary-subtle text-secondary">Inprogress</span></td>
                                    </tr> --}}
                                    <tr>
                                        <td class="fw-medium">Ngày Sinh :</td>
                                        <td>{{ \Carbon\Carbon::parse($auth->birthday)->format('d/m/Y') }}</td>

                                    </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-8">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i>Thông tin cá nhân
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="far fa-user"></i> Đổi mật khẩu
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" >
                                <form action="{{route('admin.Check_profile')}}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="firstnameInput" class="form-label">Họ và tên</label>
                                                <input type="text" class="form-control" id="firstnameInput" name="full_name"
                                                    placeholder="Enter your firstname" value="{{$auth->full_name}}">
                                            </div>
                                            @error('full_name')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <!--end col-->

                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="phonenumberInput" class="form-label">Số điện thoại</label>
                                                <input type="text" class="form-control" id="phonenumberInput" name="phone"
                                                    placeholder="Enter your phone number" value="{{$auth->phone}}">
                                            </div>
                                            @error('phone')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emailInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailInput" name="email"
                                                    placeholder="Enter your email" value="{{$auth->email}}"
                                                    >
                                            </div>
                                            @error('email')
                                            <small
                                                style="color: #dc3545; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</small>
                                        @enderror
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="JoiningdatInput" class="form-label">Ngày sinh</label>
                                                <input type="date" class="form-control" data-provider="flatpickr"
                                                    id="JoiningdatInput" data-date-format="d M, Y"
                                                    data-deafult-date="24 Nov, 2021" placeholder="Select date" 
                                                    value="{{$auth->birthday}}"  name="birthday"/>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="skillsInput" class="form-label">Giới tính</label>
                                                <select class="form-control" name="gender">
                                                    <option value="Nam" {{ $auth->gender == '1' ? 'selected' : '' }}>Nam</option>
                                                    <option value="Nữ" {{ $auth->gender == '2' ? 'selected' : '' }}>Nữ</option>
                                                    <option value="Khác" {{ $auth->gender == '3' ? 'selected' : '' }}>Khác</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->


                                        <!--end col-->
                                        {{-- <div class="col-lg-12">
                                            <div class="mb-3 pb-2">
                                                <label for="exampleFormControlTextarea"
                                                    class="form-label">Địa chỉ</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your description" rows="3">Hi I'm Anna Adame,It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is European languages are members of the same family.</textarea>
                                            </div>
                                        </div> --}}
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Cập Nhập</button>
                                                <button type="reset" class="btn btn-soft-success">Hủy</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="oldpasswordInput" class="form-label">Mật khẩu cũ*</label>
                                                <input type="password" class="form-control" id="oldpasswordInput "
                                                    placeholder="Enter current password" name="oldPassword">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="newpasswordInput" class="form-label">Mật khẩu mới*</label>
                                                <input type="password" class="form-control" id="newpasswordInput"
                                                    placeholder="Enter new password" name="newPassword">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="confirmpasswordInput" class="form-label">Xác nhận mật khẩu
                                                    mới*</label>
                                                <input type="password" class="form-control" id="confirmpasswordInput"
                                                    placeholder="Confirm password" name="confirmPassword">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <a href="javascript:void(0);"
                                                    class="link-primary text-decoration-underline">Quên mật khẩu ?</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Thay đổi mật khẩu </button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>

                            </div>
                            <!--end tab-pane-->


                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div>
    <!-- container-fluid -->
    </div><!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> © Shop pet.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Design & Develop by shop pet
                    </div>
                </div>
            </div>
        </div>
    </footer>
    </div>
@endsection
