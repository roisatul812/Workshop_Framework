@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- CARD: LIST TOKO --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">List Toko</h4>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Barcode</th>
                            <th>Nama Toko</th>
                            <th>Alamat</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Accuracy (m)</th>
                            <th>Cetak Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tokos as $toko)
                            <tr>
                                <td>{{ $toko->barcode }}</td>
                                <td>{{ $toko->nama_toko }}</td>
                                <td>{{ $toko->alamat ?? '-' }}</td>
                                <td>{{ $toko->latitude }}</td>
                                <td>{{ $toko->longitude }}</td>
                                <td>{{ $toko->accuracy }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"
                                        onclick="cetakBarcode('{{ $toko->barcode }}', '{{ $toko->nama_toko }}', '{{ $toko->barcode_img }}')">
                                        <i class="mdi mdi-printer"></i> Cetak
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data toko.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- CARD: INPUT TOKO BARU --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">Input Titik Awal Toko</h4>
            <p class="text-muted">Ambil lokasi GPS toko, lalu simpan ke database.</p>

            <form action="{{ route('kunjungan.storeToko') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label>Nama Toko</label>
                    <input type="text" name="nama_toko" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control">
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Latitude</label>
                        <input type="text" id="lat-toko" name="latitude" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Longitude</label>
                        <input type="text" id="lng-toko" name="longitude" class="form-control" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label>Accuracy (meter)</label>
                        <input type="text" id="acc-toko" name="accuracy" class="form-control" readonly required>
                    </div>
                </div>

                <div class="mb-3">
                    <button type="button" class="btn btn-gradient-primary" onclick="ambilLokasiToko()">
                        <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi GPS
                    </button>
                    <span id="status-lokasi-toko" class="ms-2 text-muted"></span>
                </div>

                <button type="submit" class="btn btn-gradient-success" id="btn-submit-toko" disabled>
                    Simpan Toko
                </button>

            </form>

        </div>
    </div>

    {{-- CARD: KUNJUNGAN SALES --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">Titik Kunjungan Sales</h4>
            <p class="text-muted">Scan barcode toko, lalu ambil lokasi GPS kamu saat ini.</p>

            {{-- Scanner Barcode --}}
            <div class="mb-3">
                <label>Scan Barcode Toko</label>
                <div id="reader" style="width:100%; max-width:400px;"></div>
                <div class="mt-2">
                    <label>Atau ketik barcode manual:</label>
                    <div class="input-group" style="max-width:400px;">
                        <input type="text" id="input-barcode-manual" class="form-control" placeholder="Masukkan barcode...">
                        <button class="btn btn-outline-primary" onclick="cariBarcode()">Cari</button>
                    </div>
                </div>
            </div>

            {{-- Info Toko dari hasil scan --}}
            <div id="info-toko" class="alert alert-info d-none mb-3">
                <strong>Toko ditemukan:</strong><br>
                Nama: <span id="scan-nama"></span><br>
                Alamat: <span id="scan-alamat"></span><br>
                Lat/Lng: <span id="scan-latlng"></span><br>
                Accuracy Toko: <span id="scan-acc"></span> m
            </div>

            {{-- Ambil lokasi sales --}}
            <div class="mb-3">
                <button type="button" class="btn btn-gradient-primary" id="btn-ambil-sales" onclick="ambilLokasiSales()"
                    disabled>
                    <i class="mdi mdi-crosshairs-gps"></i> Ambil Lokasi GPS Saya
                </button>
                <span id="status-lokasi-sales" class="ms-2 text-muted"></span>
            </div>

            <div class="row mb-3" id="row-lokasi-sales" style="display:none!important">
                <div class="col-md-4">
                    <label>Latitude Saya</label>
                    <input type="text" id="lat-sales" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label>Longitude Saya</label>
                    <input type="text" id="lng-sales" class="form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label>Accuracy (meter)</label>
                    <input type="text" id="acc-sales" class="form-control" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-gradient-success" id="btn-submit-kunjungan" onclick="submitKunjungan()"
                disabled>
                Kirim Kunjungan
            </button>

            {{-- Hasil kunjungan --}}
            <div id="hasil-kunjungan" class="mt-4 d-none">
                <div id="hasil-alert" class="alert">
                    <h5 id="hasil-status"></h5>
                    <p>Jarak aktual: <strong><span id="hasil-jarak"></span> m</strong></p>
                    <p>Threshold efektif: <strong><span id="hasil-threshold"></span> m</strong></p>
                </div>
            </div>

        </div>
    </div>

    {{-- Hidden input toko_id --}}
    <input type="hidden" id="selected-toko-id" value="">

    {{-- Print area (hidden) --}}
    <div id="print-area" style="display:none;"></div>

@endsection

@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-area,
            #print-area * {
                visibility: visible;
            }

            #print-area {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                text-align: center;
                padding: 40px;
            }
        }
    </style>
@endpush

@push('scripts')
    {{-- Library Html5-QRCode untuk scanner --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        let html5QrCode = null;
        let tokoData = null;
        let salesLokasi = null;

        // =====================
        // AMBIL LOKASI TOKO
        // =====================
        async function ambilLokasiToko() {
            const statusEl = document.getElementById('status-lokasi-toko');
            statusEl.textContent = 'Mengambil lokasi...';
            try {
                const pos = await getAccuratePosition(50);
                document.getElementById('lat-toko').value = pos.coords.latitude;
                document.getElementById('lng-toko').value = pos.coords.longitude;
                document.getElementById('acc-toko').value = pos.coords.accuracy.toFixed(2);
                statusEl.textContent = '✅ Lokasi didapat (accuracy: ' + pos.coords.accuracy.toFixed(1) + 'm)';
                document.getElementById('btn-submit-toko').disabled = false;
            } catch (e) {
                statusEl.textContent = '❌ Gagal: ' + e.message;
            }
        }

        // =====================
        // SCANNER BARCODE
        // =====================
        window.onload = function () {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    html5QrCode.stop();
                    fetchToko(decodedText);
                },
                (err) => { }
            ).catch(() => { });
        };

        function cariBarcode() {
            const barcode = document.getElementById('input-barcode-manual').value.trim();
            if (barcode) fetchToko(barcode);
        }

        function fetchToko(barcode) {
            fetch(`/kunjungan-toko/get-toko?barcode=${barcode}`)
                .then(r => r.json())
                .then(data => {
                    if (data.error) {
                        alert('Toko tidak ditemukan!');
                        return;
                    }
                    tokoData = data;
                    document.getElementById('selected-toko-id').value = data.id;
                    document.getElementById('scan-nama').textContent = data.nama_toko;
                    document.getElementById('scan-alamat').textContent = data.alamat ?? '-';
                    document.getElementById('scan-latlng').textContent = data.latitude + ', ' + data.longitude;
                    document.getElementById('scan-acc').textContent = data.accuracy;
                    document.getElementById('info-toko').classList.remove('d-none');
                    document.getElementById('btn-ambil-sales').disabled = false;
                });
        }

        // =====================
        // AMBIL LOKASI SALES
        // =====================
        async function ambilLokasiSales() {
            const statusEl = document.getElementById('status-lokasi-sales');
            statusEl.textContent = 'Mengambil lokasi...';
            try {
                const pos = await getAccuratePosition(50);
                salesLokasi = pos.coords;
                document.getElementById('lat-sales').value = pos.coords.latitude;
                document.getElementById('lng-sales').value = pos.coords.longitude;
                document.getElementById('acc-sales').value = pos.coords.accuracy.toFixed(2);
                document.getElementById('row-lokasi-sales').style.display = 'flex';
                statusEl.textContent = '✅ Lokasi didapat (accuracy: ' + pos.coords.accuracy.toFixed(1) + 'm)';
                document.getElementById('btn-submit-kunjungan').disabled = false;
            } catch (e) {
                statusEl.textContent = '❌ Gagal: ' + e.message;
            }
        }

        // =====================
        // SUBMIT KUNJUNGAN
        // =====================
        function submitKunjungan() {
            const tokoId = document.getElementById('selected-toko-id').value;
            if (!tokoId || !salesLokasi) return;

            fetch('/kunjungan-toko/store-kunjungan', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    toko_id: tokoId,
                    latitude_sales: salesLokasi.latitude,
                    longitude_sales: salesLokasi.longitude,
                    accuracy_sales: salesLokasi.accuracy,
                })
            })
                .then(r => r.json())
                .then(data => {
                    const hasilDiv = document.getElementById('hasil-kunjungan');
                    const alertDiv = document.getElementById('hasil-alert');
                    hasilDiv.classList.remove('d-none');
                    document.getElementById('hasil-jarak').textContent = data.jarak;
                    document.getElementById('hasil-threshold').textContent = data.threshold_efektif;

                    if (data.status === 'diterima') {
                        alertDiv.className = 'alert alert-success';
                        document.getElementById('hasil-status').textContent = '✅ DITERIMA — Kunjungan valid!';
                    } else {
                        alertDiv.className = 'alert alert-danger';
                        document.getElementById('hasil-status').textContent = '❌ DITOLAK — Kamu terlalu jauh dari toko.';
                    }
                });
        }

        // =====================
        // CETAK BARCODE
        // =====================
        function cetakBarcode(barcode, nama) {
            const printArea = document.getElementById('print-area');
            printArea.innerHTML = `
            <div style="text-align:center; padding:40px; font-family:sans-serif;">
                <p style="font-size:18px; font-weight:bold; margin-bottom:10px;">${nama}</p>
                <img src="/barcode/${barcode}" style="max-width:300px; display:block; margin:0 auto;">
                <p style="font-size:13px; margin-top:10px; letter-spacing:2px;">${barcode}</p>
            </div>`;
            printArea.style.display = 'block';
            const img = printArea.querySelector('img');
            img.onload = function () {
                window.print();
                printArea.style.display = 'none';
            };
        }
        // =====================
        // FUNGSI GEOLOCATION AKURAT
        // =====================
        function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
            return new Promise((resolve, reject) => {
                let bestResult = null;
                const startTime = Date.now();
                const watchId = navigator.geolocation.watchPosition(
                    (position) => {
                        const acc = position.coords.accuracy;
                        if (!bestResult || acc < bestResult.coords.accuracy) {
                            bestResult = position;
                        }
                        if (acc <= targetAccuracy) {
                            navigator.geolocation.clearWatch(watchId);
                            resolve(bestResult);
                        }
                        if (Date.now() - startTime >= maxWait) {
                            navigator.geolocation.clearWatch(watchId);
                            if (bestResult) resolve(bestResult);
                            else reject(new Error("Timeout, tidak dapat posisi"));
                        }
                    },
                    (error) => reject(error),
                    { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
                );
            });
        }
    </script>
@endpush