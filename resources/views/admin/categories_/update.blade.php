@extends('admin.layouts.master')

@section('title')
    Cập nhật danh mục
@endsection

@section('style-libs')
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.categories_.update', $category->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục"
                                        name="name" value="{{ $category->name }}" id="categoryName">
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="category_status">Trạng thái</label>
                                <select name="status" id="category_status" class="form-select">
                                    <option {{ $category->status == 0 ? 'selected' : '' }} value="0">Ẩn</option>
                                    <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Kích hoạt</option>
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
                                @foreach ($categories as $category)
                                    <div class="form-check"
                                        style="margin-left: {{ $category->parent_id ? '20px' : '0px' }};">
                                        <input type="checkbox" class="form-check-input"  id="category{{ $category->id }}"
                                            name="parent_id[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="category{{ $category->id }}">{{ $category->name }}</label>
                                    </div>
                                    @if ($category->children->isNotEmpty())
                                        @include('admin.categories_.components.children', [
                                            'categories' => $category->children,
                                            'selectedCategories' => $selectedCategories,
                                        ])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </form>
@endsection

