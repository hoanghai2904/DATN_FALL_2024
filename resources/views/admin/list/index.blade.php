@extends('admin.layouts.master')

@section('title')
    danh mục
@endsection

@section('content')
    <style>
        .custom-input {
            width: 400px;
        }
    </style>

    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.categories.addCategory') }}" class="btn btn-primary me-2">Thêm Mới</a>
            <input type="text" id="categorySearchBox" class="form-control custom-input" placeholder="Tìm kiếm danh mục...">
        </div>

        <!-- Bộ lọc theo trạng thái -->
        <form action="{{ route('admin.categories.listCategory') }}" method="GET" class="d-flex">
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
                                        <th scope="col">Danh Mục Cha</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @foreach ($categories as $key => $value)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $key }}</td>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->parent ? $value->parent->name : 'Không có' }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-success">Đang Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm Dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.categories.updateCategory', $value->id) }}"
                                                    class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                                <form action="{{ route('admin.categories.deleteCategory', $value->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        onclick="return confirm('Bạn có muốn chuyển trạng thái danh mục về \'Tạm Dừng\' không?')"
                                                        class="btn btn-sm btn-danger">Tạm dừng</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
                                <tbody>
                                    @foreach ($categories as $key => $value)
                                        <tr>
                                            <td>{{ $categories->firstItem() + $key }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->parent ? $value->parent->name : 'Không có' }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-success">Đang Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm Dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.categories.updateCategory', $value->id) }}"
                                                    class="btn btn-sm btn-warning">Chỉnh sửa</a>
                                                <form action="{{ route('admin.categories.deleteCategory', $value->id) }}"
                                                    method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        onclick="return confirm('Bạn có muốn chuyển trạng thái danh mục về \'Tạm Dừng\' không?')"
                                                        class="btn btn-sm btn-danger">Tạm dừng</button>
                                                </form>
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
    {{-- {{ $categories->links('pagination::bootstrap-5') }} --}}
    {{ $categories->appends(['status' => $selectedStatus])->links('pagination::bootstrap-5') }}
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Tìm kiếm danh mục
            $('#categorySearchBox').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#categoryTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(3)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });
        });
    </script>
@endpush
