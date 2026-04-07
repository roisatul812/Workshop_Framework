@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-md-6 grid-margin stretch-card">

            <div class="card bg-gradient-primary text-white">

                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">
                        Jumlah Buku
                    </h4>

                    <h2 class="mb-0">
                        {{ $jumlahBuku }}
                    </h2>

                </div>

            </div>

        </div>



        <div class="col-md-6 grid-margin stretch-card">

            <div class="card bg-gradient-success text-white">

                <div class="card-body">

                    <h4 class="font-weight-normal mb-3">
                        Jumlah Kategori
                    </h4>

                    <h2 class="mb-0">
                        {{ $jumlahKategori }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

@endsection