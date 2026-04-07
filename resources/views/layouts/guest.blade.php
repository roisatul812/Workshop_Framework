<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kantin Digital</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

</head>

<body>

    <div class="container-scroller">

        <!-- NAVBAR -->

        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

            <div class="navbar-brand-wrapper d-flex align-items-center justify-content-start">

                <a class="navbar-brand brand-logo" href="/kantin">
                    Kantin Digital
                </a>

            </div>

            <div class="navbar-menu-wrapper d-flex align-items-stretch">

                <ul class="navbar-nav navbar-nav-right">

                    <li class="nav-item">
                        <a href="/login" class="btn btn-gradient-primary btn-sm">
                            Login
                        </a>
                    </li>

                </ul>

            </div>

        </nav>


        <!-- CONTENT -->

        <div class="container-fluid page-body-wrapper">

            <div class="main-panel" style="width:100%">

                <div class="content-wrapper">

                    @yield('content')

                </div>

            </div>

        </div>

    </div>


    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Plugin js -->
    <script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>

</body>

</html>