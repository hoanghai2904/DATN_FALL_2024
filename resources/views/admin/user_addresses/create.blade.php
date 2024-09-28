@extends('admin.layouts.master')

@section('title', 'Thêm địa chỉ mới')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Thêm địa chỉ mới</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.user_addresses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cover" class="form-label">Ảnh bìa</label>
                        <input type="file" name="cover" id="cover" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea name="address" id="address" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="province_id" class="form-label">Tỉnh/Thành phố</label>
                        <input type="number" name="province_id" id="province_id" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="district_id" class="form-label">Quận/Huyện</label>
                        <input type="text" name="district_id" id="district_id" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="ward_id" class="form-label">Phường/Xã</label>
                        <input type="text" name="ward_id" id="ward_id" class="form-control" required>
                    </div>
<!-- 
                    <div class="mb-3">
                        <label for="is_default" class="form-check-label">Địa chỉ mặc định?</label>
                        <input type="checkbox" name="is_default" id="is_default" class="form-check-input">
                    </div> -->

                    <button type="submit" class="btn btn-success">Thêm địa chỉ</button>
                    <a href="{{ route('admin.user_addresses.index') }}" class="btn btn-secondary">Trở về</a>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
