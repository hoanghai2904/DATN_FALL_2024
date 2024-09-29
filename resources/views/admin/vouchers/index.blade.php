@extends('admin.layouts.master')

@section('title')
    danh mục
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12">
            @if (session('msg'))
            <div class="alert alert-success">{{session('msg')}}</div>
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
                <button class="btn btn-info" ><a href="{{route('admin.vouchers.create')}}">them</a></button>
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Tên mã giảm giá</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Ngày bắt đầu</th>
                                        <th scope="col">Ngày kết thúc</th>
                                        <th scope="col" style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                @foreach ($list as $key => $item)
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck01">
                                                <label class="form-check-label" for="cardtableCheck01"></label>
                                            </div>
                                        </td>
                                            
                                        <td><a href="#" class="fw-medium">{{$key +1}}</a></td>
                                        <td>{{$item->code}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if ($item->discount_type != '0')
                                            {{$item->discount}}Đ
                                            @else
                                            {{$item->discount}}%
                                            @endif
                                        </td>
                                        <td><a href="vouchers/{{$item->id}}" class="btn btn-sm btn-{{$item->status ? 'danger' : 'success'}}">
                                            {{$item->status ? 'Không hoạt động' : 'Hoạt động'}}
                                        </a></td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->start}}</td>
                                        <td>{{$item->end}}</td>
                                    </tr>
                                </tbody>
                                @endforeach

                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
<!-- end row -->

@endsection
