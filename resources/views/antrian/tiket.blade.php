<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nomor Antrian #{{ $antrian->nomor_antrian }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background: #f5f5f5;
        }

        .tiket-card {
            max-width: 420px;
            margin: 60px auto;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(124, 77, 255, 0.15);
            overflow: hidden;
            text-align: center;
        }

        .tiket-header {
            background: linear-gradient(135deg, #7c4dff, #448aff);
            color: white;
            padding: 32px 24px 24px;
        }

        .tiket-header h3 {
            margin: 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .nomor-besar {
            font-size: 6rem;
            font-weight: 900;
            line-height: 1;
            margin: 16px 0;
            color: white;
        }

        .tiket-body {
            background: white;
            padding: 28px 24px 32px;
        }

        .nama-label {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 4px;
        }

        .nama-besar {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            margin-top: 16px;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-menunggu {
            background: #fff3e0;
            color: #e65100;
        }

        .status-dipanggil {
            background: #e8f5e9;
            color: #2e7d32;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        .info-box {
            margin-top: 20px;
            background: #f3f0ff;
            border-radius: 10px;
            padding: 14px;
            font-size: 0.88rem;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="tiket-card">
        <div class="tiket-header">
            <h3>🍽️ Kantin Digital — Nomor Antrian</h3>
            <div class="nomor-besar" id="nomor">{{ $antrian->nomor_antrian }}</div>
        </div>
        <div class="tiket-body">
            <div class="nama-label">Atas nama</div>
            <div class="nama-besar">{{ $antrian->nama }}</div>

            <div id="status-badge" class="status-badge status-menunggu">
                ⏳ Menunggu dipanggil
            </div>

            <div class="info-box">
                Pantau papan antrian atau tunggu dipanggil oleh petugas.<br>
                Halaman ini akan otomatis update saat nomor kamu dipanggil.
            </div>
        </div>
    </div>

    <script>
        const nomorSaya = {{ $antrian->nomor_antrian }};
        let sudahDipanggil = false;

        function cekStatus() {
            if (sudahDipanggil) return;
            fetch('/antrian/status')
                .then(r => r.json())
                .then(data => {
                    if (data.dipanggil && data.dipanggil.nomor_antrian == nomorSaya) {
                        sudahDipanggil = true;
                        const badge = document.getElementById('status-badge');
                        badge.className = 'status-badge status-dipanggil';
                        badge.textContent = '✅ Kamu dipanggil! Silakan menuju kasir.';
                        document.title = '🔔 Kamu Dipanggil! #' + nomorSaya;
                    }
                })
                .catch(() => { });
        }

        cekStatus();
        setInterval(cekStatus, 2000);
    </script>
</body>

</html>