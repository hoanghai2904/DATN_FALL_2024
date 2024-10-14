@extends('admin.layouts.master')

@section('title')
@endsection

@section('content')
    <form id="createproduct-form" method="POST" action="{{ route('admin.posts.store') }}" autocomplete="off"
        class="needs-validation" novalidate>
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
                                        id="meta-title-input" name="title" value="{{old('title') ?? $find->title}}" disabled>
                                        @error('title')
                                        <h5 style="color: red">{{$message}}</h5>
                                        @enderror
                                </div>
                            </div>
                            <!-- end col -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta-keywords-input">Tên tác giả</label>
                                    <input type="text" class="form-control" placeholder="Tên tác giả..." 
                                           id="meta-keywords-input" value="{{ old('user_id') ?? $find->user->full_name }}" disabled>
                                    @error('user_id')
                                    <h5 style="color: red">{{ $message }}</h5>
                                    @enderror
                                </div>
                            </div>   
                        <div class="collapse show" id="content">
                            <div class="card-body">
                                <div class="mb-3">
                                    <textarea id="ckeditor-classic" name="body">{{$find->body}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </form>
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#ckeditor-classic'))
            .then(editor => {
                editor.enableReadOnlyMode('#ckeditor-classic'); // Chuyển CKEditor sang chế độ chỉ đọc
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
