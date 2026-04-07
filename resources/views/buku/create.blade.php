@extends('layouts.app')

@section('content')

<div class="card">
<div class="card-body">

<h2 class="card-title">Tambah Buku</h2>

<form action="/buku" method="POST">

@csrf

<div class="form-group">
<label>ID Buku</label>
<input type="text"
name="id_buku"
class="form-control"
placeholder="NV-01">
</div>

<div class="form-group">
<label>Judul Buku</label>
<input type="text"
name="judul"
class="form-control">
</div>

<div class="form-group">
<label>Pengarang</label>
<input type="text"
name="pengarang"
class="form-control">
</div>

<div class="form-group">
<label>Tahun</label>
<input type="number"
name="tahun"
class="form-control">
</div>

<div class="form-group">
<label>Kategori</label>

<select name="kategori_id" class="form-control">

@foreach($kategori as $k)

<option value="{{ $k->idkategori }}">
{{ $k->nama_kategori }}
</option>

@endforeach

</select>

</div>

<div class="mt-3 d-flex gap-2">

<button type="submit"
class="btn btn-gradient-primary">
Simpan
</button>

<a href="/buku"
class="btn btn-secondary">
Kembali
</a>

</div>

</form>

</div>
</div>

@endsection