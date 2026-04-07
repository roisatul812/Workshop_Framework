@extends('layouts.guest')

@section('content')

    <div class="container">

        <h3 class="mb-4">Kantin Online</h3>

        <div class="card mb-4">
            <div class="card-body">

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Vendor</th>    
                            <th>Menu</th>
                            <th>Harga</th>
                            <th width="120">Qty</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($menu as $m)

                            <tr>

                                <td>{{ $m->vendor->nama_vendor }}</td>
                                
                                <td>{{ $m->nama_menu }}</td>

                                <td>{{ number_format($m->harga) }}</td>

                                <td>

                                    <form action="/kantin/pesan" method="POST">

                                        @csrf

                                        <input type="hidden" name="menu_id" value="{{ $m->id }}">

                                        <input type="number" name="qty" value="1" min="1" class="form-control">

                                </td>

                                <td>

                                    <button class="btn btn-primary">
                                        Tambah
                                    </button>

                                </td>

                                </form>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>



        {{-- ============================= --}}
        {{-- KERANJANG --}}
        {{-- ============================= --}}

        <div class="card">
            <div class="card-body">

                <h4 class="mb-3">Keranjang</h4>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $total = 0;
                        @endphp

                        @if(session('cart'))

                            @foreach(session('cart') as $item)

                                <tr>

                                    <td>{{ $item['nama'] }}</td>

                                    <td>{{ $item['qty'] }}</td>

                                    <td>{{ number_format($item['subtotal']) }}</td>

                                </tr>

                                @php
                                    $total += $item['subtotal'];
                                @endphp

                            @endforeach

                        @endif

                        <tr>

                            <td colspan="2"><b>Total</b></td>

                            <td><b>{{ number_format($total) }}</b></td>

                        </tr>

                    </tbody>

                </table>


                @if(session('cart'))

                    <form action="/checkout" method="POST">

                        @csrf

                        <button class="btn btn-success">
                            Checkout
                        </button>

                    </form>

                @endif


            </div>
        </div>


    </div>

@endsection