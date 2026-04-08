@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Tambah Customer 2 (Upload File)</h3>

        <a href="{{ url('/customer') }}" class="btn btn-secondary mb-3">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <form method="POST" action="/customer/store2" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <button class="btn btn-success mt-3">
                        Simpan
                    </button>

                </form>

            </div>
        </div>

    </div>

@endsection