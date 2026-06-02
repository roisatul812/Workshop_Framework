<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Papan Antrian — Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a0533, #0d1b4d);
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .papan-header {
            text-align: center;
            padding: 32px 0 16px;
        }
        .papan-header h1 { font-size: 2rem; font-weight: 700; color: #b39ddb; }
        .papan-header p  { color: #9fa8da; margin: 0; }

        .nomor-utama {
            text-align: center;
            margin: 24px auto;
            background: rgba(255,255,255,0.05);
            border: 2px solid #7c4dff;
            border-radius: 24px;
            padding: 40px;
            max-width: 500px;
        }
        .nomor-utama .label { font-size: 1rem; color: #b39ddb; letter-spacing: 2px; text-transform: uppercase; }
        .nomor-utama .angka { font-size: 8rem; font-weight: 900; color: #fff; line-height: 1; }
        .nomor-utama .nama  { font-size: 2rem; color: #ce93d8; margin-top: 8px; }

        .antrian-list {
            max-width: 700px;
            margin: 0 auto;
            padding: 0 24px 40px;
        }
        .antrian-list h5 { color: #b39ddb; margin-bottom: 12px; }
        .antrian-item {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 8px;
        }
        .antrian-item .no   { font-size: 1.4rem; font-weight: 800; color: #7c4dff; width: 60px; }
        .antrian-item .nama { font-size: 1rem; color: #e8eaf6; }

        .aktivasi-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
        }
        .ticker {
            text-align: center;
            color: #9fa8da;
            font-size: 0.85rem;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>

<div class="papan-header">
    <h1>🍽️ Papan Antrian Kantin Digital</h1>
    <p>Update otomatis secara real-time</p>
</div>

<div class="nomor-utama">
    <div class="label">Sedang Dilayani</div>
    <div class="angka" id="nomor-dipanggil">—</div>
    <div class="nama"  id="nama-dipanggil">Menunggu panggilan...</div>
</div>

<div class="ticker" id="ticker">Terhubung ke server...</div>

<div class="antrian-list">
    <h5>⏳ Antrian Menunggu</h5>
    <div id="list-menunggu">
        <div class="antrian-item"><span class="nama text-muted">Belum ada antrian</span></div>
    </div>
</div>

{{-- Audio ting-tong --}}
<audio id="audio-tong" src="{{ asset('sounds/dingdong.mp3') }}" preload="auto"></audio>

{{-- Tombol aktivasi suara --}}
<div class="aktivasi-btn">
    <button id="btn-aktivasi"
        class="btn btn-success" disabled>
        ✅ Suara Aktif
    </button>
</div>

<script>
    let suaraAktif = true;
    let nomorTerakhir = null;

    function aktivasiSuara() {
        suaraAktif = true;
        document.getElementById('btn-aktivasi').textContent = '✅ Suara Aktif';
        document.getElementById('btn-aktivasi').disabled = true;
        document.getElementById('btn-aktivasi').classList.remove('btn-gradient-primary');
        document.getElementById('btn-aktivasi').classList.add('btn-success');
    }

    function bunyikanPanggilan(nomor, nama) {
        if (!suaraAktif) return;

        const audio = document.getElementById('audio-tong');
        audio.currentTime = 0;
        audio.play();

        audio.onended = function () {
            if (!('speechSynthesis' in window)) return;
            window.speechSynthesis.cancel();
            const pesan = new SpeechSynthesisUtterance(
                `Nomor antrian ${nomor}. ${nama}, silakan menuju kasir.`
            );
            pesan.lang   = 'id-ID';
            pesan.rate   = 0.85;
            pesan.pitch  = 1.0;
            pesan.volume = 1.0;
            window.speechSynthesis.speak(pesan);
        };
    }

    // SSE
    const source = new EventSource('/sse/antrian');

    source.addEventListener('queue-update', function(e) {
        const data = JSON.parse(e.data);

        // Update ticker
        document.getElementById('ticker').textContent =
            'Terakhir update: ' + new Date().toLocaleTimeString('id-ID');

        // Update nomor dipanggil + bunyikan suara jika berubah
        if (data.dipanggil) {
            const nomor = data.dipanggil.nomor_antrian;
            const nama  = data.dipanggil.nama;

            document.getElementById('nomor-dipanggil').textContent = nomor;
            document.getElementById('nama-dipanggil').textContent  = nama;

            if (nomorTerakhir !== nomor) {
                nomorTerakhir = nomor;
                bunyikanPanggilan(nomor, nama);
            }
        }

        // Update list menunggu
        const listEl = document.getElementById('list-menunggu');
        if (data.menunggu.length === 0) {
            listEl.innerHTML = '<div class="antrian-item"><span class="nama text-muted">Tidak ada antrian menunggu</span></div>';
        } else {
            listEl.innerHTML = data.menunggu.map(a => `
                <div class="antrian-item">
                    <span class="no">${a.nomor_antrian}</span>
                    <span class="nama">${a.nama}</span>
                </div>
            `).join('');
        }
    });

    source.onerror = function() {
        document.getElementById('ticker').textContent = '⚠️ Koneksi terputus, mencoba reconnect...';
    };
</script>
</body>
</html>