<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Antrian — Kantin Digital</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        body { background: #f5f5f5; }
        .antrian-card {
            max-width: 480px;
            margin: 80px auto;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }
        .antrian-card .card-header {
            background: linear-gradient(135deg, #7c4dff, #448aff);
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 32px;
            text-align: center;
        }
        .antrian-card .card-header h2 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .antrian-card .card-header p  { margin: 8px 0 0; opacity: 0.85; }
        .antrian-card .card-body { padding: 32px; background: white; border-radius: 0 0 16px 16px; }
    </style>
</head>
<body>

<div class="antrian-card">
    <div class="card-header">
        <h2>🍽️ Kantin Digital</h2>
        <p>Daftar antrian untuk dilayani</p>
    </div>
    <div class="card-body">
        <div id="form-section">
            <div class="form-group mb-4">
                <label style="font-weight:600; font-size:1rem;">Nama Kamu</label>
                <input type="text" id="input-nama" class="form-control form-control-lg mt-2"
                    placeholder="Masukkan nama lengkap..." autofocus>
            </div>
            <button onclick="daftarAntrian()"
                class="btn btn-gradient-primary btn-lg w-100">
                Ambil Nomor Antrian
            </button>
        </div>

        <div id="loading-section" style="display:none; text-align:center; padding:20px;">
            <div class="spinner-border text-primary mb-3" role="status"></div>
            <p class="text-muted">Mendaftarkan antrian...</p>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script>
    function daftarAntrian() {
        const nama = document.getElementById('input-nama').value.trim();
        if (!nama) {
            alert('Masukkan nama kamu dulu ya!');
            return;
        }

        document.getElementById('form-section').style.display = 'none';
        document.getElementById('loading-section').style.display = 'block';

        fetch('{{ route("antrian.daftar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nama: nama })
        })
        .then(r => r.json())
        .then(data => {
            // Buka tab baru dengan tiket
            window.open('/tiket/' + data.id, '_blank');
            // Reset form
            document.getElementById('form-section').style.display = 'block';
            document.getElementById('loading-section').style.display = 'none';
            document.getElementById('input-nama').value = '';
        });
    }

    // Enter key support
    document.getElementById('input-nama').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') daftarAntrian();
    });
</script>
</body>
</html>