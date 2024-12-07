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
                                    <label class="form-label" for="name-input">Tên mã giảm giá</label>
                                    <input type="text" class="form-control" placeholder="Tên mã giảm giá..."
                                        id="name-input" name="name" value="{{old('name')}}" oninput="generateCode()">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="code-input">Code</label>
                                    <input type="text" class="form-control" placeholder="Mã giảm giá..."
                                        id="code-input" name="code" value="{{old('code')}}" readonly>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Loại giảm giá</label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="discount_type">
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
<<<<<<< HEAD
                                        <option value="2">Hoạt động</option>
                                        <option value="1">Ngừng hoạt động</option>
=======
                                        <option value="" disabled {{ old('status', isset($voucher) ? $voucher->status : '') == '' ? 'selected' : '' }}>Chọn loại trạng thái</option>
                                        <option value="2" {{ old('status', isset($voucher) ? $voucher->status : '') == '2' ? 'selected' : '' }}>Hoạt Động</option>
                                        <option value="1" {{ old('status', isset($voucher) ? $voucher->status : '') == '1' ? 'selected' : '' }}>Ngưng</option>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Giá trị giảm giá</label>
                                    <input type="number" class="form-control" id="numberInput" name="discount" 
                                           placeholder="Nhập giá trị giảm giá" 
                                           value="{{ old('discount') }}" 
                                           min="1000" oninput="formatNumber(this)">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Số lần sử dụng</label>
                                    <input type="number" class="form-control" id="numberInput" name="max_uses" 
                                           placeholder="Nhập giá trị giảm giá" 
                                           value="{{ old('discount') }}" 
                                           min="1000" oninput="formatNumber(this)">
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
                                    <input type="datetime-local" class="form-control" id="start-date" name="start" value="{{old('start')}}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Ngày kết thúc</label>
                                    <input type="datetime-local" class="form-control" id="end-date" name="end" value="{{old('end')}}">
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
@push('script')
    <script>
        function generateCode() {
            const nameInput = document.getElementById('name-input').value;
            const codeInput = document.getElementById('code-input');

            // Get the current date
            const now = new Date();
            const day = String(now.getDate()).padStart(2, '0'); // Get the day
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Get the month (0-indexed)

            // Extract the first letter of each word from the name input
            const firstLetters = nameInput
                .split(' ')
                .map(word => word.charAt(0).toUpperCase()) // Get the first letter and convert to uppercase
                .join(''); // Join them without spaces

            // Generate a code based on the first letters and the current day and month
            if (firstLetters) {
                const code = `${firstLetters}-${month}${day}`;
                codeInput.value = code;
            } else {
                codeInput.value = '';
            }
        }
    </script>
    @endpush
@endsection
