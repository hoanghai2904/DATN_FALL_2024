
<div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('theme/admin/assets/images/logo-dark.png')}}" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('theme/admin/assets/images/logo-light.png')}}" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Quản lý </span></li>
                        <li class="nav-item">
                                    <li class="nav-item">
                                        <a href="{{route('admin.categories.index')}}" class="nav-link" data-key="t-analytics"> Quản lý danh mục </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.products.index')}}" class="nav-link" data-key="t-analytics"> Quản lý sản phẩm</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.banners.listBanner')}}" class="nav-link" data-key="t-analytics"> Quản lý banner </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.orders.index')}}" class="nav-link" data-key="t-analytics"> Quản lý đơn hàng </a>
                                    </li>
                        </li> <!-- end Dashboard Menu -->              
                    </ul>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Tổng quát</span></li>
                      
                                  

                                    <li class="nav-item">
                                        <a href="{{route('admin.brands.index')}}" class="nav-link" data-key="t-ecommerce"> Thương hiệu </a>
                                    </li>
                            
                        </li> <!-- end Dashboard Menu -->              
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>