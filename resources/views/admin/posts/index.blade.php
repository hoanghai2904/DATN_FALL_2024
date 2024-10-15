@extends('admin.layouts.master')

@section('title')
    bài viết
@endsection

@section('style-libs')
    <style>
        td.break-word {
            width: 250px;
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        th.no-sort::after,
        th.no-sort::before {
            display: none !important;
            /* Ẩn icon sắp xếp cột checkbox */
        }
    </style>
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
                                        <input type="search" name="keywords" id="customSearchBox"  class="form-control me-3" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request()->keywords }}" style="width: 300px;">
                                        <button type="submit" class="btn btn-outline-primary" style="width: 120px;">Tìm kiếm</button>
                                    </form>
                                    <div>
                                        <a class="btn btn-info" href="{{ route('admin.posts.create') }}" style="width: 150px;">Thêm mới</a>
                                    </div>
                                </div>
                            </div>
                            <table id="myTable2" class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tác giả</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Ngày viết</th>
                                        <th scope="col" style="">Hành động</th>
                                    </tr>
                                </thead>
                                @if (!empty($list))
                                    @foreach ($list as $key => $item)
                                        <tbody>
                                            <tr id="tr_{{ $item->id }}">
                                                <td><a href="#" class="fw-medium">{{ $key + 1 }}</a></td>
                                                <td>{{ $item->User ? $item->User->full_name : 'Không tên tác giả' }}</td>
                                                <td> <a href="{{ route('admin.posts.edit', [$item->id]) }}">{{ $item->title }}</a></td>
                                                <td>{{ $item->Category ? $item->Category->name : 'Không có danh mục' }}</td>
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
                                                <td>{{$item->created_at}}</td>
                                                <td>
                                                    <a href="{{ route('admin.posts.edit', [$item->id]) }}"
                                                        class="btn btn-sm btn-warning sm-2">Sửa</a>
                                                        <a href="{{ route('admin.posts.destroy', $item->id) }}"
                                                            class="btn btn-sm btn-danger delete-item">Xóa</a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="text-center">Không có bài viết nào</td>
                                    </tr>
                                @endif
                            </table>
                            <div class="float-right">
                                {{-- {{ $list->links() }} --}}
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
    $(document).ready(function() {
    
     var table = $('#myTable2').DataTable({
            "dom": '<"top">rt<"bottom"><"clear">',
            // "searching": false,
            "columnDefs": [{
                "orderable": false,
            }],
            "language": {
                "emptyTable": "Không có dữ liệu phù hợp", // Thay đổi thông báo không có dữ liệu
                "zeroRecords": "Không tìm thấy bản ghi nào phù hợp", // Thay đổi thông báo không có bản ghi tìm thấy
                "infoEmpty": "Không có bản ghi để hiển thị", // Thông báo khi không có dữ liệu để hiển thị
            }
        });

        $('#customSearchBox').on('keyup', function() {
            table.search(this.value).draw(); // Áp dụng tìm kiếm trên bảng
        });
    })
    const notyf = new Notyf();
    $(document).ready(function() {
        $('body').on('click', '.change-status', function() {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');
            console.log(isChecked, id);
            $.ajax({
                url: "{{ route('admin.posts.updateStatus') }}",
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
