@php
    use Illuminate\Support\Str;
@endphp
<!-- Mirrored from htmldemo.hasthemes.com/hono/hono/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Jan 2021 00:31:46 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
@extends('Client.index')
@section('main')
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Tin Tức</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                    <li><a href="{{ route('blog.index') }}">Tin Tức</a></li>
                                    @if(isset($category))
                                        <li class="active" aria-current="page"><a href="{{ route('blog.byCategory', $category->id) }}">{{ $category->name }}</a></li>
                                    @endif
                                </ul>                                
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- ...:::: Start Blog List Section:::... -->
        <div class="blog-section">
            <div class="container">
                <div class="row flex-column-reverse flex-lg-row">
                    <div class="col-lg-3">
                        <!-- Start Sidebar Area -->
                            <div class="siderbar-section"  data-aos="fade-up"  data-aos-delay="0">
        
                                <!-- Start Single Sidebar Widget -->
                                <form action="" method="get">
                                <div class="sidebar-single-widget" >
                                    <h6 class="sidebar-title">Tìm kiếm</h6>
                                    <div class="default-search-style d-flex">
                                        <input class="default-search-style-input-box" type="search" name="keywords" placeholder="Search..." required>
                                        <button class="default-search-style-input-btn" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div> <!-- End Single Sidebar Widget -->
                                </form>
                                <!-- Start Single Sidebar Widget -->
                                <div class="sidebar-single-widget" >
                                    <h6 class="sidebar-title">Danh mục</h6>
                                    <div class="sidebar-content">
                                        <ul class="sidebar-menu">
                                        @foreach ($postCate as $key => $item)
                                        <li ><a href="{{ route('blog.byCategory', $item->id) }}">{{$item->name}}</a></li>
                                        @endforeach
                                        </ul>
                                    </div>
                                </div> <!-- End Single Sidebar Widget -->
        
                            </div> <!-- End Sidebar Area -->
                    </div>
                                    <div class="col-lg-9">
                                        <div class="blog-wrapper">
                                            <div class="row mb-n6">
                                                @if($list->isEmpty())
                                                <h4 style="text-align: center">Không có bài viết nào</h4>
                                            @else
                                                @foreach ($list as $key => $item)
                                                    @if($item->status == 2)
                                                        <div class="col-12 mb-6">
                                                            <!-- Start Product Default Single Item -->
                                                            <div class="blog-list blog-list-single-item blog-color--golden" data-aos="fade-up" data-aos-delay="0">
                                                                <div class="row">
                                                                    <div class="col-xl-5 col-md-6">
                                                                        <div class="image-box">
                                                                            <a href="{{ route('blog.show', $item->id) }}" class="image-link">
                                                                                <img class="img-fluid" src="{{ asset('storage/' . $item->thumbnail) }}" alt="">
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-7 col-md-6">
                                                                        <div class="content">
                                                                            <ul class="post-meta">
                                                                                <li>Tác giả: {{ $item->User ? $item->User->full_name : 'Không tên tác giả' }}</li>
                                                                                <li>{{ $item->created_at->format('Y-m') }}-{{ \Illuminate\Support\Carbon::parse($item->created_at)->locale('vi')->dayName }}</li>
                                                                            </ul>
                                                                            <hr>
                                                                            <h6>
                                                                                <a href="{{ route('blog.show', $item->id) }}">{{ $item->title }}</a>
                                                                            </h6>
                                                                            <p>{{ \Illuminate\Support\Str::limit($item->description, 250) }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Product Default Single Item -->
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                            
                                            </div>
                                        </div>
                                        

                    <!-- Start Pagination -->
                    <div class="page-pagination text-center" data-aos="fade-up"  data-aos-delay="0">
                        <ul>
                            <li>{{ $list->links() }}</li>
                        </ul>
                    </div> <!-- End Pagination -->
                </div>                     
                </div>
            </div>
        </div> <!-- ...:::: End Blog List Section:::... -->
        <style>
            h6 {
                line-height: 1.2;
                font-size: 24px; /* Cỡ chữ */
                font-weight: bold; /* Làm cho phông chữ đậm */
                transition: color 0.3s ease; /* Hiệu ứng chuyển màu mượt mà */
            }
            
            h6 a {
                text-decoration: none; /* Bỏ gạch chân */
                color: black; /* Màu chữ mặc định */
            }
            
            h6 a:hover {
                color: rgb(134, 88, 9); /* Màu chữ khi hover */
            }
            .page-pagination nav p {
        display: none; /* Ẩn phần "Showing x to y of z results" */
    }
    
    
    
        </style>
        @endsection
