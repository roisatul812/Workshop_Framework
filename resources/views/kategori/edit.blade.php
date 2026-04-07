@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-body">

<h4 class="card-title">Edit Kategori</h4>

<form method="POST" action="/kategori/{{ $kategori->idkategori }}">

@csrf
@method('PUT')

<div class="form-group">

<label>Nama Kategori</label>

<input type="text" name="nama_kategori" class="form-control"
value="{{ $kategori->nama_kategori }}">

</div>

<div class="mt-3 d-flex gap-2">

<button type="submit" class="btn btn-gradient-primary">
Update
</button>

<a href="/kategori" class="btn btn-secondary">
Kembali
</a>

</div>

</form>

</div>

</div>

@endsection