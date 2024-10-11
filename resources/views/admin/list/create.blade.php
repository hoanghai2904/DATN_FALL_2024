@extends('admin.layouts.master')

@section('title')
    Thêm mới danh mục
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.categories.addPostCategory') }}" method="POST">


        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Tên danh mục</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên danh mục"
                                        name="name" id="categoryName">

                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control  text-light" style="background-color: #4b4e51"
                                        placeholder="Slug sẽ tự được sinh ra khi nhập tên" name="slug" id="categorySlug"
                                        readonly>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <div>
                            <label class="form-label">Danh mục cha</label>
                            <select class="form-control" name="parent_id" rows="3">
                                @foreach ($category->unique('parent_id') as $value)
                                    <option>{{ $value->parent_id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- end card -->





                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                </div>
            </div>
            <!-- end col -->


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
