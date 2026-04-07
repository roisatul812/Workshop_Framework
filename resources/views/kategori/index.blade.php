@extends('layouts.app')

@section('content')

<div class="card">
<div class="card-body">

<h2 class="card-title">Data Kategori</h2>

<div class="d-flex justify-content-end mb-3">
<a href="/kategori/create" class="btn btn-gradient-primary">
Tambah Kategori
</a>
</div>

<div class="table-responsive">

<table class="table table-bordered">

<thead>
<tr>
<th>No</th>
<th>Nama Kategori</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($kategori as $k)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $k->nama_kategori }}</td>

<td>

<a href="/kategori/{{ $k->id }}/edit"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="/kategori/{{ $k->id }}"
method="POST"
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