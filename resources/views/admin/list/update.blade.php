@extends('admin.layouts.master')

@section('title')
    Cập nhật
@endsection

@section('content')
    <form class="needs-validation" action="{{ route('admin.categories.updatePutCategory', $category->id) }}" method="POST">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @csrf
        @method('put')
        {{-- <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
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
                            <!-- end col -->

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control  text-light" style="background-color: #4b4e51"
                                        placeholder="Slug sẽ tự được sinh ra khi nhập tên" name="slug" id="categorySlug"
                                        value="{{ $category->slug }}" readonly>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="mb-3 col-lg-6 mr-3">
                            <label class="form-label">Danh mục cha</label>
                            <select class="form-control" name="parent_id">
                                @foreach ($categories as $value)
                                    <option value="{{ $value->id }}"
                                        {{ $category->parent_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- end card -->

                <!-- end card -->

                <div class="text-end mb-3">
                    <button onclick="history.back()" type="button" class="btn btn-danger w-sm">Quay lại</button>

                    <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                </div>
            </div>

            <!-- end col -->
        </div> --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Row for Tên Danh Mục and Slug -->
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

                            <!-- Slug -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Slug</label>
                                    <input type="text" class="form-control text-light" style="background-color: #4b4e51"
                                        placeholder="Slug sẽ tự được sinh ra khi nhập tên" name="slug" id="categorySlug"
                                        value="{{ $category->slug }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Row for Danh mục cha -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Danh mục cha</label>
                                    <select class="form-control" name="parent_id">
                                        @foreach ($categories as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $category->parent_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Button Row -->
                        <div class="text-end mb-3">
                            <a href="{{ route('admin.categories.listCategory') }}" type="button" class="btn btn-danger w-sm">Quay
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
