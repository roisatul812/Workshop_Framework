@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Studi Kasus 1 - Button Spinner</h3>
        <a href="{{ url('/js-lab') }}" class="btn btn-secondary mb-4">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <p>
                    Button spinner digunakan untuk memberikan informasi kepada pengguna bahwa
                    proses sedang berjalan sehingga mencegah pengguna melakukan klik berulang.
                </p>

                <input type="text" id="nama" class="form-control mb-3" placeholder="Masukkan nama">

                <button class="btn btn-gradient-primary" id="btnSubmit">
                    Submit
                </button>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $("#btnSubmit").click(function () {

            if ($("#nama").val() == "") {
                alert("Nama harus diisi");
                return;
            }

            $(this).text("Loading...");
            $(this).prop("disabled", true);

        });

    </script>

@endsection