@extends('admin.layouts.master')

@section('title')
    danh mục mã giảm giá
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
            @if (session('msg_warning'))
                <div class="alert alert-danger">{{ session('msg_warning') }}</div>
            @endif
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                </div>
                <!-- end card header -->
                <div class="card-body">
                    {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}

                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <div class="d-flex justify-content-end mb-2">
                                <a class="btn btn-info" href="{{ route('admin.vouchers.create') }}">Thêm mới</a>
                            </div>
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;"><input type="checkbox" id="checkboxesMain"></th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Mã số</th>
                                        <th scope="col">Tên mã giảm giá</th>
                                        <th scope="col">Giảm giá</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Ngày bắt đầu</th>
                                        <th scope="col">Ngày kết thúc</th>
                                        <th scope="col" style="">Hành động</th>
                                    </tr>
                                </thead>
                                @if (!empty($list))
                                    @foreach ($list as $key => $item)
                                        <tbody>
                                            <tr id="tr_{{$item->id}}">
                                                <td><input type="checkbox" class="checkbox" data-id="{{$item->id}}"></td>
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}Đ
                                                    @else
                                                        {{ number_format($item->discount, 0, '', '.') }}%
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-info">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="SwitchCheck6" checked>
                                                    </div>
                                                </td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->start }}</td>
                                                <td>{{ $item->end }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                        class="btn btn-warning sm-2">Sửa</a>

                                                    <form action="{{ route('admin.vouchers.destroy', $item->id) }}"
                                                        method="post" style="display:inline;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button href="" type="submit"
                                                            onclick="return confirm('Có chắc muốn xóa?')"
                                                            class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </td>

                                            </tr>
                                        </tbody>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center">Không có mã giảm giá nào</td>
                                    </tr>
                                @endif
                            </table>
                            <div class="float-right">
                                {{ $list->links() }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkboxesMain').on('click', function(e) {
                if ($(this).is(':checked',true)) {
                    $(".checkbox").prop('checked', true);
                } else {
                    $(".checkbox").prop('checked', false);
                }
            });
        });
    </script>
    
@endsection
