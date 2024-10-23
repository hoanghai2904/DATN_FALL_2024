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
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Tiêu đề</label>
                                    <input type="text" class="form-control" placeholder="Tiêu đề..."
                                        id="meta-title-input" name="title" value="{{old('title')}}">
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-keywords-input">Tên tác giả</label>
                                    <input type="text" class="form-control" placeholder="Tên tác giả..." 
                                           id="meta-keywords-input" value="{{ Auth::user()->full_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="image-input">Ảnh Bìa bài viết </label>
                                    <input type="file" class="form-control" name="thumbnail">
                                    @error('thumbnail')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <!-- Hidden field to store user_id -->
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">                            
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Trạng thái</label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="status">
                                        <option value="" disabled {{ old('status', isset($post) ? $post->status : '') == '' ? 'selected' : '' }}>Chọn trạng thái</option>
                                        <option value="2" {{ old('status', isset($post) ? $post->status : '') == '2' ? 'selected' : '' }}>Public</option>
                                        <option value="1" {{ old('status', isset($post) ? $post->status : '') == '1' ? 'selected' : '' }}>Private</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-title-input">Danh mục</label>
                                    <select class="form-control js-example-basic-single select2-hidden-accessible" aria-label="Default select example" name="category_id">
                                        <option value="" disabled {{ old('category_id', isset($post) ? $post->category_id : '') == '' ? 'selected' : '' }}>Danh mục</option>
                                        @foreach ($allCate as $key => $item)
                                            <option value="{{ $item->id }}" {{ old('category_id', isset($post) ? $post->category_id : '') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
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
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/ecommerce-product-create.init.js') }}"></script>
@endsection
