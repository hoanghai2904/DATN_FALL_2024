@extends('admin.layouts.master')

@section('title')
    Cập nhật
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.postcategories.updatePutCategory', $category->id) }}"
        method="POST">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @csrf
        @method('put')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Tên Danh Mục -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục"
                                        name="name" id="categoryName" value="{{ $category->name }}">
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="text-end mb-3">
                                <a href="{{ route('admin.postcategories.listPostCategory') }}" type="button"
                                    class="btn btn-danger w-sm">Quay
                                    lại</a>
                                <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end row -->

    </form>
    <script>
        function slugify(text) {
            // Bỏ dấu tiếng Việt
            text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
            // Tạo slug
            return text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        }

        document.getElementById('categoryName').addEventListener('input', function() {
            let name = this.value;
            let slug = slugify(name);
            document.getElementById('categorySlug').value = slug;
        });
    </script>
@endsection
