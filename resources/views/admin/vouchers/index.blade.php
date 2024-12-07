@extends('admin.layouts.master')

@section('title')
    danh mục mã giảm giá
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
<<<<<<< HEAD
            @if (session('msg'))
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endif
=======
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
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
<<<<<<< HEAD
                                            <option value="">Trạng thái</option>
                                            <option value="2">Hoạt động</option>
                                            <option value="1">Ngừng hoạt động</option>
=======
                                            <option value="" disabled selected>Chọn trạng thái</option>
                                            <option value="2" >Hoạt động</option>
                                            <option value="1" >Ngừng hoạt động</option>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
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
<<<<<<< HEAD
                                        <th scope="col" style="width: 46px;"><input type="checkbox" id="checkboxesMain">
                                        </th>
=======
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
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
<<<<<<< HEAD
                                                <td><input type="checkbox" class="checkbox" data-id="{{ $item->id }}">
                                                </td>
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->code }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}Đ
=======
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->code }}</td>
                                                <td><a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
                                                    >{{ $item->name }}</a></td>
                                                <td>
                                                    @if ($item->discount_type != '0')
                                                        {{ number_format($item->discount, 0, '', '.') }}₫
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                                    @else
                                                        {{ number_format($item->discount, 0, '', '.') }}%
                                                    @endif
                                                </td>
                                                <td>
<<<<<<< HEAD
                                                    <div class="form-check form-switch form-switch-info">
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            id="SwitchCheck{{ $item->id }}"
                                                            {{ $item->status == 2 ? 'checked' : '' }}
                                                            onchange="updateStatus({{ $item->id }}, this.checked)">
                                                    </div>
=======
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
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                                </td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ $item->start }}</td>
                                                <td>{{ $item->end }}</td>
                                                <td>
                                                    <a href="{{ route('admin.vouchers.edit', [$item->id]) }}"
<<<<<<< HEAD
                                                        class="btn btn-warning sm-2">Sửa</a>

                                                    <form action="{{ route('admin.vouchers.destroy', $item->id) }}"
                                                        method="post" style="display:inline;">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button href="" type="submit"
                                                            onclick="return confirm('Có chắc muốn xóa?')"
                                                            class="btn btn-danger">Xóa</button>
                                                    </form>
=======
                                                        class="btn btn-sm btn-info"><i
                                                        class=" ri-edit-box-line"></i></a>
                                                        <a href="{{ route('admin.vouchers.destroy', $item->id) }}"
                                                            class="btn btn-sm btn-danger delete-item"><i class=" ri-delete-bin-line"></i></a>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
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
<<<<<<< HEAD
    <script>
        function updateStatus(voucherId, isChecked) {
            var status = isChecked ? 2 : 1;

            $.ajax({
                url: '{{ route('admin.vouchers.updateStatus') }}', // Corrected route with 'admin.' prefix
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Laravel's CSRF token
                    id: voucherId,
                    status: status
                },
                success: function() {
                    location.reload(); // Reload the page after success
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while updating the status.');
                }
            });
        }
    </script>
=======

>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc

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