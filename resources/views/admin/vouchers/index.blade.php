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
                <div class="card-body">
                    <div class="live-preview">
                        <div>
                            <div class="row mb-2">
                                <div class="col-12 d-flex align-items-center">
                                    <form action="" method="GET" class="d-flex me-auto">
                                        <select name="status" id="" class="form-control me-3" style="width: 200px;">
                                            <option value="" {{ request('status') == '' ? 'selected' : '' }}>Chọn trạng thái</option>
                                            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Ngừng hoạt động</option>
                                        </select>
                                        <input type="search" name="keywords" id="" class="form-control me-3" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request()->keywords }}" style="width: 300px;">
                                        <button type="submit" class="btn btn-outline-primary" style="width: 120px;">Tìm kiếm</button>
                                    </form>
                                    <div>
                                        <a class="btn btn-info" href="{{ route('admin.vouchers.create') }}" style="width: 150px;">Thêm mới</a>
                                    </div>
                                </div>
                            </div>
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;"><input type="checkbox" id="checkboxesMain">
                                        </th>
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
                                            <tr id="tr_{{ $item->id }}">
                                                <td><input type="checkbox" class="checkbox" data-id="{{ $item->id }}">
                                                </td>
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}₫
                                                    @else
                                                        {{ number_format($item->discount, 0, '', '.') }}%
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch form-switch-info">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="SwitchCheck{{ $item->id }}"
                                                            {{ $item->status == 2 ? 'checked' : '' }}
                                                            onchange="updateStatus({{ $item->id }}, this.checked)">
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
    <script>
function updateStatus(voucherId, isChecked) {
    var status = isChecked ? 2 : 1;

    $.ajax({
        url: '{{ route('admin.vouchers.updateStatus') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: voucherId,
            status: status
        },
        success: function(response) {
            // Optionally, update some status text or notification here
            console.log(response.message); // Optionally log the response
            // You can display a message or visually highlight the row
            $('#tr_' + voucherId).addClass('updated');
        },
        error: function(xhr, status, error) {
            alert('An error occurred while updating the status.');
        }
    });
}

    </script>

@endsection
