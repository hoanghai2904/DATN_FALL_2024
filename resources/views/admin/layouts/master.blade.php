<<<<<<< HEAD
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

=======
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

<<<<<<< HEAD
    <meta charset="utf-8" />
    <title>Dashboard | Velzon - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href=" {{ asset('theme/admin/assets/images/favicon.ico') }}">
=======
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc

  <title>{{ config('app.name') }} | @yield('title')</title>

<<<<<<< HEAD
    <!-- jsvectormap css -->
    <link href=" {{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('theme/admin/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('theme/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('theme/admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('theme/admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('theme/admin/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <script src="{{ asset('theme/admin/assets/js/layout2.js') }}"></script> --}}


    @yield('style-libs')
    @stack('style')
=======
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Sweet Alert 2 -->
  <link rel="stylesheet" href="{{ asset('common/css/sweetalert2.min.css') }}">
  <!-- Embed CSS -->
  @yield('embed-css')
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/skin-red.min.css') }}">
  <!-- Custom CSS -->
  @yield('custom-css')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
</head>

<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @include('admin.layouts.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('admin.layouts.sidebar')

<<<<<<< HEAD
        @include('admin.layouts.header')

        <!-- removeNotificationModal -->
        {{-- <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true"> --}}
        {{--    <div class="modal-dialog modal-dialog-centered"> --}}
        {{--        <div class="modal-content"> --}}
        {{--            <div class="modal-header"> --}}
        {{--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button> --}}
        {{--            </div> --}}
        {{--            <div class="modal-body"> --}}
        {{--                <div class="mt-2 text-center"> --}}
        {{--                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon> --}}
        {{--                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5"> --}}
        {{--                        <h4>Are you sure ?</h4> --}}
        {{--                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p> --}}
        {{--                    </div> --}}
        {{--                </div> --}}
        {{--                <div class="d-flex gap-2 justify-content-center mt-4 mb-2"> --}}
        {{--                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button> --}}
        {{--                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button> --}}
        {{--                </div> --}}
        {{--            </div> --}}

        {{--        </div><!-- /.modal-content --> --}}
        {{--    </div><!-- /.modal-dialog --> --}}
        {{-- </div><!-- /.modal --> --}}
        <!-- ========== App Menu ========== -->
        @include('admin.layouts.menu')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
=======
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        @yield('title')
        <small>Control panel</small>
      </h1>
      @yield('breadcrumb')
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('admin.layouts.footer')
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc

</div>
<!-- ./wrapper -->

<<<<<<< HEAD
            @include('admin.layouts.sidebar')
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Velzon.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                {{-- Design & Develop by Themesbrand --}}
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
=======
<!-- REQUIRED JS SCRIPTS -->
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc

<!-- jQuery 3 -->
<script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Sweet Alert 2 -->
<script src="{{ asset('common/js/sweetalert2.min.js') }}"></script>
<!-- Embed JS -->
@yield('embed-js')
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
<!-- Custom JS -->
<script>
  $(document).ready(function(){
    @if(session('alert'))
      Swal.fire(
        '{{ session('alert')['title'] }}',
        '{{ session('alert')['content'] }}',
        '{{ session('alert')['type'] }}'
      )
    @endif

    $('#logout').click(function(){
      Swal.fire({
        title: 'Đăng Xuất',
        text: "Bạn có chắc muốn đăng xuất khỏi hệ thống!",
        type: 'question',
        confirmButtonColor: '#d33',
        confirmButtonText: 'Đăng Xuất',
      }).then((result) => {
        if(result.value)
          document.getElementById('logout-form').submit();
      })
    });
  });

  $(function() {
    $('#sidebar-search-form').on('submit', function(e) {
      e.preventDefault();
    });

    $('.sidebar-menu li.active').data('lte.pushmenu.active', true);

    $('#sidebar-search-form input').on('keyup', function() {
      var term = $(this).val().trim();

<<<<<<< HEAD
    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>
=======
      if (term.length === 0) {
        $('.sidebar-menu li').each(function() {
          $(this).show(0);
          $(this).removeClass('active');
          if ($(this).data('lte.pushmenu.active')) {
            $(this).addClass('active');
          }
        });
        return;
      }
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc

      $('.sidebar-menu li').each(function() {
        if ($(this).text().toLowerCase().indexOf(term.toLowerCase()) === -1) {
          $(this).hide(0);
          $(this).removeClass('pushmenu-search-found', false);

<<<<<<< HEAD
    <!-- JAVASCRIPT -->
    <script src="{{ asset('theme/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/js/plugins.js') }}"></script>

    <!--jquery cdn-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('theme/admin/assets/js/pages/select2.init.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>


    <!-- App js -->
    <script src="{{ asset('theme/admin/assets/js/app.js') }}"></script>
    @stack('script')
=======
          if ($(this).is('.treeview')) {
            $(this).removeClass('active');
          }
        } else {
          $(this).show(0);
          $(this).addClass('pushmenu-search-found');

          if ($(this).is('.treeview')) {
            $(this).addClass('active');
          }

          var parent = $(this).parents('li').first();
          if (parent.is('.treeview')) {
            parent.show(0);
          }
        }

        if ($(this).is('.header')) {
          $(this).show();
        }
      });

      $('.sidebar-menu li.pushmenu-search-found.treeview').each(function() {
        $(this).find('.pushmenu-search-found').show(0);
      });
    });
  });
</script>
@yield('custom-js')
>>>>>>> 1a9bff7e643d48fb179836b504e2e50cad27a7bc
</body>
</html>
