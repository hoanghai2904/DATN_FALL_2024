@extends('admin.layouts.master')

@section('title')
    {{$title}}
@endsection

@section('content')
    <form id="createproduct-form" method="POST" action="{{ route('admin.posts.store') }}" autocomplete="off"
        class="needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <a class="btn btn-info" href="{{route('admin.posts.index')}}">Trở về</a>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Tiêu đề</label>
                                    <input type="text" class="form-control" placeholder="Tiêu đề..."
                                        id="meta-title-input" name="title" value="{{old('title')}}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meta-keywords-input">Tên tác giả</label>
                                    <input type="text" class="form-control" placeholder="Tên tác giả..." 
                                           id="meta-keywords-input" value="{{ Auth::user()->full_name }}" disabled>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">                            
                                
                                        </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Trạng thái</label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="status">
                                        <option value="" disabled {{ old('status', isset($post) ? $post->status : '') == '' ? 'selected' : '' }}>Chọn trạng thái</option>
                                        <option value="2" {{ old('status', isset($post) ? $post->status : '') == '2' ? 'selected' : '' }}>Public</option>
                                        <option value="1" {{ old('status', isset($post) ? $post->status : '') == '1' ? 'selected' : '' }}>Private</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Mô tả ngắn</label>
                                    <textarea name="description" class="form-control" id="" rows="10"></textarea>
                                </div>
                                <div class="card">
                                    <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer" data-bs-target="#content"
                                        aria-expanded="true" aria-controls="content">
                                        <h5 class="card-title mb-0">Nội dung</h5>
                                    </div>
                                    <div class="collapse show" id="content">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <textarea id="ckeditor-classic" name="body" >{{old('body')}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-4">
                                <div class="container mt-5">
                                    <div class="card">
                                        <div class="card-header" data-bs-toggle="collapse" style="cursor:pointer"
                                            data-bs-target="#thumbnails" aria-expanded="true" aria-controls="thumbnails">
                                            <h5 class="card-title mb-0">Ảnh bìa bài viết</h5>
                                        </div>
                                        <div class="collapse show" id="thumbnails">
                                            <div class="card-body">
                                                <div id="addImageButton" class="text-center mt-3">
                                                    <span class="text-primary">Nhấn vào đây để thêm hình ảnh</span>
                                                </div>
                                                <input type="file" id="imageInput" name="thumbnail" accept="image/*" class="d-none" multiple>
                                                <div id="imagePreviewContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Hidden field to store user_id -->
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Danh mục</label>
                                    <select class="form-control js-example-basic-single select2-hidden-accessible" aria-label="Default select example" name="category_id">
                                        <option value="" disabled {{ old('category_id', isset($post) ? $post->category_id : '') == '' ? 'selected' : '' }}>Danh mục</option>
                                        @foreach ($allCate as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('category_id', isset($post) ? $post->category_id : '') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
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
    <style>
        #imagePreviewContainer {
            display: flex;
            flex-wrap: wrap;
        }
        .image-wrapper {
            position: relative;
            display: inline-block; /* Căn chỉnh ảnh trong hàng */
            margin: 5px;
        }
        .image-wrapper img {
            width: 100px; /* Kích thước ảnh xem trước */
            height: 100px; /* Đảm bảo hình vuông */
            border-radius: 10px; /* Bo góc cho ảnh */
            object-fit: cover; /* Đảm bảo ảnh không bị méo */
        }
        .delete-btn {
            position: absolute;
            top: 5px;   /* Đặt ở phía trên */
            right: 5px; /* Đặt ở bên phải */
            color: black;
            border: none;
            cursor: pointer;
            border-radius: 50%;
            padding: 2px 5px;
            font-size: 12px;
            z-index: 1; /* Đảm bảo nút x nằm trên cùng */
        }
        #addImageButton {
            cursor: pointer;
            border: 2px dashed #007bff; 
            padding: 20px; 
            border-radius: 5px;
            text-align: center;
        }
    </style>
    @push('script') <!-- Corrected from 'scrip' to 'script' -->
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
    <script>
        document.getElementById('addImageButton').onclick = function () {
            document.getElementById('imageInput').click();
        };

        document.getElementById('imageInput').onchange = function (event) {
            const files = event.target.files;
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = ''; // Xóa các ảnh trước đó

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'image-wrapper'; // Thêm lớp cho khung ảnh

                    const img = document.createElement('img');
                    img.src = e.target.result;

                    const deleteBtn = document.createElement('button');
                    deleteBtn.innerHTML = '&times;'; // Dấu x (để xóa)
                    deleteBtn.className = 'delete-btn';
                    deleteBtn.onclick = function () {
                        imgWrapper.remove(); // Xóa ảnh và nút
                    };

                    imgWrapper.appendChild(img);
                    imgWrapper.appendChild(deleteBtn); // Đặt nút xóa sau ảnh
                    imagePreviewContainer.appendChild(imgWrapper);
                };

                reader.readAsDataURL(file);
            }
        };
    </script>
    
    @endpush
@endsection
