@extends('admin.layouts.master')

@section('title')
    danh mục mã giảm giá
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
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
                                            <option value="" disabled selected>Chọn trạng thái</option>
                                            <option value="2" >Hoạt động</option>
                                            <option value="1" >Ngừng hoạt động</option>
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
                                        <th scope="col">ID</th>
                                        <th scope="col">Mã</th>
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
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->code }}</td>
                                                <td><a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                    >{{ $item->name }}</a></td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}₫
                                                    @else
                                                        {{ number_format($item->discount, 0, '', '.') }}%
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 2)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $item->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $item->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif
                                                </td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->start }}</td>
                                                <td>{{ $item->end }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                        class="btn btn-sm btn-warning sm-2">Sửa</a>
                                                        <a href="{{ route('admin.vouchers.destroy', $item->id) }}"
                                                            class="btn btn-sm btn-danger delete-item">Xóa</a>
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


@endsection
@push('script')

<script>
    const notyf = new Notyf();
    $(document).ready(function() {
        $('body').on('click', '.change-status', function() {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');
            console.log(isChecked, id);


            $.ajax({
                url: "{{ route('admin.vouchers.updateStatus') }}",
                method: 'PUT',
                data: {
                    status: isChecked,
                    id: id
                },
                success: function(data) {
                    // toastr.success(data.message)
                    notyf.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })

        })
    })

</script>
@endpush