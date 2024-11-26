
@extends('admin.layouts.master')

@section('title')
    Banner
@endsection
@push('style')
<style>
.swiper-slide {
    transition: transform 0.3s ease;
}

.swiper-slide img {
    border-radius: 10px; /* Thêm bo góc cho hình ảnh */
    width: 100%;  /* Chiều rộng ảnh trong slide */
    height: 450px; /* Chiều cao ảnh trong slide */
}
</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.banners.addBanner') }}">
                    <button class="btn btn-success">Thêm mới</button>
                </a>
            </div>
            {{-- <a href="{{ route('admin.banners.addBanner') }}">
                <button class="btn btn-success">Thêm mới</button>
            </a> --}}
    
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
                    <form action="{{ route('admin.banners.listBanner') }}" method="GET">
                        @csrf
                        <div class="row mb-2 ">
                            {{-- <div class="col-lg-4">
                                <div class="d-flex justify-content-start">
                                    <div class="search-box ms-2 w-100">
                                        <input type="text" name="query" class="form-control search"
                                            placeholder="Search...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-3" data-select2-id="select2-data-2">
                                <select class="js-example-basic-single select2-hidden-accessible" name="status"
                                    aria-hidden="true">
                                    <option value="" disabled selected>Tìm theo trạng thái</option>
                                    <option value="active" data-select2-id="select2-data-75-jxz2">active</option>
                                    <option value="inactive" data-select2-id="select2-data-76-uypr">inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-2 d-flex justify-content-start">
                                <button type="submit" class="btn btn-info" data-bs-toggle="offcanvas"
                                        href="#offcanvasExample"><i class="ri-filter-3-line align-bottom me-1"></i>Tìm
                                        kiếm</button>
                            </div>
                        </div>
                    </form>
                    <br>
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
                                        {{-- <th scope="col">ID</th> --}}
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
                                            {{-- <td>{{ $item + 1 }}</td> --}}
                                            <td class="text-center"> <!-- Thêm text-center để căn giữa hình ảnh -->
                                                <img src="{{ asset('storage/' . $value->banner) }}" alt="" width="250px" height="100px">
                                            </td>
                                            <td><a href="{{ $value->url }}" target="_blank">Đường Link</a></td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" checked data-id="{{ $value->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @else
                                                    <div class="form-check form-switch form-switch-lg p-3" dir="ltr">
                                                        <input type="checkbox" data-id="{{ $value->id }}"
                                                            class="form-check-input change-status" id="customSwitchsizemd">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.banners.updateBanner', $value->id) }}" style="margin-right: 10px;">
                                                    <i class="ri-edit-fill align-bottom text-muted"></i> 
                                                </a>
                                                <a href="{{ route('admin.banners.deleteBanner', $value->id) }}" class="delete-item">
                                                    <i class="ri-delete-bin-fill align-bottom text-muted"></i> 
                                                </a>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-4">
                                {{ $listBanner->links() }}
                            </div>
                        </div>
                    </div>
                </div><!-- end card-body -->
                
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

    {{-- slide show --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Effect Coverflow Swiper</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <p class="text-muted">Danh sách các banner được hiển thị với hiệu ứng coverflow.</p>
    
                <!-- Swiper -->
                <div class="swiper effect-coverflow-swiper rounded pb-5">
                    <div class="swiper-wrapper">
                        @foreach ($listBanner as $banner)
                        <div class="swiper-slide" id="bannerSlide{{ $banner->id }}" data-status="{{ $banner->status }}">
                            <img src="{{ asset('storage/' . $banner->banner) }}" alt="Banner {{ $banner->id }}" class="img-fluid" />
                        </div>
                        
                    @endforeach
                    
                    </div>
                    <div class="swiper-pagination swiper-pagination-dark"></div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    
    
    
    
@endsection

@push('script')
<!-- Thêm CSS Swiper -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

<!-- Thêm JavaScript Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    // slide show banner
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.effect-coverflow-swiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            loop: true, // Thêm tùy chọn này để vòng lặp
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script>

{{-- <script>
    // slide show banner
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.effect-coverflow-swiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: 'auto',
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: true,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    });
</script> --}}
<script>
    // status
    document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll('.swiper-slide');

    slides.forEach(slide => {
        const status = slide.getAttribute('data-status');
        
        if (status == 0) {
            slide.style.display = 'none';  // Ẩn banner
        } else {
            slide.style.display = 'block';  // Hiện banner
        }
    });
});

</script>
<script>
    const notyf = new Notyf();
    $(document).ready(function() {
        $('body').on('click', '.change-status', function() {
            let isChecked = $(this).is(':checked');
            let id = $(this).data('id');
            console.log(isChecked, id);


            $.ajax({
                url: "{{ route('admin.banners.change-status') }}",
                method: 'PUT',
                data: {
                    status: isChecked,
                    id: id
                },
                success: function(data) {
                    // toastr.success(data.message)
                    notyf.success(data.message);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            })

        })
    })
</script>
@endpush