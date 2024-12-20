<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->

        <!-- Light Logo-->
        <a href="#" class="logo logo-light">

            <span class="logo-lg">
                <img src="{{ asset('theme/admin/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Tổng quát</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Bảng thống kê</span>
                    </a>

                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">Tổng quát</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link"> Thống kê theo vv...</a>
                            </li>
                        </ul>
                    </div>

                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories_.index') }}" class="nav-link menu-link" href="#"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Quản lý danh mục</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.brands.index') }}"
                        aria-controls="sidebarDashboards">
                        <i class="ri-pencil-fill"></i> <span data-key="t-dashboards">Quản lý thương hiệu</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#product" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-fridge-fill"></i> <span data-key="t-dashboards">Sản phẩm</span>
                    </a>

                    <div class="collapse menu-dropdown" id="product">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.products.index') }}" class="nav-link" data-key="t-analytics">
                                    Quản lý sản phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.variants.index') }}" class="nav-link" data-key="t-analytics">
                                    Quản lý biến thể</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.banners.listBanner') }}"
                        aria-controls="sidebarDashboards">
                        <i class=" las la-photo-video"></i> <span data-key="t-dashboards">Quản lý banner</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.orders.index') }}"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Quản lý đơn hàng</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.contacts.index') }}"
                        aria-controls="sidebarDashboards">
                        <i class="ri-phone-fill"></i> <span data-key="t-dashboards">Quản lý liên hệ</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.vouchers.index') }}"
                        aria-controls="sidebarDashboards">
                        <i class="ri-gift-2-fill"></i> <span data-key="t-dashboards">Quản lý khuyến mại</span>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.vouchers.index') }}" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-gift-2-fill"></i> <span data-key="t-dashboards">Quản lý khuyến mại</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sale">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{route('admin.vouchers.index')}}" class="nav-link">Nếu có thì làm dropdow</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#news" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-book-mark-fill"></i> <span data-key="t-dashboards">Bài viết</span>
                    </a>
                    <div class="collapse menu-dropdown" id="news">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.postcategories.listPostCategory') }}" class="nav-link">Quản
                                    lý danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.posts.index') }}" class="nav-link">Quản lý bài viết</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#user" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class=" ri-group-fill"></i> <span data-key="t-dashboards">User</span>
                    </a>
                    <div class="collapse menu-dropdown" id="user">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('admin.listRole') }}" class="nav-link">Quản lý phân quyền</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.listCusstomer') }}" class="nav-link">Quản lý người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.listUser') }}" class="nav-link">Quản lý nhân viên</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.comments.listComment') }}"
                        aria-controls="sidebarDashboards">
                        <i class="bx bx-message-detail"></i> <span data-key="t-dashboards">Quản lý Bình Luận</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <!-- Sidebar -->
</div>

<div class="sidebar-background"></div>
</div>
