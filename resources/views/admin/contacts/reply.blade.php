@extends('admin.layouts.master')

@section('title', 'Phản hồi liên hệ')

@section('style-libs')
    <!-- Custom styles for this page -->
    <link href="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('script-libs')
    <!-- Page level plugins -->
    <script src="{{ asset('theme/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Select2 plugin -->
    <script src="{{ asset('theme/admin/vendor/select2/select2.min.js') }}"></script>
    
    <!-- Page level custom scripts -->
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Phản hồi liên hệ</h4>
            </div>

            <div class="card-body">
                <!-- Hiển thị tên và email của liên hệ -->
                <div class="mb-3">
                    <label class="form-label">Tên liên hệ:</label>
                    <p>{{ $contact->name }}</p>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <p>{{ $contact->email }}</p>
                </div>

                <!-- Form phản hồi -->
                <form action="{{ route('admin.contacts.sendResponse', $contact->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="response_message" class="form-label">Nội dung phản hồi</label>
                        <textarea class="form-control" name="response_message" rows="4" required>{{ old('response_message') }}</textarea>
                    </div>
                    <div style="margin-top:10px">
                        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Trở về</a>
                    </div>
                </form>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
@endsection
