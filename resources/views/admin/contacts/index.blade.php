@extends('admin.layouts.master')

@section('title')
  liên hệ
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
    <h1>Danh sách liên hệ</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table align-middle table-nowrap table-striped-columns mb-0">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 46px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">

                        <label class="form-check-label" for="cardtableCheck"></label>
                    </div>
                </th>
                <th scope="col">ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Thông điệp</th>
                <th>Trạng thái</th>
                <th>Hoạt động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="contactCheck{{ $contact }}">
                        <label class="form-check-label" for="contactCheck{{ $contact }}"></label>
                    </div>
                </td>
                <td>{{$contact->id }}</td>
                <td>{{ $contact->name }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->phone }}</td>
                <td>{{ $contact->message }}</td>
                <td>{{ $contact->status_contacts}}</td>
                <td>
                 
                    <a href="{{ route('admin.contacts.reply', $contact->id) }}" class="btn btn-info">Phản hồi</a>
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
