@extends('admin.layouts.master')

@section('title')
    Thêm mới danh mục
@endsection

@section('style-libs')
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.categories_.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục"
                                        name="name" id="categoryName">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="category_status">Trạng thái</label>
                                <select name="status" id="category_status" class="form-select">
                                    <option value="0">Ẩn</option>
                                    <option value="1" selected>Kích hoạt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Danh mục</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div style="max-height: 300px; overflow-y: auto;">
                                @include('admin.categories_.components.children', [
                                    'categories' => $categories,
                                ])
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.category-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Lấy danh sách id của các checkbox con từ thuộc tính data-children
                    const childrenIds = JSON.parse(this.getAttribute('data-children')) || [];

                    // Tìm các checkbox con và chọn hoặc bỏ chọn chúng dựa trên trạng thái của checkbox cha
                    childrenIds.forEach(childId => {
                        const childCheckbox = document.getElementById('category' + childId);
                        if (childCheckbox) {
                            childCheckbox.checked = this.checked;
                        }
                    });
                });
            });
        });
    </script>
@endpush
