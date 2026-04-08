@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')
@section('content')

    <div class="page-header">
        <h3 class="page-title">Data Customer</h3>
    </div>

    <div class="card">
        <div class="card-body">

            <a href="/customer/create1" class="btn btn-primary mb-3">
                Tambah Customer 1
            </a>

            <a href="/customer/create2" class="btn btn-success mb-3">
                Tambah Customer 2
            </a>

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Foto</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($customer as $c)

                        <tr>

                            <td>{{ $c->id }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>

                            <td>

                                @if(Str::startsWith($c->foto, 'data:image'))

                                    <img src="{{ $c->foto }}" width="60" style="border-radius:50%">

                                @else

                                    <img src="{{ url($c->foto) }}" width="60" style="border-radius:50%">

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

@endsection