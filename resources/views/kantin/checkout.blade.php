@extends('layouts.guest')

@section('content')

    <div class="container">

        <h3 class="mb-4">Checkout Pembayaran</h3>

        <div class="card">
            <div class="card-body">

                <table class="table">

                    <tr>
                        <td>ID Pesanan</td>
                        <td>{{ $pesanan->id }}</td>
                    </tr>

                    <tr>
                        <td>Total Pembayaran</td>
                        <td><b>Rp {{ number_format($pesanan->total) }}</b></td>
                    </tr>

                </table>

                <button id="pay-button" class="btn btn-success">
                    Bayar Sekarang
                </button>

            </div>
        </div>

    </div>


    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"> </script>


    <script>

        document.getElementById('pay-button').onclick = function () {

            snap.pay('{{ $pesanan->snap_token }}', {

                onSuccess: function (result) {

                    alert("Pembayaran berhasil");

                    window.location.href = "/kantin";

                },

                onPending: function (result) {

                    alert("Menunggu pembayaran");

                },

                onError: function (result) {

                    alert("Pembayaran gagal");

                }

            });

        };

    </script>

@endsection