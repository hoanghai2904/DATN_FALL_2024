@extends('admin.layouts.master')

@section('title')
    Banner
@endsection
@push('style')
<style>
    #bannerCarousel {
        max-width: 100%; /* Adjust the width to your preference */
      
    }
    #bannerCarousel img {
        max-height: 400px; /* Adjust the height to your preference */
        object-fit: fill; /* Ensures the images fit within the container without distortion */
    }
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <a href="{{ route('admin.banners.addBanner') }}">
                <button class="btn btn-success">Thêm mới</button>
            </a>
            <br>
            <br>
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Danh sách @yield('title')</h4>
                </div>
                @if (session('message'))
                <div class="alert alert-info" role="alert">
                    {{ session('message') }}
                </div>
            @endif
                <!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 46px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="cardtableCheck">
                                                <label class="form-check-label" for="cardtableCheck"></label>
                                            </div>
                                        </th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Liên Kết</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col" style="width: 150px;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($listBanner as $item => $value)
                                        <tr>
                                            
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="itemCheck{{ $item }}">
                                                    <label class="form-check-label" for="itemCheck{{ $item }}"></label>
                                                </div>
                                            </td>
                                            <td>{{ $item + 1 }}</td>
                                            <td class="text-center"> <!-- Thêm text-center để căn giữa hình ảnh -->
                                                <img src="{{ Storage::url($value->banner) }}" alt="" width="250px" height="100px">
                                            </td>
                                            <td><a href="{{ $value->url }}" target="_blank">Đường Link</a></td>
                                            <td>
                                                <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                    <input type="checkbox" class="form-check-input" id="customSwitch{{ $value->id }}" 
                                                           {{ $value->status ? 'checked' : '' }} onchange="toggleStatus({{ $value->id }})">
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <a href="{{ route('admin.banners.detailBanner', $value->id) }}" class="btn btn-info btn-sm">Chi tiết</a>
                                                <a href="{{ route('admin.banners.updateBanner', $value->id) }}" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                                <form action="{{ route('admin.banners.deleteBanner', $value->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có muốn xóa không?')">
                                                        Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- end card-body -->
                
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->
    {{-- <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">Trình chiếu Banner</h4>
        </div>
        <div class="card-body">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($listBanner as $key => $banner)
                        <div class="carousel-item {{ $key === 0 ? 'active' : 'inactive' }}">
                            <img src="{{ Storage::url($banner->banner) }}" class="d-block w-100" alt="Banner {{ $key + 1 }}">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Tiến</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Lùi</span>
                </button>
            </div>
        </div>
    </div> --}}

    <div class="card mt-4">
        <div class="card-header">
            
            <h4 class="card-title">Slideshow Banners</h4>
        </div>
        <div class="card-body">
            <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $activeSet = false; // Biến để đánh dấu banner đầu tiên được hiển thị
                    @endphp
                    @foreach ($listBanner as $key => $banner)
                        @if ($banner->status) <!-- Kiểm tra trạng thái của banner -->
                            <div class="carousel-item {{ !$activeSet ? 'active' : '' }}">
                                <img src="{{ Storage::url($banner->banner) }}" class="d-block w-100" alt="Banner {{ $key + 1 }}">
                            </div>
                            @php
                                $activeSet = true; // Đặt trạng thái active cho banner đầu tiên
                            @endphp
                        @endif
                    @endforeach
                </div>
    
                <!-- Nếu có ít nhất 1 banner, hiển thị điều khiển carousel -->
                @if ($activeSet)
                    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
    
@endsection
@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('inputState');
        const slideshowCard = document.getElementById('slideshowCard');

        // Function to toggle the slideshow visibility
        function toggleSlideshow() {
            if (statusSelect.value === "0") { // Inactive
                slideshowCard.style.display = 'none'; // Hide slideshow
            } else {
                slideshowCard.style.display = 'block'; // Show slideshow
            }
        }

        // Initial check on page load
        toggleSlideshow();

        // Event listener for the status select change
        statusSelect.addEventListener('change', toggleSlideshow);
    });
</script>
@endpush