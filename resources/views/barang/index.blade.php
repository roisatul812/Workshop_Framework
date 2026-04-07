@extends('layouts.app')

@section('content')

    <div class="card">
        <div class="card-body">

            <h3 class="mb-4">Data Barang</h3>

            <p class="text-muted">
                Pilih barang yang ingin dicetak tag harganya, lalu tentukan posisi awal label
                pada kertas Tom & Jerry No.108.
            </p>

            <form method="POST" action="{{ url('/cetak-harga') }}">
                @csrf

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead class="table-light">
                            <tr>
                                <th width="60">Pilih</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($data as $b)

                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="barang[]" value="{{ $b->id }}">
                                    </td>

                                    <td>{{ $b->id_barang }}</td>

                                    <td>{{ $b->nama_barang }}</td>

                                    <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <hr class="my-4">

                <div class="row">

                    <div class="col-md-2">

                        <label class="form-label">Posisi X</label>

                        <input type="number" name="x" class="form-control" min="1" max="5" placeholder="1-5" required>

                    </div>

                    <div class="col-md-2">

                        <label class="form-label">Posisi Y</label>

                        <input type="number" name="y" class="form-control" min="1" max="8" placeholder="1-8" required>

                    </div>

                </div>

                <hr class="my-4">

                <h5>Preview Posisi Label</h5>

                <div id="previewGrid" class="preview-grid"></div>

                <br>

                <button class="btn btn-gradient-primary">

                    Cetak Tag Harga

                </button>

            </form>

        </div>
    </div>

@endsection


<style>
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(5, 80px);
        gap: 10px;
        margin-top: 10px;
    }

    .preview-cell {
        width: 80px;
        height: 40px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        background: #f9f9f9;
    }

    .preview-start {
        background: #8e44ad;
        color: white;
        font-weight: bold;
    }
</style>


<script>

    function generatePreview() {

        let x = document.querySelector('input[name="x"]').value;
        let y = document.querySelector('input[name="y"]').value;

        let grid = document.getElementById("previewGrid");

        grid.innerHTML = "";

        for (let i = 1; i <= 40; i++) {

            let cell = document.createElement("div");

            cell.classList.add("preview-cell");

            cell.innerText = i;

            grid.appendChild(cell);

        }

        if (x && y) {

            let posisi = ((y - 1) * 5) + parseInt(x);

            let cells = document.querySelectorAll(".preview-cell");

            if (cells[posisi - 1]) {

                cells[posisi - 1].classList.add("preview-start");

                cells[posisi - 1].innerText = "START";

            }

        }

    }

    document.addEventListener("DOMContentLoaded", function () {

        document.querySelector('input[name="x"]').addEventListener("input", generatePreview);

        document.querySelector('input[name="y"]').addEventListener("input", generatePreview);

        generatePreview();

    });

</script>