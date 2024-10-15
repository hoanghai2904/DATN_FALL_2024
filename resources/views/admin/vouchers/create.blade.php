@extends('admin.layouts.master')

@section('title')
    {{$title}}
@endsection

@section('content')
    <form id="createproduct-form" method="POST" action="{{ route('admin.vouchers.store') }}" autocomplete="off"
        class="needs-validation" novalidate>
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
                                        id="meta-title-input" name="code" value="{{old('code')}}">
                                       
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-keywords-input">Tên mã giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Tên mã giảm giá..."
                                        id="meta-keywords-input" name="name" value="{{old('name')}}">
                                       
                                </div>
                            </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta-title-input">Loại giảm giá</label>
                                <select class="form-select mb-3" aria-label="Default select example" name="discount_type" id="discount_type">
                                    <option value="" disabled {{ old('discount_type', isset($voucher) ? $voucher->discount_type : '') == '' ? 'selected' : '' }}>Chọn loại giảm giá</option>
                                    <option value="0" {{ old('discount_type', isset($voucher) ? $voucher->discount_type : '') == '0' ? 'selected' : '' }}>%</option>
                                    <option value="1" {{ old('discount_type', isset($voucher) ? $voucher->discount_type : '') == '1' ? 'selected' : '' }}>Đ</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Trạng thái</label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="status">
                                        <option value="" disabled {{ old('status', isset($voucher) ? $voucher->status : '') == '' ? 'selected' : '' }}>Chọn loại giảm giá</option>
                                        <option value="2" {{ old('status', isset($voucher) ? $voucher->status : '') == '2' ? 'selected' : '' }}>Hoạt Động</option>
                                        <option value="1" {{ old('status', isset($voucher) ? $voucher->status : '') == '1' ? 'selected' : '' }}>Ngưng</option>
                                    </select>
                                   
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Giá trị giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Nhập giá trị giảm giá"
                                         id="numberInput" name="discount" min="1000" oninput="formatNumber(this)" value="{{old('discount')}}">
                                       
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Số lượng</label>
                                    <input type="text" class="form-control" placeholder="Nhập số lượng..."
                                    id="numberInput" name="qty" min="1" oninput="formatNumber(this)" value="{{old('qty')}}">
                                       
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày bắt đầu</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="start" value="{{old('start')}}">
                                   
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="meta-title-input" name="end" value="{{old('end')}}">
                                   
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
    <script>
        function formatNumber(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    </script>
@endsection
