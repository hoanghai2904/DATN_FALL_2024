<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">@yield('title')</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">@yield('title')</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
{{--    <div class="d-sm-flex align-items-center justify-content-between mb-4">--}}
{{--        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>--}}
{{--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i--}}
{{--                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
{{--    </div>--}}

    {{-- Main content --}}
    @yield('content')
    {{-- End main content --}}
</div>
<!-- End Page-content -->
