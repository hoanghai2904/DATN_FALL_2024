@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa địa chỉ')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Chỉnh sửa địa chỉ</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.user_addresses.update', $address->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                        <input type="text" name="full_name" id="full_name" class="form-control" value="{{ $address->full_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="cover" class="form-label">Ảnh bìa</label>
                        <input type="file" name="cover" id="cover" class="form-control">
                        @if($address->cover)
                            <img src="{{ Storage::url($address->cover) }}" alt="Cover Image" style="max-width: 100px; max-height: 100px;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $address->phone }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea name="address" id="address" class="form-control" required>{{ $address->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ $address->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="province_id" class="form-label">Tỉnh/Thành phố</label>
                        <input type="number" name="province_id" id="province_id" class="form-control" value="{{ $address->province_id }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="district_id" class="form-label">Quận/Huyện</label>
                        <input type="text" name="district_id" id="district_id" class="form-control" value="{{ $address->district_id }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="ward_id" class="form-label">Phường/Xã</label>
                        <input type="text" name="ward_id" id="ward_id" class="form-control" value="{{ $address->ward_id }}" required>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="is_default" class="form-check-label">Địa chỉ mặc định?</label>
                        <input type="checkbox" name="is_default" id="is_default" class="form-check-input" {{ $address->is_default ? 'checked' : '' }}>
                    </div> -->

                    <button type="submit" class="btn btn-primary">Cập nhật địa chỉ</button>
                    <a href="{{ route('admin.user_addresses.index') }}" class="btn btn-secondary">Trở về</a>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
