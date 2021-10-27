<!doctype html>
<html lang="en">
<head>

        <meta charset="utf-8" />

        @include('includes.style')
        @stack('style')
        <style>
            .form-control{
                height: calc(1em + .94rem + 2px);
                padding: 4px 16px;
            }
            #search{
                margin-top: 22px;
            }
            .form-group {
                margin-bottom: .5rem;
            }
        </style>
        <style>
            .nav-pills>li>a, .nav-tabs>li>a{
                color: #191b1f;
            }
            .table{
                color: #000000;
            }
            .table .thead-dark th{
                color: #f6f9ff;
            }

            </style>
    </head>

    {{-- <body data-sidebar="dark" data-sidebar-size="small" class="sidebar-enable vertical-collpsed"> --}}
    <body data-sidebar="dark">
        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('includes.head')
            <!-- ========== Left Sidebar Start ========== -->
            @include('includes.left-sidebar')
            <!-- Left Sidebar End -->
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        @yield('content')

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                @include('includes.footer')
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->
        <!-- JAVASCRIPT -->
        @include('includes.script')
        @stack('script')

    </body>
</html>
