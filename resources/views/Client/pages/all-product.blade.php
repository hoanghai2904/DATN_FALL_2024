@extends('Client.layout.master')
@section('content')
    <!-- ...:::: Start Breadcrumb Section:::... -->
    <style>
        .empty-content {
            text-align: center;
            padding: 50px 0;
        }

        .empty-content .icon {
            font-size: 130px;
            color: #f30;
        }

        .empty-content .title {
            font-size: 36px;
            color: #f30;
            font-weight: 600;
        }

        .empty-content .content {
            font-size: 20px;
            color: #000;
        }
    </style>

    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Shop - Grid Left Sidebar</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="shop-grid-sidebar-left.html">Shop</a></li>
                                    <li class="active" aria-current="page">Shop Grid Left Sidebar</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- ...:::: End Breadcrumb Section:::... -->

    <!-- ...:::: Start Shop Section:::... -->
    <div class="shop-section">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-lg-3">
                    <!-- Start Sidebar Area -->
                    <div class="siderbar-section" data-aos="fade-up" data-aos-delay="0">

                        <!-- Start Single Sidebar Widget -->
                        <div class="sidebar-single-widget">
                            <h6 class="sidebar-title">LỌC SẢN PHẨM</h6>
                            <div class="sidebar-content">
                                <ul class="sidebar-menu">
                                    <li>
                                    <li class="sidebar-menu-collapse-list">
                                        <div class="accordion">
                                            <a href="" class="accordion-title">DANH MỤC SẢN PHẨM
                                            </a>
                                            <div class="accordion-content">
                                                <ul class="accordion-category-list">
                                                    @foreach ($categories as $item)
                                                        <li><a
                                                                href="{{ route('all-products', $item->id) }}">{{ $item->name }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </div>
                                    </li>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- End Single Sidebar Widget -->


                        <!-- Start Single Sidebar Widget -->
                        <div class="sidebar-single-widget">
                            <h6 class="sidebar-title">LỌC THEO GIÁ</h6>
                            <div class="sidebar-content">
                                <div id="slider-range"></div>
                                <div style="display: inline-block">
                                    <label for="amount" style="margin-right: 5px; margin-top: 10px">Khoảng giá:</label>
                                    <input type="text" id="amount" readonly style="width: 200px;">
                                </div>

                            </div>
                        </div> <!-- End Single Sidebar Widget -->

                        <!-- JavaScript for Slider -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
                        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

                        <script>
                            $(function() {

                                var minPrice = {{ $minPrice }};
                                var maxPrice = {{ $maxPrice }};


                                $("#slider-range").slider({
                                    range: true,
                                    min: minPrice,
                                    max: maxPrice,
                                    values: [minPrice, maxPrice],
                                    slide: function(event, ui) {

                                        $("#amount").val(ui.values[0] + "đ -" + ui.values[1] + "đ");
                                    }
                                });


                                $("#amount").val($("#slider-range").slider("values", 0) + "đ " + "-" + $("#slider-range").slider(
                                    "values", 1) + "đ");
                            });
                        </script>


                        <!-- Start Single Sidebar Widget -->


                        <!-- Start Single Sidebar Widget -->
                        <div class="sidebar-single-widget">
                            <h6 class="sidebar-title">LỌC THEO KHỐI LƯỢNG</h6>
                            <div class="sidebar-content">
                                <div class="filter-type-select">
                                    <ul>
                                        <li>
                                            <label class="checkbox-default" for="black">
                                                <input type="checkbox" id="black">
                                                <span>Black (6)</span>
                                            </label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div> <!-- End Single Sidebar Widget -->

                        <!-- Start Single Sidebar Widget -->
                        <div class="sidebar-single-widget">
                            <h6 class="sidebar-title">TAG SẢN PHẨM</h6>
                            <div class="sidebar-content">
                                <div class="tag-link">
                                    @foreach ($tags as $tag)
                                        <a href="">{{ $tag->name }} ({{ $tag->products_count }})</a>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!-- End Single Sidebar Widget -->
                        <div class="sidebar-single-widget">
                            <h6 class="sidebar-title">THƯƠNG HIỆU</h6>
                            <div class="sidebar-content">
                                <div class="tag-link">
                                    @foreach ($brands as $brand)
                                        <a href="">{{ $brand->name }} ({{ $brand->products_count }})</a>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!-- End Single Sidebar Widget -->

                        <!-- Start Single Sidebar Widget -->


                    </div> <!-- End Sidebar Area -->
                </div>
                <div class="col-lg-9">
                    <!-- Start Shop Product Sorting Section -->
                    <div class="shop-sort-section">
                        <div class="container">
                            <div class="row">
                                <!-- Start Sort Wrapper Box -->
                                <div class="sort-box d-flex justify-content-between align-items-md-center align-items-start flex-md-row flex-column"
                                    data-aos="fade-up" data-aos-delay="0">
                                    <!-- Start Sort tab Button -->
                                    <div class="sort-tablist d-flex align-items-center">
                                        <ul class="tablist nav sort-tab-btn">
                                            <li><a class="nav-link active" data-bs-toggle="tab" href="#layout-3-grid"><img
                                                        src="assets/images/icons/bkg_grid.png" alt=""></a></li>
                                            <li><a class="nav-link" data-bs-toggle="tab" href="#layout-list"><img
                                                        src="assets/images/icons/bkg_list.png" alt=""></a></li>
                                        </ul>

                                        <!-- Start Page Amount -->
                                        <div class="page-amount ml-2">
                                            <span>Showing 1–9 of 21 results</span>
                                        </div> <!-- End Page Amount -->
                                    </div> <!-- End Sort tab Button -->

                                    <!-- Start Sort Select Option -->
                                    <div class="sort-select-list d-flex align-items-center">
                                        <label class="mr-2">Sort By:</label>
                                        <form action="#">
                                            <fieldset>
                                                <select name="speed" id="speed">
                                                    <option>Sort by average rating</option>
                                                    <option>Sort by popularity</option>
                                                    <option selected="selected">Sort by newness</option>
                                                    <option>Sort by price: low to high</option>
                                                    <option>Sort by price: high to low</option>
                                                    <option>Product Name: Z</option>
                                                </select>
                                            </fieldset>
                                        </form>
                                    </div> <!-- End Sort Select Option -->



                                </div> <!-- Start Sort Wrapper Box -->
                            </div>
                        </div>
                    </div> <!-- End Section Content -->

                    <!-- Start Tab Wrapper -->
                    <div class="sort-product-tab-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content tab-animate-zoom">
                                        <!-- Start Grid View Product -->
                                        <div class="tab-pane active show sort-layout-single" id="layout-3-grid">
                                            {{-- <div class="row">
                                                @foreach ($products as $product)
                                                    <div class="col-xl-4 col-sm-6 col-12">
                                                        <!-- Start Product Default Single Item -->
                                                        <div class="product-default-single-item product-color--golden"
                                                            data-aos="fade-up" data-aos-delay="0">
                                                            <div class="image-box">
                                                                <a href="{{ route('product-detail', $product->slug) }}"
                                                                    class="image-link">
                                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                        alt="">
                                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                        alt="">
                                                                </a>
                                                                <div class="action-link">
                                                                    <div class="action-link-left">
                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#modalAddcart">Add to Cart</a>
                                                                    </div>
                                                                    <div class="action-link-right">
                                                                        <a href="#" data-bs-toggle="modal"
                                                                            data-bs-target="#modalQuickview"><i
                                                                                class="icon-magnifier"></i></a>
                                                                        <a href="wishlist.html"><i
                                                                                class="icon-heart"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content">
                                                                <div class="content-left">
                                                                    <h6 class="title"><a
                                                                            href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                                                    </h6>
                                                                    <ul class="review-star">
                                                                        <li class="fill"><i
                                                                                class="ion-android-star"></i></li>
                                                                        <li class="fill"><i
                                                                                class="ion-android-star"></i></li>
                                                                        <li class="fill"><i
                                                                                class="ion-android-star"></i></li>
                                                                        <li class="fill"><i
                                                                                class="ion-android-star"></i></li>
                                                                        <li class="empty"><i
                                                                                class="ion-android-star"></i></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="content-right">
                                                                    <span class="price">
                                                                        @if ((float) $product->price_sale > 0)
                                                                            <div>
                                                                                <div
                                                                                    data-order="{{ $product->price_sale }}">
                                                                                    {{ number_format((float) $product->price_sale, 0, ',', '.') }}₫
                                                                                </div>
                                                                                <del style="color: red"
                                                                                    data-order="{{ $product->price }}">
                                                                                    {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                                                </del>
                                                                            </div>
                                                                        @else
                                                                            <div data-order="{{ $product->price }}">
                                                                                {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                                            </div>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Product Default Single Item -->
                                                    </div>
                                                @endforeach
                                            </div> --}}
                                            <div class="row">
                                                @if ($products->isEmpty())
                                                    <div class="empty-content">
                                                        <div class="icon"><i class="fab fa-searchengin"></i></div>
                                                        <div class="title">Oooops!</div>
                                                        <div class="content">Không có sản phẩm</div>
                                                    </div>
                                                @else
                                                    @foreach ($products as $product)
                                                        <div class="col-xl-4 col-sm-6 col-12">
                                                            <!-- Start Product Default Single Item -->
                                                            <div class="product-default-single-item product-color--golden"
                                                                data-aos="fade-up" data-aos-delay="0">
                                                                <div class="image-box">
                                                                    <a href="{{ route('product-detail', $product->slug) }}"
                                                                        class="image-link">
                                                                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                            alt="">
                                                                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                                                            alt="">
                                                                    </a>
                                                                    <div class="action-link">
                                                                        <div class="action-link-left">
                                                                            <a href="#" data-bs-toggle="modal"
                                                                                data-bs-target="#modalAddcart">Add to
                                                                                Cart</a>
                                                                        </div>
                                                                        <div class="action-link-right">
                                                                            <a href="#" data-bs-toggle="modal"
                                                                                data-bs-target="#modalQuickview"><i
                                                                                    class="icon-magnifier"></i></a>
                                                                            <a href="wishlist.html"><i
                                                                                    class="icon-heart"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="content-left">
                                                                        <h6 class="title"><a
                                                                                href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                                                        </h6>
                                                                        <ul class="review-star">
                                                                            <li class="fill"><i
                                                                                    class="ion-android-star"></i></li>
                                                                            <li class="fill"><i
                                                                                    class="ion-android-star"></i></li>
                                                                            <li class="fill"><i
                                                                                    class="ion-android-star"></i></li>
                                                                            <li class="fill"><i
                                                                                    class="ion-android-star"></i></li>
                                                                            <li class="empty"><i
                                                                                    class="ion-android-star"></i></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="content-right">
                                                                        <span class="price">
                                                                            @if ((float) $product->price_sale > 0)
                                                                                <div>
                                                                                    <div
                                                                                        data-order="{{ $product->price_sale }}">
                                                                                        {{ number_format((float) $product->price_sale, 0, ',', '.') }}₫
                                                                                    </div>
                                                                                    <del style="color: red"
                                                                                        data-order="{{ $product->price }}">
                                                                                        {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                                                    </del>
                                                                                </div>
                                                                            @else
                                                                                <div data-order="{{ $product->price }}">
                                                                                    {{ number_format((float) $product->price, 0, ',', '.') }}₫
                                                                                </div>
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Product Default Single Item -->
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <!-- Start List View Product -->
                                            <div class="tab-pane sort-layout-single" id="layout-list">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <!-- Start Product Defautlt Single -->
                                                        <div class="product-list-single product-color--golden">
                                                            <a href="product-details-default.html"
                                                                class="product-list-img-link">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-1.jpg"
                                                                    alt="">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-2.jpg"
                                                                    alt="">
                                                            </a>
                                                            <div class="product-list-content">
                                                                <h5 class="product-list-link"><a
                                                                        href="product-details-default.html">KAOREET
                                                                        LOBORTIS
                                                                        SAGIT</a></h5>
                                                                <ul class="review-star">
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="empty"><i class="ion-android-star"></i>
                                                                    </li>
                                                                </ul>
                                                                <span class="product-list-price"><del>$30.12</del>
                                                                    $25.12</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Nobis ad, iure incidunt. Ab consequatur temporibus non
                                                                    eveniet inventore doloremque necessitatibus sed, ducimus
                                                                    quisquam, ad asperiores</p>
                                                                <div class="product-action-icon-link-list">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalAddcart"
                                                                        class="btn btn-lg btn-black-default-hover">Add to
                                                                        cart</a>
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalQuickview"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-magnifier"></i></a>
                                                                    <a href="wishlist.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-heart"></i></a>
                                                                    <a href="compare.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-shuffle"></i></a>
                                                                </div>
                                                            </div>
                                                        </div> <!-- End Product Defautlt Single -->
                                                    </div>
                                                    <div class="col-12">
                                                        <!-- Start Product Defautlt Single -->
                                                        <div class="product-list-single product-color--golden">
                                                            <a href="product-details-default.html"
                                                                class="product-list-img-link">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-3.jpg"
                                                                    alt="">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-4.jpg"
                                                                    alt="">
                                                            </a>
                                                            <div class="product-list-content">
                                                                <h5 class="product-list-link"><a
                                                                        href="product-details-default.html">CONDIMENTUM
                                                                        POSUERE</a></h5>
                                                                <ul class="review-star">
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="empty"><i class="ion-android-star"></i>
                                                                    </li>
                                                                </ul>
                                                                <span class="product-list-price">$95.00</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Nobis ad, iure incidunt. Ab consequatur temporibus non
                                                                    eveniet inventore doloremque necessitatibus sed, ducimus
                                                                    quisquam, ad asperiores</p>
                                                                <div class="product-action-icon-link-list">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalAddcart"
                                                                        class="btn btn-lg btn-black-default-hover">Add to
                                                                        cart</a>
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalQuickview"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-magnifier"></i></a>
                                                                    <a href="wishlist.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-heart"></i></a>
                                                                    <a href="compare.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-shuffle"></i></a>
                                                                </div>
                                                            </div>
                                                        </div> <!-- End Product Defautlt Single -->
                                                    </div>
                                                    <div class="col-12">
                                                        <!-- Start Product Defautlt Single -->
                                                        <div class="product-list-single product-color--golden">
                                                            <a href="product-details-default.html"
                                                                class="product-list-img-link">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-5.jpg"
                                                                    alt="">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-6.jpg"
                                                                    alt="">
                                                            </a>
                                                            <div class="product-list-content">
                                                                <h5 class="product-list-link"><a
                                                                        href="product-details-default.html">ALIQUAM
                                                                        LOBORTIS</a></h5>
                                                                <ul class="review-star">
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="empty"><i class="ion-android-star"></i>
                                                                    </li>
                                                                </ul>
                                                                <span class="product-list-price"> $25.12</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Nobis ad, iure incidunt. Ab consequatur temporibus non
                                                                    eveniet inventore doloremque necessitatibus sed, ducimus
                                                                    quisquam, ad asperiores</p>
                                                                <div class="product-action-icon-link-list">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalAddcart"
                                                                        class="btn btn-lg btn-black-default-hover">Add to
                                                                        cart</a>
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalQuickview"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-magnifier"></i></a>
                                                                    <a href="wishlist.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-heart"></i></a>
                                                                    <a href="compare.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-shuffle"></i></a>
                                                                </div>
                                                            </div>
                                                        </div> <!-- End Product Defautlt Single -->
                                                    </div>
                                                    <div class="col-12">
                                                        <!-- Start Product Defautlt Single -->
                                                        <div class="product-list-single product-color--golden">
                                                            <a href="product-details-default.html"
                                                                class="product-list-img-link">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-7.jpg"
                                                                    alt="">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-8.jpg"
                                                                    alt="">
                                                            </a>
                                                            <div class="product-list-content">
                                                                <h5 class="product-list-link"><a
                                                                        href="product-details-default.html">CONVALLIS QUAM
                                                                        SIT</a></h5>
                                                                <ul class="review-star">
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="empty"><i class="ion-android-star"></i>
                                                                    </li>
                                                                </ul>
                                                                <span class="product-list-price">$75.00 - $85.00</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Nobis ad, iure incidunt. Ab consequatur temporibus non
                                                                    eveniet inventore doloremque necessitatibus sed, ducimus
                                                                    quisquam, ad asperiores</p>
                                                                <div class="product-action-icon-link-list">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalAddcart"
                                                                        class="btn btn-lg btn-black-default-hover">Add to
                                                                        cart</a>
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalQuickview"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-magnifier"></i></a>
                                                                    <a href="wishlist.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-heart"></i></a>
                                                                    <a href="compare.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-shuffle"></i></a>
                                                                </div>
                                                            </div>
                                                        </div> <!-- End Product Defautlt Single -->
                                                    </div>
                                                    <div class="col-12">
                                                        <!-- Start Product Defautlt Single -->
                                                        <div class="product-list-single product-color--golden">
                                                            <a href="product-details-default.html"
                                                                class="product-list-img-link">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-9.jpg"
                                                                    alt="">
                                                                <img class="img-fluid"
                                                                    src="assets/images/product/default/home-1/default-10.jpg"
                                                                    alt="">
                                                            </a>
                                                            <div class="product-list-content">
                                                                <h5 class="product-list-link"><a
                                                                        href="product-details-default.html">DONEC EU LIBERO
                                                                        AC</a></h5>
                                                                <ul class="review-star">
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="fill"><i class="ion-android-star"></i>
                                                                    </li>
                                                                    <li class="empty"><i class="ion-android-star"></i>
                                                                    </li>
                                                                </ul>
                                                                <span class="product-list-price"><del>$25.12</del>
                                                                    $20.00</span>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Nobis ad, iure incidunt. Ab consequatur temporibus non
                                                                    eveniet inventore doloremque necessitatibus sed, ducimus
                                                                    quisquam, ad asperiores</p>
                                                                <div class="product-action-icon-link-list">
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalAddcart"
                                                                        class="btn btn-lg btn-black-default-hover">Add to
                                                                        cart</a>
                                                                    <a href="#" data-bs-toggle="modal"
                                                                        data-bs-target="#modalQuickview"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-magnifier"></i></a>
                                                                    <a href="wishlist.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-heart"></i></a>
                                                                    <a href="compare.html"
                                                                        class="btn btn-lg btn-black-default-hover"><i
                                                                            class="icon-shuffle"></i></a>
                                                                </div>
                                                            </div>
                                                        </div> <!-- End Product Defautlt Single -->
                                                    </div>
                                                </div>
                                            </div> <!-- End List View Product -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Tab Wrapper -->

                        <!-- Start Pagination -->
                        <div class="page-pagination text-center" data-aos="fade-up" data-aos-delay="0">
                            <ul>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#"><i class="ion-ios-skipforward"></i></a></li>
                            </ul>
                        </div> <!-- End Pagination -->
                    </div>
                </div>
            </div>
        </div> <!-- ...:::: End Shop Section:::... -->

        <!-- Start Footer Section -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection