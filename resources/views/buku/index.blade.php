@extends('layouts.app')

@section('content')

<div class="card">
<div class="card-body">

<h2 class="card-title">Data Buku</h2>

<div class="d-flex justify-content-end mb-3">
<a href="/buku/create" class="btn btn-gradient-primary">
Tambah Buku
</a>
</div>

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
<th>ID Buku</th>
<th>Judul</th>
<th>Pengarang</th>
<th>Tahun</th>
<th>Kategori</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($buku as $b)

<tr>

<td>{{ $b->id_buku }}</td>
<td>{{ $b->judul }}</td>
<td>{{ $b->pengarang }}</td>
<td>{{ $b->tahun }}</td>
<td>{{ $b->kategori->nama_kategori ?? '-' }}</td>

<td>

<a href="/buku/{{ $b->id_buku }}/edit"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="/buku/{{ $b->id_buku }}" method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>
</div>

@endsection