<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <ul class="nav">

        <li class="nav-item nav-profile">

            <a href="#" class="nav-link">

                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}">
                </div>

                <div class="nav-profile-text d-flex flex-column">

                    <span class="font-weight-bold mb-2">
                        @auth
                            {{ Auth::user()->name }}
                        @endauth
                    </span>

                    <span class="text-secondary text-small">User</span>

                </div>

            </a>

        </li>

        <li class="nav-item">
            <a class="nav-link" href="/home">

                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>

            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/kategori">
                <span class="menu-title">Kategori</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/buku">
                <span class="menu-title">Buku</span>
                <i class="mdi mdi-book menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/cetak">
                <span class="menu-title">Cetak Data</span>
                <i class="mdi mdi-printer menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/cetak-harga">
                <span class="menu-title">Cetak Harga</span>
                <i class="mdi mdi-tag menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/js-lab') }}">
                <span class="menu-title">Javascript & JQuery Lab</span>
                <i class="mdi mdi-code-tags menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/ajax-lab') }}">
                <span class="menu-title">Ajax Lab</span>
                <i class="mdi mdi-flask-empty menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/vendor') }}">
                <span class="menu-title">Master Vendor</span>
                <i class="mdi mdi-store menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/menu') }}">
                <span class="menu-title">Master Menu</span>
                <i class="menu-icon mdi mdi-food"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('/transaksi') }}">
                <span class="menu-title">Data Transaksi</span>
                <i class="menu-icon mdi mdi-cash"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/customer">
                <span class="menu-title">Customer</span>
                <i class="menu-icon mdi mdi-account"></i>
            </a>
        </li>
    </ul>

</nav>