@extends('admin.layouts.master')

@section('title')
    danh mục
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title') đang hoạt động</h4>
                </div>
                <!-- end card header -->

                <div class="card-body">
                    {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}

                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>

                                        <th scope="col">STT</th>

                                        <th scope="col">ID</th>
                                        <th scope="col">Tên Danh Mục</th>
                                        <th scope="col"> Danh Mục Cha</th>

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
                                            <td>{{ $value->parent_id }}</td>

                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-success">Đang Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm Dừng</span>
                                                @endif

                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-info">Details</button>
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
                    {{-- <p class="text-muted mb-4">Use .<code>table-striped-columns</code> to add zebra-striping to any table column.</p> --}}

                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">STT</th>

                                        <th scope="col">ID</th>
                                        <th scope="col">Tên Danh Mục</th>
                                        <th scope="col"> Danh Mục Cha</th>

                                        <th scope="col">Trạng Thái</th>

                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inactiveCategories as $key => $value)
                                        <tr>
                                            <td>{{ $activeCategories->firstItem() + $key }}</td>


                                            <td>{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->parent_id }}</td>

                                            <td>
                                                @if ($value->status == 1)
                                                    <span class="badge bg-success">Đang Hoạt Động</span>
                                                @else
                                                    <span class="badge bg-danger">Tạm Dừng</span>
                                                @endif

                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-info">Details</button>
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
