@extends('admin.layouts.master')

@section('title')
    Chi tiết banner
@endsection

@section('content')
<div class="container">
    <div class="p-4" style="min-height: 800px;">
        <h3 class="text-center">Chi Tiết Banner</h3>

        <p>
            <strong>Ảnh Banner:</strong>
            <br>
            <img src="{{ Storage::url($banner->banner) }}" alt="" class="img-banner" width="350px">
        </p>
        <p>
            <strong>URL:</strong> 
            <a href="{{ $banner->url }}" target="_blank">{{ $banner->url }}</a>
        </p>

        <p>
            <strong>Trạng thái:</strong> {{ $banner->status ? 'Đang hoạt động' : 'Không hoạt động' }}
        </p>
        <div class="text-center">
            <a href="{{ route('admin.banners.listBanner') }}" class="btn btn-info mt-3">Quay lại</a>
        </div>
    </div>
</div>

@endsection
