<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        
                        <span class="logo-sm">
                            <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('theme/admin/assets/images/logo-dark.png')}}" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('theme/admin/assets/images/logo-sm.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('theme/admin/assets/images/logo-light.png')}}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if(auth()->check())
                            {{-- Nếu người dùng đã đăng nhập --}}
                            @if(auth()->user()->cover)
                                {{-- Nếu người dùng có ảnh đại diện, hiển thị ảnh --}}
                                <img class="rounded-circle header-profile-user" src="{{ asset('storage/' . auth()->user()->cover) }}" alt="Avatar">
                            @else
                                {{-- Nếu không có ảnh đại diện, hiển thị biểu tượng người dùng --}}
                                <i class="icon-user"></i>
                            @endif
                        @else
                            {{-- Nếu người dùng chưa đăng nhập, hiển thị biểu tượng người dùng --}}
                            <i class="icon-user"></i>
                        @endif
                        
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->full_name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text badge bg-success-subtle text-success">Role user</span>
                              
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome{{ Auth::user()->full_name }}</h6>
                        <a class="dropdown-item" href="{{route('admin.profile')}}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Tài Khoản</span></a>
                        <a class="dropdown-item" href="{{asset('theme/admin/apps-chat.html')}}"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="{{asset('theme/admin/apps-tasks-kanban.html')}}"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('admin.logout')}}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Đăng xuất</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>