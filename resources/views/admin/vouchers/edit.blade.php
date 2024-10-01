@extends('admin.layouts.master')

@section('title')
    {{$title}}
@endsection

@section('content')
    <form id="createproduct-form" method="POST" action="{{ route('admin.vouchers.update',[$find->id]) }}" autocomplete="off"
        class="needs-validation" novalidate>
        @method('PUT')
        @csrf
        <a class="btn btn-info" href="{{route('admin.vouchers.index')}}">Trở về</a>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Code</label>
                                    <input type="text" class="form-control" placeholder="Mã giảm giá..."
                                        id="meta-title-input" name="code" value="{{old('code') ?? $find->code}}">
                                        @error('code')
                                        <h5 style="color: red">{{$message}}</h5>
                                        @enderror
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-keywords-input">Tên mã giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Tên mã giảm giá..."
                                        id="meta-keywords-input" name="name" value="{{old('name') ?? $find->name}}">
                                        @error('name')
                                        <h5 style="color: red">{{$message}}</h5>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">loại giảm giá</label>
                                    <select class="form-select mb-3" aria-label="Default select example"
                                        name="discount_type">
                                        <option value="0">%</option>
                                        <option value="1">Đ</option>
                                    </select>
                                    @error('discount_type')
                                    <h5 style="color: red">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Trạng thái</label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="status">
                                        <option value="0">Hoạt động</option>
                                        <option value="1">Ngừng hoạt động</option>
                                    </select>
                                    @error('status')
                                    <h5 style="color: red">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Giá trị giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Nhập giá trị giảm giá"
                                        id="meta-title-input" name="discount" min="1000" value="{{old('discount') ?? $find->discount}}"> 
                                        @error('discount')
                                        <h5 style="color: red">{{$message}}</h5>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Số lượng</label>
                                    <input type="text" class="form-control" placeholder="Nhập số lượng..."
                                        id="meta-title-input" name="qty" min="1" value="{{old('qty') ?? $find->qty}}">
                                        @error('qty')
                                        <h5 style="color: red">{{$message}}</h5>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="start" value="{{old('start') ?? $find->start}}">
                                    @error('start')
                                    <h5 style="color: red">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="end" value="{{old('end') ?? $find->end}}">
                                    @error('end')
                                    <h5 style="color: red">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                </div>
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Submit</button>
                </div>
            </div>
        </div>
        <!-- end row -->

    </form>
@endsection
