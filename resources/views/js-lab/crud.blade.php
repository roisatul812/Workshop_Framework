@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Studi Kasus 2 - CRUD Barang</h3>
        <a href="{{ url('/js-lab') }}" class="btn btn-secondary mb-4">
            ← Kembali
        </a>

        <div class="card mb-4">
            <div class="card-body">

                <h5>Tambah Barang</h5>

                <input type="text" id="namaBarang" class="form-control mb-2" placeholder="Nama Barang">

                <input type="number" id="hargaBarang" class="form-control mb-3" placeholder="Harga Barang">

                <button class="btn btn-success" id="btnTambah">
                    Tambah Barang
                </button>

            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <h5>Data Barang</h5>

                <table class="table table-bordered" id="tableBarang">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>

            </div>
        </div>

    </div>


    <!-- MODAL -->

    <div class="modal fade" id="modalEdit">

        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5>Edit Barang</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="editIndex">

                    <label>Nama</label>
                    <input type="text" id="editNama" class="form-control mb-2">

                    <label>Harga</label>
                    <input type="number" id="editHarga" class="form-control">

                </div>

                <div class="modal-footer">

                    <button class="btn btn-success" id="btnUpdate">
                        Update
                    </button>

                    <button class="btn btn-danger" id="btnDelete">
                        Delete
                    </button>

                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>

                </div>

            </div>
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        let counter = 1;
        let dataBarang = [];

        $("#btnTambah").click(function () {

            let nama = $("#namaBarang").val();
            let harga = $("#hargaBarang").val();

            if (nama == "" || harga == "") {
                alert("Input harus diisi");
                return;
            }

            let barang = {
                id: counter++,
                nama: nama,
                harga: harga
            };

            dataBarang.push(barang);

            renderTable();

            $("#namaBarang").val("");
            $("#hargaBarang").val("");

        });

        function renderTable() {

            let html = "";

            dataBarang.forEach((b, i) => {

                html += `
        <tr class="rowBarang" data-index="${i}">
        <td>${b.id}</td>
        <td>${b.nama}</td>
        <td>${b.harga}</td>
        </tr>
        `;

            });

            $("#tableBarang tbody").html(html);

        }


        $(document).on("click", ".rowBarang", function () {

            let index = $(this).data("index");

            let barang = dataBarang[index];

            $("#editIndex").val(index);
            $("#editNama").val(barang.nama);
            $("#editHarga").val(barang.harga);

            $("#modalEdit").modal("show");

        });


        $("#btnUpdate").click(function () {

            let index = $("#editIndex").val();

            dataBarang[index].nama = $("#editNama").val();
            dataBarang[index].harga = $("#editHarga").val();

            renderTable();

            $("#modalEdit").modal("hide");

        });


        $("#btnDelete").click(function () {

            let index = $("#editIndex").val();

            dataBarang.splice(index, 1);

            renderTable();

            $("#modalEdit").modal("hide");

        });

    </script>

@endsection