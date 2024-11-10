@extends('Client.index')
@section('main')
    
    <div class="blog-section">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-3">
                    <!-- Start Sidebar Area -->
                    <div class="siderbar-section"  data-aos="fade-up"  data-aos-delay="0">
    
                        <!-- Start Single Sidebar Widget -->
                        <form action="{{ route('blog.index') }}" method="get">
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">Tìm kiếm</h6>
                                <div class="default-search-style d-flex">
                                    <input class="default-search-style-input-box" type="search" name="keywords" placeholder="Search..." required>
                                    <button class="default-search-style-input-btn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
                        </form>
                         <!-- End Single Sidebar Widget -->

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

                    </div> <!-- End Sidebar Area --> <!-- End Sidebar Area -->
                </div>
                <div class="col-lg-9">
                    <!-- Start Blog Single Content Area -->
                    <div class="blog-single-wrapper">
                        <div class="blog-single-img" data-aos="fade-up"  data-aos-delay="0">
                            <img width="" class="img-thumbnail"
                                                    src="{{ asset('storage/' . $post->thumbnail) }}" alt="">
                        </div>
                        <ul class="post-meta" data-aos="fade-up"  data-aos-delay="200">
                            <li>Tác giả :{{ $post->User ? $post->User->full_name : 'Không tên tác giả' }}</li> 
                            <li>{{ $post->created_at->format('Y-m') }}-{{ \Illuminate\Support\Carbon::parse($post->created_at)->locale('vi')->dayName }}</li> 
                         </ul>
                        <h4 class="post-title" data-aos="fade-up"  data-aos-delay="400">{{$post->title}}</h4>
                        <div class="para-content" data-aos="fade-up"  data-aos-delay="600">
                            <blockquote class="blockquote-content">
                                {{$post->description}}
                            </blockquote>
                            <p>
                                {!! $post->body !!}
                            </p>
                        </div>
                        <div class="para-tags" data-aos="fade-up"  data-aos-delay="0">
                            <span>Danh mục </span>
                            <ul>
                                <li><a href="{{ route('blog.byCategory', $item->id) }}">{{ $post->Category ? $post->Category->name : 'Không có danh mục' }}</a></li>
                            </ul>
                        </div>
                    </div> <!-- End Blog Single Content Area -->
                </div>
            </div>
        </div>
    </div>
@endsection
       <!-- ::::::::::::::All JS Files here :::::::::::::: -->
    <!-- Global Vendor, plugins JS -->
    <script src="{{ asset('assets') }}/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery-migrate-3.3.0.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/vendor/jquery-ui.min.js"></script>

    <!--Plugins JS-->
    <script src="{{ asset('assets') }}/js/plugins/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/material-scrolltop.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jquery.nice-select.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jquery.zoom.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/venobox.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jquery.waypoints.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jquery.lineProgressbar.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/aos.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/jquery.instagramFeed.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/ajax-mail.js"></script>

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    {{-- <script src="{{ asset('assets') }}/js/vendor/vendor.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/plugins.min.js"></script>  --}}

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
    integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>