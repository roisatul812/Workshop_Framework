@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Scan QR Code</h3>

        <div id="reader" style="width:500px"></div>

    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>

        function onScanSuccess(decodedText, decodedResult) {

            alert("QR Code terbaca: " + decodedText);

            window.location.href = "/kantin/" + decodedText;

        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: 250 }
        );

        html5QrcodeScanner.render(onScanSuccess);

    </script>

@endsection