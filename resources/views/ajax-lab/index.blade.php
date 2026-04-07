@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Ajax Lab</h3>

        <div class="card">
            <div class="card-body">

                <h5>Deskripsi</h5>

                <p>
                    Halaman ini merupakan bagian dari praktikum pemrograman web
                    untuk mempelajari penggunaan AJAX menggunakan JQuery dan Axios
                    untuk komunikasi data antara client dan server tanpa reload halaman.
                </p>

                <hr>

                <h5>Daftar Studi Kasus</h5>

                <div class="list-group">

                    <a href="{{ url('/ajax-lab/submit') }}" class="list-group-item list-group-item-action">
                        Studi Kasus 1 – AJAX Submit
                    </a>

                    <a href="{{ url('/ajax-lab/wilayah') }}" class="list-group-item list-group-item-action">
                        Studi Kasus 2 – Cascading Wilayah
                    </a>

                    <a href="{{ url('/ajax-lab/axios') }}" class="list-group-item list-group-item-action">
                        Studi Kasus 3 – Axios Request
                    </a>

                </div>

            </div>
        </div>

    </div>

@endsection