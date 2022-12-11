<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{$title}}
    </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/css/vendor.bundle.base.css')}}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('skydash/js/select.dataTables.min.css')}}">
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{asset('skydash/vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/select2-bootstrap-theme/select2-bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('skydash/vendors/daterange/daterange.css')}}">

    <link rel="stylesheet" href="{{asset('skydash/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('skydash/vendors/mapboxgl/mapbox-gl.css')}}">
    <!-- End plugin css for this page -->

    <link rel="stylesheet" href="{{asset('skydash/vendors/mdi/css/materialdesignicons.min.css')}}">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('skydash/css/vertical-layout-light/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('skydash/images/favicon.png')}}" />

</head>

<body>
    <div class="lds-circle">
        <div></div>
    </div>
    <div class="container-scroller">
        @include('layout.dashboard.navbar');

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">

            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="ti-settings"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close ti-close"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>Light
                    </div>
                    <div class="sidebar-bg-options" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default"></div>
                    </div>
                </div>
            </div>
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab"
                            aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab"
                            aria-controls="chats-section">CHATS</a>
                    </li>
                </ul>
            </div>
            <!-- partial -->
            @include('layout.dashboard.sidebar')

            <div class="main-panel">

                @yield('dashboardcontent')
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.
                            Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin
                                template</a> from BootstrapDash. All rights reserved.</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made
                            with <i class="ti-heart text-danger ml-1"></i></span>
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a
                                href="https://www.themewagon.com/" target="_blank">Themewagon</a></span>
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{asset('skydash/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('skydash/vendors/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('skydash/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('skydash/vendors/datatables.net/jquery.dataTables.js')}}"></script>
    <script src="{{asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
    <script src="{{asset('skydash/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('skydash/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('skydash/vendors/select2/select2.min.js')}}"></script>

    <script src="{{asset('skydash/vendors/moment/moment.js')}}"></script>
    <script src="{{asset('skydash/vendors/daterange/daterange.js')}}"></script>



    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('skydash/js/off-canvas.js')}}"></script>
    <script src="{{asset('skydash/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('skydash/js/template.js')}}"></script>
    <script src="{{asset('skydash/js/settings.js')}}"></script>
    <script src="{{asset('skydash/js/todolist.js')}}"></script>
    <script src="{{asset('skydash/vendors/mapboxgl/mapbox-gl.js')}}"></script>
    <script src="{{asset('skydash/vendors/sweetalert/sweetalert.all.min.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{asset('skydash/js/dashboard.js')}}"></script>
    <script src="{{asset('skydash/js/Chart.roundedBarCharts.js')}}"></script>
    <script src="{{asset('skydash/js/script.js')}}"></script>
    <!-- End custom js for this page-->
    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                minimumFractionDigits: 0,
                style: "currency",
                currency: "IDR"
            }).format(number);
        }
    </script>
    @isset($script)
    @include($script)
    @endisset
</body>

</html>