@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Master Vendor</h3>
    </div>


    <div class="card mb-4">
        <div class="card-body">

            <form action="/vendor/store" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-4">
                        <input type="text" name="nama_vendor" class="form-control" placeholder="Nama Vendor" required>
                    </div>

                    <div class="col-md-4">
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-gradient-primary">
                            Tambah Vendor
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Nama Vendor</th>
                        <th>Deskripsi</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($vendor as $v)

                        <tr>

                            <td>{{ $v->nama_vendor }}</td>

                            <td>{{ $v->deskripsi }}</td>

                            <td>

                                <form action="/vendor/update/{{ $v->id }}" method="POST" style="display:inline">

                                    @csrf

                                    <input type="text" name="nama_vendor" value="{{ $v->nama_vendor }}">
                                    <input type="text" name="deskripsi" value="{{ $v->deskripsi }}">

                                    <button class="btn btn-warning btn-sm">
                                        Update
                                    </button>

                                </form>

                                <a href="/vendor/delete/{{ $v->id }}" class="btn btn-danger btn-sm">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

@endsection