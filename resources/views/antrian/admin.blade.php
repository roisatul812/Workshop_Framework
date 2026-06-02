@extends('layouts.app')

@section('content')

    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">🍽️ Kelola Antrian Kantin</h3>
            <div>
                <a href="/papan-antrian" target="_blank" class="btn btn-outline-primary btn-sm me-2">
                    <i class="mdi mdi-television"></i> Buka Papan Antrian
                </a>
                <button onclick="resetAntrian()" class="btn btn-outline-danger btn-sm">
                    <i class="mdi mdi-refresh"></i> Reset Antrian
                </button>
            </div>
        </div>
    </div>

    {{-- Nomor Sedang Dipanggil --}}
    <div class="card mb-4" style="border-left: 5px solid #7c4dff;">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div>
                <p class="text-muted mb-1">Sedang Dilayani</p>
                <h1 class="mb-0" id="nomor-dipanggil" style="font-size:3.5rem; font-weight:900; color:#7c4dff;">
                    {{ $dipanggil ? $dipanggil->nomor_antrian : '—' }}
                </h1>
                <h5 id="nama-dipanggil" class="text-muted mt-1">
                    {{ $dipanggil ? $dipanggil->nama : 'Belum ada yang dipanggil' }}
                </h5>
            </div>
            <button onclick="panggilBerikutnya()" class="btn btn-gradient-primary btn-lg">
                <i class="mdi mdi-account-voice"></i> Panggil Berikutnya
            </button>
        </div>
    </div>

    <div class="row">
        {{-- List Menunggu --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">⏳ Menunggu <span id="jumlah-menunggu"
                            class="badge bg-warning text-dark">{{ $menunggu->count() }}</span></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-menunggu">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($menunggu as $a)
                                    <tr id="row-{{ $a->id }}">
                                        <td><strong>{{ $a->nomor_antrian }}</strong></td>
                                        <td>{{ $a->nama }}</td>
                                        <td>
                                            <button onclick="tandaiTerlambat({{ $a->id }})" class="btn btn-warning btn-sm">
                                                Tidak Hadir
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="row-kosong-menunggu">
                                        <td colspan="3" class="text-center text-muted">Tidak ada antrian</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- List Terlambat --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">⚠️ Tidak Hadir <span id="jumlah-terlambat"
                            class="badge bg-danger">{{ $terlambat->count() }}</span></h5>
                    <p class="text-muted small">Double klik nama untuk memanggil ulang.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tabel-terlambat">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($terlambat as $a)
                                    <tr id="row-terlambat-{{ $a->id }}" ondblclick="panggilTerlambat({{ $a->id }})"
                                        style="cursor:pointer;" title="Double klik untuk panggil ulang">
                                        <td><strong>{{ $a->nomor_antrian }}</strong></td>
                                        <td>{{ $a->nama }}</td>
                                        <td>
                                            <button onclick="panggilTerlambat({{ $a->id }})"
                                                class="btn btn-info btn-sm text-white">
                                                Panggil Ulang
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="row-kosong-terlambat">
                                        <td colspan="3" class="text-center text-muted">Tidak ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';

        // SSE untuk update real-time
        const source = new EventSource('/sse/antrian');
        source.addEventListener('queue-update', function (e) {
            const data = JSON.parse(e.data);

            // Update nomor dipanggil
            if (data.dipanggil) {
                document.getElementById('nomor-dipanggil').textContent = data.dipanggil.nomor_antrian;
                document.getElementById('nama-dipanggil').textContent = data.dipanggil.nama;
            }

            // Update tabel menunggu
            const tbodyMenunggu = document.querySelector('#tabel-menunggu tbody');
            if (data.menunggu.length === 0) {
                tbodyMenunggu.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Tidak ada antrian</td></tr>';
            } else {
                tbodyMenunggu.innerHTML = data.menunggu.map(a => `
                    <tr id="row-${a.id}">
                        <td><strong>${a.nomor_antrian}</strong></td>
                        <td>${a.nama}</td>
                        <td>
                            <button onclick="tandaiTerlambat(${a.id})" class="btn btn-warning btn-sm">
                                Tidak Hadir
                            </button>
                        </td>
                    </tr>
                `).join('');
            }
            document.getElementById('jumlah-menunggu').textContent = data.menunggu.length;

            // Update tabel terlambat
            const tbodyTerlambat = document.querySelector('#tabel-terlambat tbody');
            if (data.terlambat.length === 0) {
                tbodyTerlambat.innerHTML = '<tr><td colspan="3" class="text-center text-muted">Tidak ada</td></tr>';
            } else {
                tbodyTerlambat.innerHTML = data.terlambat.map(a => `
                    <tr ondblclick="panggilTerlambat(${a.id})" style="cursor:pointer;">
                        <td><strong>${a.nomor_antrian}</strong></td>
                        <td>${a.nama}</td>
                        <td>
                            <button onclick="panggilTerlambat(${a.id})" class="btn btn-info btn-sm text-white">
                                Panggil Ulang
                            </button>
                        </td>
                    </tr>
                `).join('');
            }
            document.getElementById('jumlah-terlambat').textContent = data.terlambat.length;
        });

        function panggilBerikutnya() {
            fetch('/antrian/panggil', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            }).then(r => r.json()).then(data => {
                if (data.error) alert(data.error);
            });
        }

        function tandaiTerlambat(id) {
            fetch('/antrian/terlambat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ id: id })
            });
        }

        function panggilTerlambat(id) {
            fetch('/antrian/panggil-terlambat', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ id: id })
            });
        }

        function resetAntrian() {
            if (!confirm('Reset semua antrian hari ini?')) return;
            fetch('/antrian/reset', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            }).then(() => location.reload());
        }
    </script>
@endpush