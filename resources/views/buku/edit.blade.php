@extends('layouts.app')

@section('content')

<div class="card">
<div class="card-body">

<h2 class="card-title">Edit Buku</h2>

<form action="/buku/{{ $buku->id_buku }}" method="POST">

@csrf
@method('PUT')

<div class="form-group">
<label>ID Buku</label>
<input type="text"
name="id_buku"
class="form-control"
value="{{ $buku->id_buku }}"
readonly>
</div>

<div class="form-group">
<label>Judul Buku</label>
<input type="text"
name="judul"
class="form-control"
value="{{ $buku->judul }}">
</div>

<div class="form-group">
<label>Pengarang</label>
<input type="text"
name="pengarang"
class="form-control"
value="{{ $buku->pengarang }}">
</div>

<div class="form-group">
<label>Tahun</label>
<input type="number"
name="tahun"
class="form-control"
value="{{ $buku->tahun }}">
</div>

<div class="form-group">
<label>Kategori</label>

<select name="kategori_id" class="form-control">

@foreach($kategori as $k)

<option value="{{ $k->idkategori }}"
{{ $buku->kategori_id == $k->idkategori ? 'selected' : '' }}>

{{ $k->nama_kategori }}

</option>

@endforeach

</select>

</div>

<div class="mt-3 d-flex gap-2">

<button type="submit"
class="btn btn-gradient-primary">
Update
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