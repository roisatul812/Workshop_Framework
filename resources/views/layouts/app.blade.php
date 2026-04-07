<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Koleksi Buku</title>

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

    @auth
        <!-- ============================= -->
        <!-- Layout jika SUDAH LOGIN -->
        <!-- ============================= -->

        <div class="container-scroller">

            @include('layouts.navbar')

            <div class="container-fluid page-body-wrapper">

                @include('layouts.sidebar')

                <div class="main-panel">

                    <div class="content-wrapper">

                        @yield('content')

                    </div>

                    @include('layouts.footer')

                </div>

            </div>

        </div>

    @else
        <!-- ============================= -->
        <!-- Layout jika BELUM LOGIN -->
        <!-- ============================= -->

        <div class="container-scroller">

            @yield('content')

        </div>

    @endauth


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

    <!-- dashboard -->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

</body>

</html>