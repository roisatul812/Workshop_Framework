@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">

            <h3>Cetak Data</h3>

            <p>
                Halaman ini digunakan untuk mencetak data terbaru dari sistem
                dalam bentuk dokumen PDF.
            </p>

            <form method="POST" action="/cetak">

                @csrf

                <div class="form-group mb-3">

                    <label class="fw-bold text-dark">Cetak Data</label>

                    <select name="data" class="form-select">

                        <option value="buku">Data Buku</option>
                        <option value="kategori">Data Kategori</option>

                    </select>

                </div>


                <div class="form-group mb-3">

                    <label class="fw-bold text-dark">Format Cetak</label>

                    <select name="format" class="form-select">

                        <option value="portrait">Portrait</option>
                        <option value="landscape">Landscape</option>

                    </select>

                </div>

                <button class="btn btn-primary">
                    Cetak PDF
                </button>

            </form>

        </div>
    </div>

@endsection