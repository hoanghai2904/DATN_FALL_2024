@extends('admin.layouts.master')

@section('title')
    danh mục
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('admin.categories.addCategory') }}" class="btn btn-primary">Thêm Mới</a>
        <input type="text" id="categorySearchBox" class="form-control w-50" placeholder="Tìm kiếm danh mục...">
    </div>

    <div class="row">
        @if (Session::has('message'))
            <script>
                toastr.success("{{ Session::get('message') }}");
            </script>
        @endif

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title') đang hoạt động</h4>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="activeCategoryTable"
                                class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tên Danh Mục</th>
                                        <th scope="col">Danh Mục Cha</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activeCategories as $key => $value)
                                        <tr>
                                            <td>{{ $activeCategories->firstItem() + $key }}</td>
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
                                                    type="button" class="btn btn-sm btn-warning">Chỉnh sửa</a>
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
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    {{ $activeCategories->links('pagination::bootstrap-5') }}

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title') đang tạm dừng hoạt động</h4>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table id="inactiveCategoryTable"
                                class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Tên Danh Mục</th>
                                        <th scope="col">Danh Mục Cha</th>
                                        <th scope="col">Trạng Thái</th>
                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inactiveCategories as $key => $value)
                                        <tr>
                                            <td>{{ $inactiveCategories->firstItem() + $key }}</td>
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
                                                <form action="{{ route('admin.categories.restoreCategory', $value->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <button
                                                        onclick="return confirm('Bạn có muốn khôi phục danh mục không?')"
                                                        class="btn btn-sm btn-danger">Khôi phục</button>
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
    {{ $inactiveCategories->links('pagination::bootstrap-5') }}

    <!-- end row -->
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Tìm kiếm danh mục
            $('#categorySearchBox').on('keyup', function() {
                var value = $(this).val().toLowerCase();

                // Tìm kiếm trong danh sách đang hoạt động
                $('#activeCategoryTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(3)').text().toLowerCase().indexOf(
                        value) > -1);
                });

                // Tìm kiếm trong danh sách tạm dừng
                $('#inactiveCategoryTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(3)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });
        });
    </script>
@endpush
