<header class="main-header">

  <!-- Logo -->
  <a href="{{ route('admin.dashboard') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>V</b>DO</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Admin</b> {{ config('app.name') }}</span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="javascript:void(0);" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
          <!-- Menu toggle button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">0</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 0 messages</li>
            <li>
              <!-- inner menu: contains the messages -->
              <ul class="menu">
                <!-- message -->
              </ul>
              <!-- /.menu -->
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li>
        <!-- /.messages-menu -->

        <!-- Notifications Menu -->
        <li class="dropdown notifications-menu">
          <!-- Menu toggle button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">0</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 0 notifications</li>
            <li>
              <!-- Inner Menu: contains the notifications -->
              <ul class="menu">
                <!-- notification -->
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        <!-- Tasks Menu -->
        <li class="dropdown tasks-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o"></i>
            <span class="label label-info">0</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 0 tasks</li>
            <li>
              <!-- Inner menu: contains the tasks -->
              <ul class="menu">
                <!-- task item -->
              </ul>
            </li>
            <li class="footer">
              <a href="#">View all tasks</a>
            </li>
          </ul>
        </li>
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ Helper::get_image_avatar_url(Auth::user()->avatar_image) }}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ Helper::get_image_avatar_url(Auth::user()->avatar_image) }}" class="img-circle" alt="User Image">

<<<<<<< HEAD
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
=======
              <p>
                {{ Auth::user()->name }}
                <small>{{ Auth::user()->email }}</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a id="logout" href="#" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </ul>
        </li>
      </ul>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
    </div>
  </nav>
</header>
