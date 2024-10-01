@extends('admin.layouts.master')

@section('title')
    Sửa Banner
@endsection

@section('content')
<form id="editbanner-form" action="{{ route('admin.banners.updatePutBanner', $banner->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off" class="needs-validation" novalidate>
    @csrf <!-- Add CSRF token for security -->
    @method('PUT')
    
    <div class="row">
        @if (session('message'))
        <p class="text-danger">{{ session('message') }}</p>
    @endif
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="image-input"> Banner</label>
                                <input type="file" class="form-control" name="banner" id="banner">
                                @error('banner')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label" for="url">URL</label>
                                <input type="url" class="form-control" placeholder="Nhập URL của banner" name="url" id="url" value="{{ $banner->url }}" required>
                                @error('url')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="form-group">
                        <label for="inputState">Trạng Thái</label>
                        <select id="inputState" class="form-control" name="status" required>
                            <option value="" disabled selected>Chọn trạng thái</option>
                            <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                            @error('status')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn trạng thái.</div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end card -->

            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
            </div>
        </div>
    </div>
    <!-- end row -->

</form>
@endsection
