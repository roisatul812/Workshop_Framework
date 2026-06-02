@extends('layouts.guest')

@section('content')

{{-- ============================= --}}
{{-- LANDING PAGE / HERO SECTION --}}
{{-- ============================= --}}

<div style="background: linear-gradient(135deg, #7c4dff, #448aff); padding: 60px 20px; text-align:center; color:white;">
    <h1 style="font-size:2.5rem; font-weight:800; margin-bottom:10px;">🍽️ Kantin Digital</h1>
    <p style="font-size:1.1rem; opacity:0.9; margin-bottom:32px;">Pesan makanan atau ambil nomor antrian dengan mudah</p>

    <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
        <a href="#form-antrian"
            style="background:white; color:#7c4dff; font-weight:700; padding:14px 32px;
                   border-radius:50px; text-decoration:none; font-size:1rem;
                   box-shadow: 0 4px 15px rgba(0,0,0,0.15);">
            🎫 Demo Nomor Antrian
        </a>
        <a href="#menu-kantin"
            style="background:rgba(255,255,255,0.15); color:white; font-weight:700;
                   padding:14px 32px; border-radius:50px; text-decoration:none;
                   font-size:1rem; border: 2px solid rgba(255,255,255,0.5);">
            🍱 Demo Memesan Makanan
        </a>
    </div>
</div>

{{-- ============================= --}}
{{-- FORM ANTRIAN --}}
{{-- ============================= --}}

<div id="form-antrian" style="background:#f3f0ff; padding: 48px 20px;">
    <div style="max-width:480px; margin:0 auto;">

        <h3 style="text-align:center; font-weight:700; color:#7c4dff; margin-bottom:8px;">🎫 Ambil Nomor Antrian</h3>
        <p style="text-align:center; color:#888; margin-bottom:24px;">Masukkan namamu untuk mendapatkan nomor antrian</p>

        <div class="card" style="border-radius:16px; box-shadow: 0 4px 20px rgba(124,77,255,0.1);">
            <div class="card-body" style="padding:28px;">
                <div class="form-group mb-3">
                    <label style="font-weight:600;">Nama Kamu</label>
                    <input type="text" id="input-nama-antrian" class="form-control form-control-lg mt-2"
                        placeholder="Masukkan nama lengkap...">
                </div>
                <button onclick="daftarAntrian()" class="btn btn-gradient-primary w-100 btn-lg">
                    Ambil Nomor Antrian
                </button>
                <div id="loading-antrian" style="display:none; text-align:center; margin-top:16px;">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2">Mendaftarkan antrian...</p>
                </div>
            </div>
        </div>

        {{-- Papan Antrian Mini --}}
        <div class="card mt-4" style="border-radius:16px; overflow:hidden;">
            <div style="background: linear-gradient(135deg, #1a0533, #0d1b4d); padding:20px; text-align:center;">
                <p style="color:#b39ddb; font-size:0.85rem; margin:0 0 8px; text-transform:uppercase; letter-spacing:2px;">Sedang Dilayani</p>
                <div id="papan-nomor" style="font-size:4rem; font-weight:900; color:white; line-height:1;">—</div>
                <div id="papan-nama"  style="font-size:1.2rem; color:#ce93d8; margin-top:4px;">Menunggu panggilan...</div>
            </div>
            <div style="background:#1a0533; padding:12px 20px;">
                <p style="color:#7c4dff; font-size:0.8rem; margin:0; text-align:center;">
                    🔴 Live — update otomatis via SSE
                </p>
            </div>
        </div>

        <div style="text-align:center; margin-top:16px;">
            <a href="/papan-antrian" target="_blank" style="color:#7c4dff; font-size:0.9rem;">
                Buka papan antrian fullscreen →
            </a>
        </div>

    </div>
</div>

{{-- ============================= --}}
{{-- MENU KANTIN --}}
{{-- ============================= --}}

<div id="menu-kantin" class="container" style="padding-top:48px; padding-bottom:48px;">

    <h3 class="mb-4" style="font-weight:700;">🍱 Kantin Online</h3>

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
                            <button class="btn btn-primary">Tambah</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

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
                    @php $total = 0; @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $item)
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ number_format($item['subtotal']) }}</td>
                        </tr>
                        @php $total += $item['subtotal']; @endphp
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
                <button class="btn btn-success">Checkout</button>
            </form>
            @endif
        </div>
    </div>

</div>

{{-- SSE untuk papan mini di landing --}}
<script>
    function daftarAntrian() {
        const nama = document.getElementById('input-nama-antrian').value.trim();
        if (!nama) { alert('Masukkan nama kamu dulu!'); return; }

        document.getElementById('loading-antrian').style.display = 'block';

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
            document.getElementById('loading-antrian').style.display = 'none';
            document.getElementById('input-nama-antrian').value = '';
            window.open('http://koleksi-buku-2.test/tiket/' + data.id, '_blank');
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const source = new EventSource('/sse/antrian');
        source.addEventListener('queue-update', function(e) {
            const data = JSON.parse(e.data);
            if (data.dipanggil) {
                document.getElementById('papan-nomor').textContent = data.dipanggil.nomor_antrian;
                document.getElementById('papan-nama').textContent  = data.dipanggil.nama;
            }
        });
    });

    document.getElementById('input-nama-antrian').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') daftarAntrian();
    });
</script>

@endsection