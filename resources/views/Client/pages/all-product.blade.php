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



                        <form action="{{ route('filter.products') }}" method="POST">
                            @csrf
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">LỌC THEO GIÁ</h6>
                                <div class="sidebar-content">
                                    <div class="filter-type-select">
                                        <ul>
                                            <li>
                                                <label class="checkbox-default" for="price-0-100000">
                                                    <input type="checkbox" id="price-0-100000" name="priceRange[]"
                                                        value="0-100000">
                                                    <span>0đ - 100.000đ</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-default" for="price-100000-500000">
                                                    <input type="checkbox" id="price-100000-500000" name="priceRange[]"
                                                        value="100000-500000">
                                                    <span>100.000đ - 500.000đ</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-default" for="price-500000-1000000">
                                                    <input type="checkbox" id="price-500000-1000000" name="priceRange[]"
                                                        value="500000-1000000">
                                                    <span>500.000đ - 1.000.000đ</span>
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-default" for="price-1000000">
                                                    <input type="checkbox" id="price-1000000" name="priceRange[]"
                                                        value="1000000+">
                                                    <span>Trên 1.000.000đ</span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="submit">Lọc</button>
                            </div>
                        </form>





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


                                    <!-- Start Sort Select Option -->
                                    <div class="sort-select-list d-flex align-items-center">
                                        <label class="mr-2"></label>
                                        <form action="#">
                                            <fieldset>
                                                <select name="speed" id="speed">

                                                    <option selected="selected">Sort by newness</option>

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
                                                @if (session('error'))
                                                    <div class="empty-content">
                                                        <div class="icon"><i class="fab fa-searchengin"></i></div>
                                                        <div class="title">Oooops!</div>
                                                        <div class="content">{{ session('error') }}</div>
                                                    </div>
                                                @elseif($products->isEmpty())
                                                    <div class="empty-content">
                                                        <div class="icon"><i class="fab fa-searchengin"></i></div>
                                                        <div class="title">Oooops!</div>
                                                        <div class="content">Không có sản phẩm phù hợp với khoảng giá đã chọn.</div>
                                                    </div>
                                                @else
                                                    @foreach ($products as $product)
                                                        <div class="col-xl-4 col-sm-6 col-12">
                                                            <!-- Start Product Default Single Item -->
                                                            <div class="product-default-single-item product-color--golden" data-aos="fade-up" data-aos-delay="0">
                                                                <div class="image-box">
                                                                    <a href="{{ route('product-detail', $product->slug) }}" class="image-link">
                                                                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="">
                                                                    </a>
                                                                    <div class="action-link">
                                                                        <div class="action-link-left">
                                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAddcart">Add to Cart</a>
                                                                        </div>
                                                                        <div class="action-link-right">
                                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalQuickview"><i class="icon-magnifier"></i></a>
                                                                            <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="content-left">
                                                                        <h6 class="title"><a href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a></h6>
                                                                        <ul class="review-star">
                                                                            <li class="fill"><i class="ion-android-star"></i></li>
                                                                            <li class="fill"><i class="ion-android-star"></i></li>
                                                                            <li class="fill"><i class="ion-android-star"></i></li>
                                                                            <li class="fill"><i class="ion-android-star"></i></li>
                                                                            <li class="empty"><i class="ion-android-star"></i></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="content-right">
                                                                        <span class="price">
                                                                            @if ((float) $product->price_sale > 0)
                                                                                <div>
                                                                                    <div data-order="{{ $product->price_sale }}">
                                                                                        {{ number_format((float) $product->price_sale, 0, ',', '.') }}₫
                                                                                    </div>
                                                                                    <del style="color: red" data-order="{{ $product->price }}">
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
                                            </div> --}}
                                            <div class="row">
                                                @if (session('error'))
                                                    <div class="empty-content">
                                                        <div class="icon"><i class="fab fa-searchengin"></i></div>
                                                        <div class="title">Oooops!</div>
                                                        <div class="content">{{ session('error') }}</div>
                                                    </div>
                                                @elseif($products->isEmpty())
                                                    <div class="empty-content">
                                                        <div class="icon"><i class="fab fa-searchengin"></i></div>
                                                        <div class="title">Oooops!</div>
                                                        <div class="content">{{ session('error') }}</div>
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
                                                                    </a>
                                                                </div>
                                                                <div class="content">
                                                                    <h6 class="title"><a
                                                                            href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                                                    </h6>
                                                                    <span class="price">
                                                                        @if ($product->price_sale > 0)
                                                                            <div>
                                                                                <div>
                                                                                    {{ number_format($product->price_sale, 0, ',', '.') }}₫
                                                                                </div>
                                                                                <del
                                                                                    style="color: red">{{ number_format($product->price, 0, ',', '.') }}₫</del>
                                                                            </div>
                                                                        @else
                                                                            <div>
                                                                                {{ number_format($product->price, 0, ',', '.') }}₫
                                                                            </div>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <!-- End Product Default Single Item -->
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Tab Wrapper -->

                        <!-- Start Pagination -->
                        @if (count($products) > 0)
                            <!-- Kiểm tra nếu có sản phẩm -->
                            <div class="page-pagination text-center" data-aos="fade-up" data-aos-delay="0">
                                <ul>
                                    <li><a class="active" href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#"><i class="ion-ios-skipforward"></i></a></li>
                                </ul>
                            </div>
                        @endif <!-- End Pagination -->
                    </div>
                </div>
            </div>
        </div> <!-- ...:::: End Shop Section:::... -->

        <!-- Start Footer Section -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
