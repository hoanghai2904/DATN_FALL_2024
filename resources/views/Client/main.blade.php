@extends('Client.index');
@section('main')
    <!-- Start Hero Slider Section-->
    <div class="hero-slider-section">
        <!-- Slider main container -->
        <div class="hero-slider-active swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Start Hero Single Slider Item -->
                <div class="hero-single-slider-item swiper-slide">
                    <!-- Hero Slider Image -->
                    <div class="hero-slider-bg">
                        <img src="{{ asset('assets') }}/images/hero-slider/home-2/hero-slider-1.jpg" alt="">
                    </div>
                    <!-- Hero Slider Content -->
                    <div class="hero-slider-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="hero-slider-content">
                                        <h4 class="subtitle">Made of Fresh Ingredients</h4>
                                        <h1 class="title">A natural & <br> organic Skincare </h1>
                                        <a href="product-details-default.html" class="btn btn-lg btn-outline-green">shop now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Hero Single Slider Item -->
                <!-- Start Hero Single Slider Item -->
                <div class="hero-single-slider-item swiper-slide">
                    <!-- Hero Slider Image -->
                    <div class="hero-slider-bg">
                        <img src="{{ asset('assets') }}/images/hero-slider/home-2/hero-slider-2.jpg" alt="">
                    </div>
                    <!-- Hero Slider Content -->
                    <div class="hero-slider-wrapper">
                        <div class="container">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="hero-slider-content">
                                        <h4 class="subtitle">Premium Facial Skincare</h4>
                                        <h1 class="title">Fresh Face <br> Natural Skincare</h1>
                                        <a href="product-details-default.html" class="btn btn-lg btn-outline-green">shop now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- End Hero Single Slider Item -->
            </div>

            <!-- If we need pagination -->
            <div class="swiper-pagination active-color-green"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev swiper-button-disabled"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <!-- End Hero Slider Section-->

    <!-- Start Company Logo Section -->
    <div class="company-logo-section section-top-gap-100 section-fluid">
        <div class="company-logo-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="company-logo-slider default-slider-nav-arrow">
                            <!-- Slider main container -->
                            <div class="swiper-container company-logo-slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-1.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-2.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-3.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-4.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-5.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-6.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-7.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                    <!-- Start Company Logo Single Item -->
                                    <div class="company-logo-single-item swiper-slide">
                                        <div class="image"><img class="img-fluid"
                                                src="{{ asset('assets') }}/images/company-logo/company-logo-8.png"
                                                alt=""></div>
                                    </div>
                                    <!-- End Company Logo Single Item -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev swiper-button-disabled"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Company Logo Section -->

    <!-- Start Banner Section -->
    <div class="banner-section section-top-gap-100 section-fluid">
        <div class="banner-wrapper">
            <div class="container">
                <div class="row mb-n6">
                    <div class="col-md-4 col-12 mb-6">
                        <!-- Start Banner Single Item -->
                        <div class="banner-single-item banner-style-5 img-responsive" data-aos="fade-up" data-aos-delay="0">
                            <a href="product-details-default.html" class="image banner-animation">
                                <img src="{{ asset('assets') }}/images/banner/banner-style-5-img-1.jpg" alt="">
                            </a>
                        </div>
                        <!-- End Banner Single Item -->
                    </div>
                    <div class="col-md-4 col-12 mb-6">
                        <!-- Start Banner Single Item -->
                        <div class="banner-single-item banner-style-5 img-responsive" data-aos="fade-up"
                            data-aos-delay="200">
                            <a href="product-details-default.html" class="image banner-animation">
                                <img src="{{ asset('assets') }}/images/banner/banner-style-5-img-2.jpg" alt="">
                            </a>
                        </div>
                        <!-- End Banner Single Item -->
                    </div>
                    <div class="col-md-4 col-12 mb-6">
                        <!-- Start Banner Single Item -->
                        <div class="banner-single-item banner-style-5 img-responsive" data-aos="fade-up"
                            data-aos-delay="400">
                            <a href="product-details-default.html" class="image banner-animation">
                                <img src="{{ asset('assets') }}/images/banner/banner-style-5-img-3.jpg" alt="">
                            </a>
                        </div>
                        <!-- End Banner Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Section -->

    <!-- Start Product Default Slider Section -->
    <div class="product-default-slider-section section-top-gap-100 section-fluid">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content-gap">
                            <div class="secton-content">
                                <h3 class="section-title">the New arrivals</h3>
                                <p>Preorder now to receive exclusive deals & gifts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Section Content Text Area -->
        <div class="product-wrapper" data-aos="fade-up" data-aos-delay="200">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-slider-default-1row default-slider-nav-arrow">
                            <!-- Slider main container -->
                            <div class="swiper-container product-default-slider-4grid-1row">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-9.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-10.jpg"
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
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Epicuri per
                                                        lobortis</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$68</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-11.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-3.jpg"
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
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Kaoreet lobortis
                                                        sagit</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$95.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-5.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-7.jpg"
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
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Condimentum
                                                        posuere</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$115.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-6.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-9.jpg"
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
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Convallis quam
                                                        sit</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$75.00 - $85.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-1.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-2.jpg"
                                                    alt="">
                                            </a>
                                            <div class="tag">
                                                <span>sale</span>
                                            </div>
                                            <div class="action-link">
                                                <div class="action-link-left">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalAddcart">Add to Cart</a>
                                                </div>
                                                <div class="action-link-right">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalQuickview"><i
                                                            class="icon-magnifier"></i></a>
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Aliquam
                                                        lobortis</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$75.00 - $85.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-3.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-4.jpg"
                                                    alt="">
                                            </a>
                                            <div class="tag">
                                                <span>sale</span>
                                            </div>
                                            <div class="action-link">
                                                <div class="action-link-left">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalAddcart">Add to Cart</a>
                                                </div>
                                                <div class="action-link-right">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalQuickview"><i
                                                            class="icon-magnifier"></i></a>
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Condimentum
                                                        posuere</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price"><del>$89.00</del> $80.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-5.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-6.jpg"
                                                    alt="">
                                            </a>
                                            <div class="tag">
                                                <span>sale</span>
                                            </div>
                                            <div class="action-link">
                                                <div class="action-link-left">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalAddcart">Add to Cart</a>
                                                </div>
                                                <div class="action-link-right">
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modalQuickview"><i
                                                            class="icon-magnifier"></i></a>
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Cras neque
                                                        metus</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price"><del>$70.00</del> $60.00</span>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="product-default-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-7.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-8.jpg"
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
                                                    <a href="wishlist.html"><i class="icon-heart"></i></a>
                                                    <a href="compare.html"><i class="icon-shuffle"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="content-left">
                                                <h6 class="title"><a href="product-details-default.html">Donec eu libero
                                                        ac</a></h6>
                                                <ul class="review-star">
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="fill"><i class="ion-android-star"></i></li>
                                                    <li class="empty"><i class="ion-android-star"></i></li>
                                                </ul>
                                            </div>
                                            <div class="content-right">
                                                <span class="price">$74</span>
                                            </div>

                                        </div>
                                    </div> <!-- End Product Default Single Item -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Default Slider Section -->

    <!-- Start Banner Section -->
    <div class="banner-section section-top-gap-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <!-- Start Banner Single Item -->
                    <div class="banner-single-item banner-style-6 banner-animation img-responsive" data-aos="fade-up"
                        data-aos-delay="0">
                        <div class="image">
                            <img src="{{ asset('assets') }}/images/banner/banner-style-6-img-1.jpg" alt="">
                        </div>
                        <div class="content">
                            <h6 class="sub-title">JASMINE GREEN TEA</h6>
                            <h2 class="title">Herbivore Botanicals
                                Basic Collection</h2>
                            <p>On a mission to create all-natural skin care that delivers tangible results, Herbivore
                                ensures every ingredient within their formulas has a specific purpose, resulting in highly
                                active.</p>
                            <a href="product-details-default.html"
                                class="btn btn-lg btn-outline-green icon-space-left"><span
                                    class="d-flex align-items-center">Browse <i
                                        class="ion-ios-arrow-thin-right"></i></span></a>
                        </div>
                    </div>
                    <!-- End Banner Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Section -->

    <!-- Start Service Section -->
    <div class="service-promo-section section-top-gap-100">
        <div class="service-wrapper">
            <div class="container">
                <div class="row">
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="0">
                            <div class="image">
                                <img src="{{ asset('assets') }}/images/icons/service-promo-5.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">FREE SHIPPING</h6>
                                <p>Get 10% cash back, free shipping, free returns, and more at 1000+ top retailers!</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="image">
                                <img src="{{ asset('assets') }}/images/icons/service-promo-6.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">30 DAYS MONEY BACK</h6>
                                <p>100% satisfaction guaranteed, or get your money back within 30 days!</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="image">
                                <img src="{{ asset('assets') }}/images/icons/service-promo-7.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">SAFE PAYMENT</h6>
                                <p>Pay with the world’s most popular and secure payment methods.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                    <!-- Start Service Promo Single Item -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="service-promo-single-item" data-aos="fade-up" data-aos-delay="600">
                            <div class="image">
                                <img src="{{ asset('assets') }}/images/icons/service-promo-8.png" alt="">
                            </div>
                            <div class="content">
                                <h6 class="title">LOYALTY CUSTOMER</h6>
                                <p>Card for the other 30% of their purchases at a rate of 1% cash back.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Promo Single Item -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Service Section -->

    <!-- Start Banner Section -->
    <div class="banner-section section-top-gap-100">
        <div class="banner-wrapper clearfix">
            <!-- Start Banner Single Item -->
            <div class="banner-single-item banner-style-4 banner-animation banner-color--green float-left"
                data-aos="fade-up" data-aos-delay="0">
                <div class="image">
                    <img class="img-fluid" src="{{ asset('assets') }}/images/banner/banner-style-4-img-5.jpg"
                        alt="">
                </div>
                <a href="product-details-default.html" class="content">
                    <div class="inner">
                        <h4 class="title">Bar Stool</h4>
                        <h6 class="sub-title">20 products</h6>
                    </div>
                    <span class="round-btn d-flex align-items-center ">
                        <i class="ion-ios-arrow-thin-right ms-10" style="margin-left: 10px;"></i>
                    </span>
                </a>
            </div>
            <!-- End Banner Single Item -->
            <!-- Start Banner Single Item -->
            <div class="banner-single-item banner-style-4 banner-animation banner-color--green float-left"
                data-aos="fade-up" data-aos-delay="200">
                <div class="image">
                    <img class="img-fluid" src="{{ asset('assets') }}/images/banner/banner-style-4-img-6.jpg"
                        alt="">
                </div>
                <a href="product-details-default.html" class="content">
                    <div class="inner">
                        <h4 class="title">Armchairs</h4>
                        <h6 class="sub-title">20 products</h6>
                    </div>
                    <span class="round-btn d-flex align-items-center ">
                        <i class="ion-ios-arrow-thin-right ms-10" style="margin-left: 10px;"></i>
                    </span>
                </a>
            </div>
            <!-- End Banner Single Item -->
            <!-- Start Banner Single Item -->
            <div class="banner-single-item banner-style-4 banner-animation banner-color--green float-left"
                data-aos="fade-up" data-aos-delay="400">
                <div class="image">
                    <img class="img-fluid" src="{{ asset('assets') }}/images/banner/banner-style-4-img-7.jpg"
                        alt="">
                </div>
                <a href="product-details-default.html" class="content">
                    <div class="inner">
                        <h4 class="title">lighting</h4>
                        <h6 class="sub-title">20 products</h6>
                    </div>
                    <span class="round-btn d-flex align-items-center ">
                        <i class="ion-ios-arrow-thin-right ms-10" style="margin-left: 10px;"></i>
                    </span>
                </a>
            </div>
            <!-- End Banner Single Item -->
            <!-- Start Banner Single Item -->
            <div class="banner-single-item banner-style-4 banner-animation banner-color--green float-left"
                data-aos="fade-up" data-aos-delay="600">
                <div class="image">
                    <img class="img-fluid" src="{{ asset('assets') }}/images/banner/banner-style-4-img-8.jpg"
                        alt="">
                </div>
                <a href="product-details-default.html" class="content">
                    <div class="inner">
                        <h4>Easy chairs</h4>
                        <h6>20 products</h6>
                    </div>
                    <span class="round-btn d-flex align-items-center ">
                        <i class="ion-ios-arrow-thin-right ms-10" style="margin-left: 10px;"></i>
                    </span>
                </a>
            </div>
            <!-- End Banner Single Item -->
        </div>
    </div>
    <!-- End Banner Section -->

    <!-- Start Product List View Slider Section -->
    <div class="product-list-slider-section section-top-gap-100 section-fluid">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content-gap">
                            <div class="secton-content">
                                <h3 class="section-title">Best Sellers</h3>
                                <p>Add our best sellers to your weekly lineup.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Section Content Text Area -->
        <div class="product-wrapper" data-aos="fade-up" data-aos-delay="200">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="product-list-slider-3rows default-slider-nav-arrow">
                            <!-- Slider main container -->
                            <div class="swiper-container product-listview-slider-4grid-3rows">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-1.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-2.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Consequuntur
                                                    magni</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price"> <del>$89.00</del> $80.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-3.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-4.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Pellentesque
                                                    posuere</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$45.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-5.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-6.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Kaoreet lobortis
                                                    sagit</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$95.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-7.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-8.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Phasellus vel
                                                    hendreri</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$55.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-9.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-10.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Duis pulvinar
                                                    obortis</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price"><del>$84.00</del> $79.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-11.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-12.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Cras neque metus</a>
                                            </h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price"><del>$70.00</del> $60.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-13.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-14.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Officiis debitis
                                                    varius</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$90.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-15.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-16.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Ornare sed
                                                    consequat</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$110.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-17.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-18.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Convallis quam
                                                    sit</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$45.00 - $95.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-2.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-1.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Donec eu libero
                                                    ac</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$74.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-4.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-3.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Dolorum fuga
                                                    eget</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$71.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-6.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-5.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Nostrum
                                                    exercitation</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$86.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-8.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-7.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Epicuri per
                                                    lobortis</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$68.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-10.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-9.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Condimentum
                                                    posuere</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$115.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                    <!-- Start Product ListView Single Item -->
                                    <div class="product-listview-single-item product-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="product-details-default.html" class="image-link">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-12.jpg"
                                                    alt="">
                                                <img src="{{ asset('assets') }}/images/product/default/home-2/default-11.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="product-details-default.html">Laudantium enim
                                                    fringi</a></h6>
                                            <ul class="review-star">
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="fill"><i class="ion-android-star"></i></li>
                                                <li class="empty"><i class="ion-android-star"></i></li>
                                            </ul>
                                            <span class="price">$86.00</span>
                                        </div>
                                    </div>
                                    <!-- End Product ListView Single Item -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev swiper-button-disabled"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product List View Slider Section -->

    <!-- Start Banner Section -->
    <div class="banner-section section-top-gap-100">
        <div class="banner-wrapper clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Start Banner Single Item -->
                        <div class="banner-single-item banner-style-13 banner-color--green" data-aos="fade-up"
                            data-aos-delay="0">
                            <div class="image">
                                <img src="{{ asset('assets') }}/images/banner/banner-style-13-img-1.jpg" alt="">
                                <div class="content">
                                    <div class="text">
                                        <h5 class="sub-title">SALE 15% OFF YOUR 1ST PURCHASE</h5>
                                        <h2 class="title">HONO ORGANIC SKIN CARE</h2>

                                        <a href="product-details-default.html"
                                            class="btn btn-lg btn-green icon-space-left"><span
                                                class="d-flex align-items-center">Shop Now <i
                                                    class="ion-ios-arrow-thin-right"></i></span></a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- End Banner Single Item -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Banner Section -->

    <!-- Start Blog Slider Section -->
    <div class="blog-default-slider-section section-top-gap-100 section-fluid">
        <!-- Start Section Content Text Area -->
        <div class="section-title-wrapper" data-aos="fade-up" data-aos-delay="0">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content-gap">
                            <div class="secton-content">
                                <h3 class="section-title">THE LATEST BLOGS</h3>
                                <p>Present posts in a best way to highlight interesting moments of your blog.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Section Content Text Area -->
        <div class="blog-wrapper" data-aos="fade-up" data-aos-delay="200">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="blog-default-slider default-slider-nav-arrow">
                            <!-- Slider main container -->
                            <div class="swiper-container blog-slider">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-1.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post One</a>
                                            </h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="blog-single-sidebar-left.html"
                                                    class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="#" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-2.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post Two</a>
                                            </h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="#" class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="blog-single-sidebar-left.html" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-3.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post
                                                    Three</a></h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="blog-single-sidebar-left.html"
                                                    class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="#" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-4.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post
                                                    Four</a></h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="blog-single-sidebar-left.html"
                                                    class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="#" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-5.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post
                                                    Five</a></h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="blog-single-sidebar-left.html"
                                                    class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="#" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-default-single-item blog-color--green swiper-slide">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid"
                                                    src="{{ asset('assets') }}/images/blog/blog-grid-home-1-img-6.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h6 class="title"><a href="blog-single-sidebar-left.html">Blog Post Six</a>
                                            </h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex.
                                                Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <div class="inner">
                                                <a href="blog-single-sidebar-left.html"
                                                    class="read-more-btn icon-space-left">Read More <span><i
                                                            class="ion-ios-arrow-thin-right"></i></span></a>
                                                <div class="post-meta">
                                                    <a href="#" class="date">24 Apr</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                </div>
                            </div>
                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Slider Section -->
@endsection
