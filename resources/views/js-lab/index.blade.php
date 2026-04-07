@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Javascript & JQuery Lab</h3>

        <div class="card">
            <div class="card-body">

                <h5>Deskripsi</h5>

                <p>
                    Halaman ini merupakan bagian dari praktikum pemrograman web yang bertujuan
                    untuk mempelajari penggunaan <b>Javascript</b> dan <b>jQuery</b> dalam memanipulasi
                    elemen HTML secara dinamis tanpa melakukan reload halaman.
                </p>

                <p>
                    Pada modul ini terdapat beberapa studi kasus yang meliputi penggunaan event,
                    manipulasi tabel, penggunaan modal, serta manipulasi elemen form menggunakan
                    Javascript dan jQuery.
                </p>

                <hr>

                <h6>Daftar Studi Kasus</h6>

                <div class="list-group">

                    <a href="/js-lab/spinner" class="list-group-item list-group-item-action">
                        Studi Kasus 1 – Button Spinner
                    </a>

                    <a href="/js-lab/crud" class="list-group-item list-group-item-action">
                        Studi Kasus 2 – CRUD Barang (Javascript Table)
                    </a>

                    <a href="/js-lab/kota" class="list-group-item list-group-item-action">
                        Studi Kasus 3 – Select Kota
                    </a>

                </div>

            </div>
        </div>

    </div>

@endsection