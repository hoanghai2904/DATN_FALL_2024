@extends('admin.layouts.master')

@section('title')
    Danh mục bài viết
@endsection

@section('content')
    <style>
        .custom-input {
            width: 400px;
        }
    </style>

    <div class="d-flex justify-content-between mb-3">

        <div class="d-flex align-items-center">
            <a href="{{ route('admin.postcategories.addPostCategory') }}" class="btn btn-primary me-2">Thêm Mới</a>
            <input type="text" id="categorySearchBox" class="form-control custom-input" placeholder="Tìm kiếm danh mục...">
        </div>

        <!-- Bộ lọc theo trạng thái -->
        <form action="{{ route('admin.postcategories.listPostCategory') }}" method="GET" class="d-flex">
            <select class="form-select me-2" name="status">
                <option value="0">Tất cả trạng thái</option>
                <option value="1" {{ $selectedStatus == '1' ? 'selected' : '' }}>Đang Hoạt Động</option>
                <option value="2" {{ $selectedStatus == '2' ? 'selected' : '' }}>Tạm Dừng</option>
            </select>

            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>


    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="categoryTable" class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Tên Danh Mục</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>



                                <tbody>
                                    @foreach ($postcategories as $key => $value)
                                        <tr>
                                            <td>{{ $postcategories->firstItem() + $key }}</td>
                                            <td>{{ $value->name }}</td>
                                            {{-- <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-success">Đang Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm Dừng</span>
                                                @endif
                                            </td> --}}

                                            <td>
                                                @if ($value->status == 1)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $value->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $value->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif

                                            </td>


                                            <td class="text-center">
                                                <div class="d-flex justify-content-center align-items-center"
                                                    style="gap: 5px;">
                                                    <a href="{{ route('admin.postcategories.updateCategory', $value->id) }}"
                                                        class="btn btn-sm btn-warning d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px; padding: 0; border: none;">
                                                        <i data-feather="edit-3" style="width: 16px; height: 16px;"></i>
                                                    </a>

                                                    @if ($value->status == 1)
                                                        <!-- Chỉ hiển thị khi trạng thái là 1 -->
                                                        <form
                                                            action="{{ route('admin.postcategories.deletePostCategory', $value->id) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            @method('delete')
                                                            <button
                                                                onclick="return confirm('Bạn có muốn chuyển trạng thái danh mục về \'Tạm Dừng\' không?')"
                                                                class="btn btn-sm btn-danger d-flex align-items-center justify-content-center"
                                                                style="width: 30px; height: 30px; padding: 0; border: none;">
                                                                <i data-feather="trash-2"
                                                                    style="width: 16px; height: 16px;"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- <a class="btn btn-sm btn-info d-flex align-items-center justify-content-center"
                                                        style="width: 30px; height: 30px; padding: 0; border: none;"
                                                        title="Xem Chi Tiết">
                                                        <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                                    </a> --}}

                                                    @if ($value->status == 0)
                                                        <form
                                                            action="{{ route('admin.postcategories.restorePostCategory', $value->id) }}"
                                                            method="post" class="d-inline">
                                                            @csrf
                                                            <button
                                                                onclick="return confirm('Bạn có muốn phục hồi danh mục này không?')"
                                                                class="btn btn-sm btn-info d-flex align-items-center justify-content-center"
                                                                style="width: 30px; height: 30px; padding: 0; border: none;">
                                                                <i data-feather="refresh-cw"
                                                                    style="width: 16px; height: 16px;"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ $postcategories->appends(['status' => $selectedStatus])->links('pagination::bootstrap-5') }}
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#categorySearchBox').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#categoryTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });
        });

        const notyf = new Notyf();
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');


                $.ajax({
                    // Thay route 
                    url: "{{ route('admin.postcategories.change-status') }}",
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
