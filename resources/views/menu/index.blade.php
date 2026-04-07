@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Master Menu</h3>
    </div>


    <div class="card mb-4">
        <div class="card-body">

            <form action="/menu/store" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-3">

                        <select name="vendor_id" class="form-control" required>

                            <option value="">Pilih Vendor</option>

                            @foreach($vendor as $v)

                                <option value="{{ $v->id }}">
                                    {{ $v->nama_vendor }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3">

                        <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu" required>

                    </div>

                    <div class="col-md-3">

                        <input type="number" name="harga" class="form-control" placeholder="Harga" required>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-gradient-primary">
                            Tambah Menu
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

                        <th>Vendor</th>
                        <th>Menu</th>
                        <th>Harga</th>
                        <th width="260">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($menu as $m)
                        <tr>
                            <td>{{ $m->vendor->nama_vendor }}</td>
                            <td>{{ $m->nama_menu }}</td>
                            <td>{{ number_format($m->harga) }}</td>
                            <td style="min-width:240px">
                                <form action="/menu/update/{{ $m->id }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <select name="vendor_id" class="form-control">
                                            @foreach($vendor as $v)
                                                <option value="{{ $v->id }}" @if($m->vendor_id == $v->id) selected @endif>
                                                    {{ $v->nama_vendor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <input type="text" name="nama_menu" value="{{ $m->nama_menu }}" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <input type="number" name="harga" value="{{ $m->harga }}" class="form-control">
                                    </div>
                                    <button class="btn btn-warning btn-sm">
                                        Update
                                    </button>
                                    <a href="/menu/delete/{{ $m->id }}" class="btn btn-danger btn-sm">
                                        Delete
                                    </a>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

@endsection