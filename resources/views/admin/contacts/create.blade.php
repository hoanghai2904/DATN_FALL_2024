@extends('admin.layouts.master')

@section('title')
  đơn hàng
@endsection

@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->


      <script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
    


@endsection

@section('content')
<div class="container">
    <h1>Tạo liên hệ mới</h1>
    <form action="{{ route('admin.contacts.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên của bạn</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Thông điệp</label>
            <textarea class="form-control" id="message" name="message"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tạo liên hệ</button>
    </form>
</div>
@endsection
