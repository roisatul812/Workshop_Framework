@extends('layouts.app')

@section('content')

    <div class="page-header">
        <h3 class="page-title">Data Transaksi</h3>
    </div>


    <div class="card">
        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>ID Pesanan</th>
                        <th>Vendor</th>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($pesanan as $p)

                        @foreach($p->detail as $d)

                            <tr>

                                <td>#{{ $p->id }}</td>

                                <td>{{ $d->menu->vendor->nama_vendor }}</td>

                                <td>{{ $d->menu->nama_menu }}</td>

                                <td>{{ $d->qty }}</td>

                                <td>{{ number_format($d->subtotal) }}</td>

                                <td>

                                    @if($p->status_pembayaran == 'lunas')

                                        <span class="badge badge-success">
                                            Lunas
                                        </span>

                                    @else

                                        <span class="badge badge-warning">
                                            Pending
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

@endsection