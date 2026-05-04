@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Scan QR Code / Barcode</h4>
                    <p class="card-description">Arahkan kamera ke QR Code atau Barcode</p>

                    <div class="row">
                        <!-- Scanner -->
                        <div class="col-md-5">
                            <div id="reader" style="width:100%; border-radius: 8px; overflow: hidden;"></div>
                        </div>

                        <!-- Hasil -->
                        <div class="col-md-7">
                            <div id="result" style="display:none;">

                                {{-- Hasil Barang --}}
                                <div id="result-barang" style="display:none;">
                                    <div class="alert alert-success" role="alert">
                                        <h5><i class="mdi mdi-check-circle"></i> Barang Ditemukan</h5>
                                    </div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width:35%">ID Barang</th>
                                            <td id="barang-id"></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <td id="barang-nama"></td>
                                        </tr>
                                        <tr>
                                            <th>Harga</th>
                                            <td>Rp <span id="barang-harga"></span></td>
                                        </tr>
                                    </table>
                                </div>

                                {{-- Hasil Pesanan --}}
                                <div id="result-pesanan" style="display:none;">
                                    <div class="alert alert-info" role="alert">
                                        <h5><i class="mdi mdi-receipt"></i> Pesanan Ditemukan</h5>
                                    </div>
                                    <table class="table table-bordered mb-3">
                                        <tr>
                                            <th style="width:35%">ID Pesanan</th>
                                            <td id="pesanan-id"></td>
                                        </tr>
                                        <tr>
                                            <th>Status Bayar</th>
                                            <td>
                                                <span id="pesanan-status" class="badge badge-success p-2"></span>
                                            </td>
                                        </tr>
                                    </table>

                                    <h6 class="mb-2">Detail Menu:</h6>
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Menu</th>
                                                <th>Qty</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pesanan-detail"></tbody>
                                    </table>
                                </div>

                                {{-- Tidak Ditemukan --}}
                                <div id="result-unknown" style="display:none;">
                                    <div class="alert alert-danger" role="alert">
                                        <i class="mdi mdi-alert-circle"></i> Data tidak ditemukan.
                                    </div>
                                </div>

                                <button class="btn btn-outline-secondary btn-sm mt-2" onclick="resetScanner()">
                                    <i class="mdi mdi-qrcode-scan"></i> Scan Lagi
                                </button>

                            </div>

                            {{-- Placeholder sebelum scan --}}
                            <div id="placeholder" class="text-center text-muted mt-5">
                                <i class="mdi mdi-qrcode" style="font-size: 80px; opacity: 0.2;"></i>
                                <p class="mt-2">Hasil scan akan muncul di sini</p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Suara beep -->
    <audio id="beep" src="{{ asset('sounds/beep.mp3') }}" preload="auto"></audio>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode = new Html5Qrcode("reader");

        function startScanner(onSuccess) {
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 220 },
                onSuccess
            );
        }

        function onScanSuccess(decodedText) {
            document.getElementById('beep').play();
            html5QrCode.stop();

            fetch('/scan-all/' + decodedText)
                .then(r => r.json())
                .then(data => {
                    // sembunyikan placeholder
                    document.getElementById('placeholder').style.display = 'none';
                    // reset semua hasil
                    document.getElementById('result-barang').style.display = 'none';
                    document.getElementById('result-pesanan').style.display = 'none';
                    document.getElementById('result-unknown').style.display = 'none';
                    // tampilkan container hasil
                    document.getElementById('result').style.display = 'block';

                    if (data.type === 'barang') {
                        document.getElementById('result-barang').style.display = 'block';
                        document.getElementById('barang-id').textContent = data.id;
                        document.getElementById('barang-nama').textContent = data.nama;
                        document.getElementById('barang-harga').textContent = Number(data.harga).toLocaleString('id-ID');

                    } else if (data.type === 'pesanan') {
                        document.getElementById('result-pesanan').style.display = 'block';
                        document.getElementById('pesanan-id').textContent = data.id;
                        document.getElementById('pesanan-status').textContent = data.status;

                        let rows = '';
                        data.detail.forEach(d => {
                            rows += `<tr>
                            <td>${d.nama_menu}</td>
                            <td>${d.qty}</td>
                            <td>Rp ${Number(d.subtotal).toLocaleString('id-ID')}</td>
                        </tr>`;
                        });
                        document.getElementById('pesanan-detail').innerHTML = rows;

                    } else {
                        document.getElementById('result-unknown').style.display = 'block';
                    }
                });
        }

        function resetScanner() {
            document.getElementById('result').style.display = 'none';
            document.getElementById('placeholder').style.display = 'block';
            document.getElementById('pesanan-detail').innerHTML = '';
            startScanner(onScanSuccess);
        }

        // Mulai scanner saat halaman load
        startScanner(onScanSuccess);
    </script>
@endsection