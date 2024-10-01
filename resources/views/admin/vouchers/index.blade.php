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
            @if (session('msg_warning'))
            <div class="alert alert-danger">{{session('msg_warning')}}</div>
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
                <a class="btn btn-info" href="{{route('admin.vouchers.create')}}">them</a>
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;"></th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Tên mã giảm giá</th>
                                        <th scope="col">Discount</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Ngày bắt đầu</th>
                                        <th scope="col">Ngày kết thúc</th>
                                        <th scope="col" style="">Action</th>
                                    </tr>
                                </thead>
                                @if(!empty($list))
                                @foreach ($list as $key => $item)
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="select_all_ids">
                                                <label class="form-check-label" for="select_all_ids"></label>
                                            </div>
                                        </td>
                                            
                                        <td><a href="#" class="fw-medium">{{$key +1}}</a></td>
                                        <td>{{$item->code}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if ($item->discount_type != '0')
                                            {{number_format($item->discount, 0, '', '.')}}Đ
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
                                        <td><a href="{{route('admin.vouchers.edit',[$item->id])}}" class="btn btn-warning sm-2">Sửa</a></td>
                                        <td><form action="{{route('admin.vouchers.destroy',$item->id)}}" method="post">
                                                @method('DELETE')
                                                @csrf
                                            <button href="" type="submit" onclick="return confirm('Có chắc muốn xóa?')" class="btn btn-danger">Xóa</button>
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
                                {{$list->links()}}
                              </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
<!-- end row -->
@endsection
