@extends('admin.layouts.master')

@section('title')
  Địa chỉ người dùng
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
    <script src="{{ asset('theme/admin/js/demo/datatables-demo.js') }}"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
            </div>
            <!-- end card header -->

            <a href="{{ route('admin.user_addresses.create') }}" class="mb-3" style="margin-left: 25px; margin-top: 10px;">
                <button class="btn btn-success">Thêm địa chỉ mới</button>
            </a>

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive table-card">
                    <table class="table table-sm align-middle table-nowrap table-striped-columns mb-0"> 
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 36px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                            <label class="form-check-label" for="cardtableCheck"></label>
                                        </div>
                                    </th>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th >Địa chỉ</th>
                                    <th>Email</th>
                                    <th>Ảnh bìa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($userAddresses as $address)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="cardtableCheck{{ $address->id }}">
                                            <label class="form-check-label" for="cardtableCheck{{ $address->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{ $address->id }}</td>
                                    <td>{{ $address->full_name }}</td>
                                    <td>{{ $address->address }}</td>
                                    <td>{{ $address->email }}</td>
                                    <td>
                                        @if($address->cover)
                                            <img src="{{ Storage::url($address->cover) }}" alt="Cover Image" style="max-width: 100px; max-height: 100px;">
                                        @else
                                            <span>Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>
                                    <a href="{{ route('admin.user_addresses.edit', $address->id) }}" class="btn btn-primary btn-sm">Chỉnh sửa</a>

                                    <form action="{{ route('admin.user_addresses.destroy', $address->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
<!-- end row -->

@endsection
