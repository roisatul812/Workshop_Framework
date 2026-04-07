@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Studi Kasus 3 - Select Kota</h3>
        <a href="{{ url('/js-lab') }}" class="btn btn-secondary mb-4">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <input type="text" id="inputKota" class="form-control mb-2" placeholder="Masukkan kota">

                <button class="btn btn-primary mb-3" id="btnTambahKota">
                    Tambah Kota
                </button>

                <select id="selectKota" class="form-control mb-3">
                    <option value="">Pilih Kota</option>
                </select>

                <p>Kota terpilih: <b id="kotaTerpilih">-</b></p>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        $("#btnTambahKota").click(function () {

            let kota = $("#inputKota").val();

            if (kota == "") {
                alert("Isi kota dulu");
                return;
            }

            $("#selectKota").append(`<option>${kota}</option>`);

            $("#inputKota").val("");

        });


        $("#selectKota").change(function () {

            $("#kotaTerpilih").text($(this).val());

        });

    </script>

@endsection