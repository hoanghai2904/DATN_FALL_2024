<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from htmldemo.hasthemes.com/hono/hono/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 06 Jan 2021 00:31:46 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>HONO - Multi Purpose HTML Template</title>
    
    <!-- ::::::::::::::Favicon icon::::::::::::::-->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.ico" type="image/png">

    <!-- ::::::::::::::All CSS Files here :::::::::::::: -->
    <!-- Minified CSS for better performance -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vendor/vendor.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />

    <!-- jQuery, Popper, and Bootstrap for modal support -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <header class="header-section d-none d-xl-block">
        <div class="header-wrapper">
            <!-- Start Header Top -->
            <div class="header-top header-top-bg--black section-fluid">
                <div class="container">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <div class="header-top-left">
                            <div class="header-top-contact header-top-contact-color--white header-top-contact-hover-color--green">
                                <a href="tel:(+800)345678" class="icon-space-right"><i class="icon-call-in"></i>(+800) 345 678</a>
                                <a href="mailto:support@plazathemes.com" class="icon-space-right"><i class="icon-envelope"></i>Support@plazathemes.com</a>
                            </div>
                        </div>
                        <div class="header-top-right">
                            <div class="header-top-user-link header-top-user-link-color--white header-top-user-link-hover-color--green">
                                @auth
                                    <span>Xin chào: {{ Auth::user()->full_name }}</span>  
                                @else
                                    <a href="{{ route('account.login') }}">Đăng nhập</a> 
                                    <a href="{{ route('account.rigester') }}">Đăng kí</a>
                                @endauth
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
             <!-- End Header Top -->
            <!-- Start Header Bottom -->
            <div class="header-bottom header-bottom-color--green section-fluid sticky-header sticky-color--white">
                <div class="container">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-between">
                             <!-- Start Header Logo -->
                            <div class="header-logo">
                                <div class="logo">
                                    <a href="{{route('home.index')}}"><img src="{{ asset('assets') }}/images/logo/logo_black.png" alt=""></a>
                                </div>
                            </div>
                            <!-- End Header Logo -->

                            <!-- Start Header Main Menu -->
                            <div class="main-menu menu-color--black menu-hover-color--green">
                                <nav>
                                    <ul>
                                        <li class="has-dropdown">
                                            <a class="active main-menu-link" href="index.html">Trag chủ <i class="fa fa-angle-down"></i></a>
                                            <!-- Sub Menu -->
                                            <ul class="sub-menu">
                                                <li><a href="index.html">Home 1</a></li>
                                                <li><a href="index-2.html">Home 2</a></li>
                                                <li><a href="index-3.html">Home 3</a></li>
                                                <li><a href="index-4.html">Home 4</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown has-megaitem">
                                            <a href="product-details-default.html">Shop <i class="fa fa-angle-down"></i></a>
                                            <!-- Mega Menu -->
                                            <div class="mega-menu">
                                                <ul class="mega-menu-inner">
                                                    <!-- Mega Menu Sub Link -->
                                                    <li class="mega-menu-item">
                                                        <a href="#" class="mega-menu-item-title">Shop Layouts</a>
                                                        <ul class="mega-menu-sub">
                                                            <li><a href="shop-grid-sidebar-left.html">Grid Left Sidebar</a></li>
                                                            <li><a href="shop-grid-sidebar-right.html">Grid Right Sidebar</a></li>
                                                            <li><a href="shop-full-width.html">Full Width</a></li>
                                                            <li><a href="shop-list-sidebar-left.html">List Left Sidebar</a></li>
                                                            <li><a href="shop-list-sidebar-right.html">List Right Sidebar</a></li>
                                                        </ul>
                                                    </li>
                                                    <!-- Mega Menu Sub Link -->
                                                    <li class="mega-menu-item">
                                                        <a href="#" class="mega-menu-item-title">Other Pages</a>
                                                        <ul class="mega-menu-sub">
                                                            <li><a href="cart.html">Cart</a></li>
                                                            <li><a href="empty-cart.html">Cart</a></li>
                                                            <li><a href="wishlist.html">Wishlist</a></li>
                                                            <li><a href="compare.html">Compare</a></li>
                                                            <li><a href="checkout.html">Checkout</a></li>
                                                            <li><a href="{{ route('account.login') }}">Login</a></li>
                                                            <li><a href="my-account.html">My Account</a></li>
                                                        </ul>
                                                    </li>
                                                    <!-- Mega Menu Sub Link -->
                                                    <li class="mega-menu-item">
                                                        <a href="#" class="mega-menu-item-title">Product Types</a>
                                                        <ul class="mega-menu-sub">
                                                            <li><a href="product-details-default.html">Product Default</a></li>
                                                            <li><a href="product-details-variable.html">Product Variable</a></li>
                                                            <li><a href="product-details-affiliate.html">Product Referral</a></li>
                                                            <li><a href="product-details-group.html">Product Group</a></li>
                                                            <li><a href="product-details-single-slide.html">Product Slider</a></li>
                                                        </ul>
                                                    </li>
                                                    <!-- Mega Menu Sub Link -->
                                                    <li class="mega-menu-item">
                                                        <a href="#" class="mega-menu-item-title">Product Types</a>
                                                        <ul class="mega-menu-sub">
                                                            <li><a href="product-details-tab-left.html">Product Tab Left</a></li>
                                                            <li><a href="product-details-tab-right.html">Product Tab Right</a></li>
                                                            <li><a href="product-details-gallery-left.html">Product Gallery Left</a></li>
                                                            <li><a href="product-details-gallery-right.html">Product Gallery Right</a></li>
                                                            <li><a href="product-details-sticky-left.html">Product Sticky Left</a></li>
                                                            <li><a href="product-details-sticky-right.html">Product Sticky right</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <div class="menu-banner">
                                                    <a href="#" class="menu-banner-link">
                                                        <img class="menu-banner-img" src="{{ asset('assets') }}/images/banner/menu-banner.jpg" alt="">
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="blog-single-sidebar-left.html">Tin tức <i class="fa fa-angle-down"></i></a>
                                            <!-- Sub Menu -->
                                            <ul class="sub-menu">
                                                <li><a href="blog-grid-sidebar-left.html">Blog Grid Sidebar left</a></li>
                                                <li><a href="blog-grid-sidebar-right.html">Blog Grid Sidebar Right</a></li>
                                                <li><a href="blog-full-width.html">Blog Full Width</a></li>
                                                <li><a href="blog-list-sidebar-left.html">Blog List Sidebar Left</a></li>
                                                <li><a href="blog-list-sidebar-right.html">Blog List Sidebar Right</a></li>
                                                <li><a href="blog-single-sidebar-left.html">Blog Single Sidebar left</a></li>
                                                <li><a href="blog-single-sidebar-right.html">Blog Single Sidebar Right</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-dropdown">
                                            <a href="#">Pages <i class="fa fa-angle-down"></i></a>
                                            <!-- Sub Menu -->
                                            <ul class="sub-menu">
                                                <li><a href="faq.html">Frequently Questions</a></li>
                                                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                                                <li><a href="404.html">404 Page</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="about-us.html">Giới thiệu</a>
                                        </li>
                                        <li>
                                            <a href="contact-us.html">Liên hệ</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div> 
                            <!-- End Header Main Menu Start -->
                            
                            <!-- Start Header Action Link -->
                            <ul class="header-action-link action-color--black action-hover-color--green">
                                <li>
                                    <a  href="#offcanvas-wishlish" class="offcanvas-toggle">
                                        <i class="icon-heart"></i>
                                        <span class="item-count">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#offcanvas-add-cart" class="offcanvas-toggle">
                                        <i class="icon-bag"></i>
                                        <span class="item-count">3</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('account.profile') }}">
                                        @if(auth()->check())
                                            @if(auth()->user()->cover)
                                                <img src="{{ asset('storage/' . auth()->user()->cover) }}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%;">
                                            @else
                                                <i class="icon-user"></i>
                                            @endif
                                        @else
                                            <i class="icon-user"></i>
                                        @endif
                                    </a>
                                </li>
                                
                               
                            </ul>
                            <!-- End Header Action Link -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Header Bottom -->
        </div>
    </header>
    <div class="breadcrumb-section breadcrumb-bg-color--golden">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="breadcrumb-title">Blog Grid - Left Sidebar</h3>
                        <div class="breadcrumb-nav breadcrumb-nav-color--black breadcrumb-nav-hover-color--golden">
                            <nav aria-label="breadcrumb">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="blog-grid-sidebar-left.html">Blog</a></li>
                                    <li class="active" aria-current="page">Blog Grid Left Sidebar</li>
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
                            <div class="sidebar-single-widget" >
                                <h6 class="sidebar-title">Search</h6>
                                <div class="default-search-style d-flex">
                                    <input class="default-search-style-input-box" type="search" placeholder="Search..." required>
                                    <button class="default-search-style-input-btn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
    
                            <!-- Start Single Sidebar Widget -->
                            <div class="sidebar-single-widget" >
                                <h6 class="sidebar-title">CATEGORIES</h6>
                                <div class="sidebar-content">
                                    <ul class="sidebar-menu">
                                       <li ><a href="#">Audio</a></li>
                                       <li ><a href="#">Company</a></li>   
                                       <li ><a href="#">Gallery</a></li>   
                                       <li ><a href="#">Other</a></li>   
                                       <li ><a href="#">Travel</a></li>   
                                       <li ><a href="#"> Uncategorized</a></li>   
                                       <li ><a href="#"> Video</a></li>   
                                       <li ><a href="#">Wordpress</a></li>
                                    </ul>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
    
                            <!-- Start Single Sidebar Widget -->
                            <div class="sidebar-single-widget">
                                <h6 class="sidebar-title">Tags</h6>
                                <div class="sidebar-content">
                                    <div class="tag-link">
                                        <a href="#">Technology</a>
                                        <a href="#">Information</a>
                                        <a href="#">Wordpress</a>
                                        <a href="#">Devs</a>
                                        <a href="#">Program</a>
                                    </div>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
    
                            <!-- Start Single Sidebar Widget --> 
                            <div class="sidebar-single-widget" >
                                <h6 class="sidebar-title">Meta</h6>
                                <div class="sidebar-content">
                                    <ul class="sidebar-menu">
                                       <li ><a href="#">Log in</a></li>
                                       <li ><a href="#">Entries feed</a></li>   
                                       <li ><a href="#">Comments feed</a></li>   
                                       <li ><a href="#">WordPress.org</a></li>
                                    </ul>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
    
                            <!-- Start Single Sidebar Widget -->
                            <div class="sidebar-single-widget" >
                                <h6 class="sidebar-title">PRODUCT CATEGORIES</h6>
                                <div class="sidebar-content">
                                    <ul class="sidebar-menu">
                                        <li>
                                            <ul class="sidebar-menu-collapse">
                                                <!-- Start Single Menu Collapse List -->
                                               <li class="sidebar-menu-collapse-list">
                                                   <div class="accordion">
                                                       <a href="#" class="accordion-title collapsed" data-bs-toggle="collapse" data-bs-target="#men-fashion" aria-expanded="false">Men <i class="ion-ios-arrow-right"></i></a>
                                                       <div id="men-fashion" class="collapse">
                                                           <ul class="accordion-category-list">
                                                               <li><a href="#">Dresses</a></li>
                                                               <li><a href="#">Jackets &amp; Coats</a></li>
                                                               <li><a href="#">Sweaters</a></li>
                                                               <li><a href="#">Jeans</a></li>
                                                               <li><a href="#">Blouses &amp; Shirts</a></li>
                                                           </ul>
                                                       </div>
                                                   </div>
                                               </li> <!-- End Single Menu Collapse List -->
                                           </ul>
                                        </li>
                                       <li ><a href="#">Football</a></li>   
                                       <li ><a href="#"> Men's</a></li>   
                                       <li ><a href="#"> Portable Audio</a></li>   
                                       <li ><a href="#"> Smart Watches</a></li>   
                                       <li ><a href="#">Tennis</a></li>   
                                       <li ><a href="#"> Uncategorized</a></li>   
                                       <li ><a href="#"> Video Games</a></li>   
                                       <li ><a href="#">Women's</a></li>
                                    </ul>
                                </div>
                            </div> <!-- End Single Sidebar Widget -->
    
                        </div> <!-- End Sidebar Area -->
                    </div>
                    <div class="col-lg-9">
                        <div class="blog-wrapper">
                            <div class="row mb-n6">
                                <div class="col-md-6 col-12 mb-6">
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-list blog-grid-single-item blog-color--golden"  data-aos="fade-up"  data-aos-delay="0">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid" src="assets/images/blog/blog-grid-home-1-img-1.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <ul class="post-meta">
                                               <li>POSTED BY : <a href="#" class="author">Admin</a></li> 
                                               <li>ON : <a href="#" class="date">APRIL 24, 2018</a></li> 
                                            </ul>
                                            <h6 class="title"><a href="blog-single-sidebar-left.html"> Blog image post</a></h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <a href="#" class="read-more-btn icon-space-left">Read More <span class="icon"><i class="ion-ios-arrow-thin-right"></i></span></a>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                </div>
                                <div class="col-md-6 col-12 mb-6">
                                    <!-- Start Product Default Single Item -->
                                    <div class="blog-list blog-grid-single-item blog-color--golden"  data-aos="fade-up"  data-aos-delay="0">
                                        <div class="image-box">
                                            <a href="blog-single-sidebar-left.html" class="image-link">
                                                <img class="img-fluid" src="assets/images/blog/blog-grid-home-1-img-5.jpg" alt="">
                                            </a>
                                        </div>
                                        <div class="content">
                                            <ul class="post-meta">
                                               <li>POSTED BY : <a href="#" class="author">Admin</a></li> 
                                               <li>ON : <a href="#" class="date">APRIL 24, 2018</a></li> 
                                            </ul>
                                            <h6 class="title"><a href="blog-single-sidebar-left.html"> Blog image post</a></h6>
                                            <p>Donec vitae hendrerit arcu, sit amet faucibus nisl. Cras pretium arcu ex. Aenean posuere libero eu augue condimentum rhoncus. Praesent</p>
                                            <a href="#" class="read-more-btn icon-space-left">Read More <span class="icon"><i class="ion-ios-arrow-thin-right"></i></span></a>
                                        </div>
                                    </div>
                                    <!-- End Product Default Single Item -->
                                </div>
                            </div>
                        </div>
    
                        <!-- Start Pagination -->
                        <div class="page-pagination text-center" data-aos="fade-up"  data-aos-delay="0">
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
        </div> <!-- ...:::: End Blog List Section:::... -->
    <footer class="footer-section footer-bg section-top-gap-100">
        <div class="footer-wrapper">
         <!-- Start Footer Top -->
        <div class="footer-top">
         <div class="container">
             <div class="row mb-n6">
                 <div class="col-lg-3 col-sm-6 mb-6">
                     <!-- Start Footer Single Item -->
                     <div class="footer-widget-single-item footer-widget-color--green"  data-aos="fade-up"  data-aos-delay="0">
                         <h5 class="title">INFORMATION</h5>
                         <ul class="footer-nav">
                             <li><a href="#">Delivery Information</a></li>
                             <li><a href="#">Terms & Conditions</a></li>
                             <li><a href="contact-us.html">Contact</a></li>
                             <li><a href="#">Returns</a></li>
                         </ul>
                     </div>
                       <!-- End Footer Single Item -->
                 </div>
                 <div class="col-lg-3 col-sm-6 mb-6">
                     <!-- Start Footer Single Item -->
                     <div class="footer-widget-single-item footer-widget-color--green"  data-aos="fade-up"  data-aos-delay="200">
                         <h5 class="title">MY ACCOUNT</h5>
                         <ul class="footer-nav"> 
                             <li><a href="my-account.html">My account</a></li>
                             <li><a href="wishlist.html">Wishlist</a></li>
                             <li><a href="privacy-policy.html">Privacy Policy</a></li>
                             <li><a href="faq.html">Frequently Questions</a></li>
                             <li><a href="#">Order History</a></li>
                         </ul>
                     </div>
                       <!-- End Footer Single Item -->
                 </div>
                 <div class="col-lg-3 col-sm-6 mb-6">
                     <!-- Start Footer Single Item -->
                     <div class="footer-widget-single-item footer-widget-color--green"  data-aos="fade-up"  data-aos-delay="400">
                         <h5 class="title">CATEGORIES</h5>
                         <ul class="footer-nav">
                             <li><a href="#">Decorative</a></li>
                             <li><a href="#">Kitchen utensils</a></li>
                             <li><a href="#">Chair & Bar stools</a></li>
                             <li><a href="#">Sofas and Armchairs</a></li>
                             <li><a href="#">Interior lighting</a></li>
                         </ul>
                     </div>
                       <!-- End Footer Single Item -->
                 </div>
                 <div class="col-lg-3 col-sm-6 mb-6">
                     <!-- Start Footer Single Item -->
                     <div class="footer-widget-single-item footer-widget-color--green"  data-aos="fade-up"  data-aos-delay="600">
                         <h5 class="title">ABOUT US</h5>
                         <div class="footer-about">
                             <p>We are a team of designers and developers that create high quality Magento, Prestashop, Opencart.</p>
                             
                             <address>
                                  <span>Address: 4710-4890 Breckinridge St, Fayettevill</span> 
                                  <span>Email: yourmail@mail.com</span>    
                             </address>
                         </div>
                     </div>
                       <!-- End Footer Single Item -->
                 </div>
             </div>
         </div>
         </div>
         <!-- End Footer Top -->
 
         <!-- Start Footer Center -->
         <div class="footer-center">
             <div class="container">
                 <div class="row mb-n6">
                     <div class="col-xl-3 col-lg-4 col-md-6 mb-6">
                         <div class="footer-social"  data-aos="fade-up"  data-aos-delay="0">
                             <h4 class="title">FOLLOW US</h4>
                             <ul class="footer-social-link">
                                 <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                 <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                 <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                 <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                             </ul>
                         </div>
                     </div>
                     <div class="col-xl-7 col-lg-6 col-md-6 mb-6">
                         <div class="footer-newsletter"  data-aos="fade-up"  data-aos-delay="200">
                             <h4 class="title">DON'T MISS OUT ON THE LATEST</h4>
                             <div class="form-newsletter">
                                 <form action="#" method="post">
                                     <div class="form-fild-newsletter-single-item input-color--green">
                                         <input type="email" placeholder="Your email address..." required>
                                         <button type="submit">SUBSCRIBE!</button>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Start Footer Center -->
 
         <!-- Start Footer Bottom -->
         <div class="footer-bottom">
             <div class="container">
                 <div class="row justify-content-between align-items-center align-items-center flex-column flex-md-row mb-n6">
                     <div class="col-auto mb-6">
                         <div class="footer-copyright">
                             <p> COPYRIGHT &copy; <a href="https://hasthemes.com/" target="_blank">HasThemes</a>. ALL RIGHTS RESERVED.</p>
                         </div>
                     </div>
                     <div class="col-auto mb-6">
                         <div class="footer-payment">
                             <div class="image">
                                 <img src="{{ asset('assets') }}/images/company-logo/payment.png" alt="">
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <!-- Start Footer Bottom -->
        </div>
    </footer>
    
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