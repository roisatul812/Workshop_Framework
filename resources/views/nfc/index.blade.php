@extends('layouts.app')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- CARD: NFC SCANNER --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">📡 NFC Absensi Scanner</h4>
            <p class="text-muted">Gunakan HP Android dengan Chrome untuk scan kartu NFC.</p>

            <button onclick="startScan()" class="btn btn-gradient-primary mb-3" id="btn-scan">
                <i class="mdi mdi-nfc"></i> Aktifkan NFC Scanner
            </button>

            {{-- Tombol test manual (untuk demo) --}}
            <div class="mt-2">
                <input type="text" id="input-serial-manual" class="form-control mb-2"
                    placeholder="Ketik serial NFC manual..." style="max-width:300px;">
                <button onclick="testManual()" class="btn btn-outline-secondary btn-sm">
                    Test Manual (tanpa kartu fisik)
                </button>
            </div>

            <div id="status-nfc" class="alert alert-secondary">
                Tekan tombol untuk mengaktifkan NFC scanner.
            </div>

            <div id="hasil-scan" class="d-none mt-3">
                <div id="hasil-alert" class="alert">
                    <h5 id="hasil-nama"></h5>
                    <p id="hasil-nim" class="mb-1"></p>
                    <p id="hasil-serial" class="mb-0 text-muted small"></p>
                </div>
            </div>

        </div>
    </div>

    {{-- CARD: RIWAYAT ABSENSI --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">📋 Riwayat Absensi Terbaru</h4>

            <div class="table-responsive">
                <table class="table table-bordered" id="tabel-absensi">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Serial NFC</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensis as $a)
                            <tr>
                                <td>{{ $a->waktu_absen->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $a->mahasiswa->nama ?? '-' }}</td>
                                <td>{{ $a->mahasiswa->nim ?? '-' }}</td>
                                <td><code>{{ $a->serial_nfc }}</code></td>
                                <td>
                                    @if($a->status == 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @elseif($a->status == 'sudah_absen')
                                        <span class="badge bg-warning text-dark">Sudah Absen</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Dikenal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- CARD: DATA MAHASISWA --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4 class="card-title">👥 Data Mahasiswa</h4>

            {{-- Form Tambah Mahasiswa --}}
            <form action="{{ route('nfc.storeMahasiswa') }}" method="POST" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <input type="text" name="nim" class="form-control" placeholder="NIM" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <input type="text" name="serial_nfc" id="input-serial-daftar" class="form-control"
                            placeholder="Serial NFC (opsional)">
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-gradient-success w-100">Tambah</button>
                    </div>
                </div>
            </form>

            {{-- Tombol scan untuk isi serial --}}
            <div class="mb-3">
                <button onclick="startScanDaftar()" class="btn btn-outline-primary btn-sm" id="btn-scan-daftar">
                    <i class="mdi mdi-nfc"></i> Scan Kartu untuk Isi Serial
                </button>
                <span id="status-scan-daftar" class="ms-2 text-muted small"></span>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Serial NFC</th>
                            <th>Status Kartu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mahasiswas as $m)
                            <tr>
                                <td>{{ $m->nim }}</td>
                                <td>{{ $m->nama }}</td>
                                <td><code>{{ $m->serial_nfc ?? '-' }}</code></td>
                                <td>
                                    @if($m->serial_nfc)
                                        <span class="badge bg-success">Terdaftar</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum ada kartu</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="daftarKartu({{ $m->id }}, '{{ $m->nama }}')"
                                        class="btn btn-info btn-sm text-white me-1">
                                        <i class="mdi mdi-nfc"></i> Daftarkan Kartu
                                    </button>
                                    <a href="{{ route('nfc.deleteMahasiswa', $m->id) }}" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Hapus mahasiswa ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data mahasiswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Modal daftarkan kartu --}}
    <div class="modal fade" id="modalDaftarKartu" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftarkan Kartu NFC</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Mahasiswa: <strong id="modal-nama-mhs"></strong></p>
                    <div id="modal-status" class="alert alert-secondary">
                        Klik tombol scan lalu dekatkan kartu NFC.
                    </div>
                    <button onclick="startScanModal()" class="btn btn-gradient-primary w-100" id="btn-scan-modal">
                        <i class="mdi mdi-nfc"></i> Scan Kartu NFC
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let selectedMahasiswaId = null;

        async function startScan() {
            if (!('NDEFReader' in window)) {
                document.getElementById('status-nfc').className = 'alert alert-danger';
                document.getElementById('status-nfc').textContent = '❌ Browser tidak mendukung Web NFC. Gunakan Android Chrome.';
                return;
            }
            try {
                const ndef = new NDEFReader();
                await ndef.scan();
                document.getElementById('status-nfc').className = 'alert alert-info';
                document.getElementById('status-nfc').textContent = '📡 NFC aktif. Dekatkan kartu ke belakang HP...';

                ndef.onreading = (event) => {
                    kirimAbsensi(event.serialNumber);
                };
                ndef.onreadingerror = (event) => {
                    const serial = event.serialNumber || event.target?.serialNumber;
                    if (serial) {
                        kirimAbsensi(serial);
                    } else {
                        document.getElementById('status-nfc').className = 'alert alert-warning';
                        document.getElementById('status-nfc').textContent = '⚠️ Gagal baca kartu. Coba lagi.';
                    }
                };
            } catch (err) {
                document.getElementById('status-nfc').className = 'alert alert-danger';
                document.getElementById('status-nfc').textContent = '❌ Error: ' + err.message;
            }
        }

        function kirimAbsensi(serialNumber) {
            document.getElementById('status-nfc').textContent = '✅ Kartu terdeteksi! Memproses...';
            fetch('{{ route("nfc.scan") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ serial_nfc: serialNumber })
            })
                .then(r => r.json())
                .then(data => {
                    const hasilDiv = document.getElementById('hasil-scan');
                    const alertDiv = document.getElementById('hasil-alert');
                    hasilDiv.classList.remove('d-none');
                    document.getElementById('hasil-serial').textContent = 'Serial: ' + serialNumber;

                    if (data.status === 'hadir') {
                        alertDiv.className = 'alert alert-success';
                        document.getElementById('hasil-nama').textContent = '✅ ' + data.message;
                        document.getElementById('hasil-nim').textContent = 'NIM: ' + data.nim;
                        document.getElementById('status-nfc').className = 'alert alert-success';
                        document.getElementById('status-nfc').textContent = '✅ Absensi berhasil!';
                    } else if (data.status === 'sudah_absen') {
                        alertDiv.className = 'alert alert-warning';
                        document.getElementById('hasil-nama').textContent = '⚠️ ' + data.message;
                        document.getElementById('hasil-nim').textContent = 'NIM: ' + data.nim;
                        document.getElementById('status-nfc').className = 'alert alert-warning';
                        document.getElementById('status-nfc').textContent = '⚠️ Sudah absen hari ini.';
                    } else {
                        alertDiv.className = 'alert alert-danger';
                        document.getElementById('hasil-nama').textContent = '❌ ' + data.message;
                        document.getElementById('hasil-nim').textContent = '';
                        document.getElementById('status-nfc').className = 'alert alert-danger';
                        document.getElementById('status-nfc').textContent = '❌ Kartu tidak dikenal.';
                    }

                    const tbody = document.querySelector('#tabel-absensi tbody');
                    const now = new Date().toLocaleString('id-ID');
                    const badge = data.status === 'hadir'
                        ? '<span class="badge bg-success">Hadir</span>'
                        : data.status === 'sudah_absen'
                            ? '<span class="badge bg-warning text-dark">Sudah Absen</span>'
                            : '<span class="badge bg-danger">Tidak Dikenal</span>';
                    tbody.insertAdjacentHTML('afterbegin', `<tr>
                        <td>${now}</td>
                        <td>${data.nama ?? '-'}</td>
                        <td>${data.nim ?? '-'}</td>
                        <td><code>${serialNumber}</code></td>
                        <td>${badge}</td>
                    </tr>`);
                });
        }

        async function startScanDaftar() {
            if (!('NDEFReader' in window)) {
                document.getElementById('status-scan-daftar').textContent = '❌ Tidak didukung di browser ini.';
                return;
            }
            try {
                const ndef = new NDEFReader();
                await ndef.scan();
                document.getElementById('status-scan-daftar').textContent = 'Dekatkan kartu...';
                ndef.onreading = (event) => {
                    document.getElementById('input-serial-daftar').value = event.serialNumber;
                    document.getElementById('status-scan-daftar').textContent = '✅ Serial: ' + event.serialNumber;
                };
                ndef.onreadingerror = (event) => {
                    const serial = event.serialNumber || event.target?.serialNumber;
                    if (serial) {
                        document.getElementById('input-serial-daftar').value = serial;
                        document.getElementById('status-scan-daftar').textContent = '✅ Serial: ' + serial;
                    }
                };
            } catch (err) {
                document.getElementById('status-scan-daftar').textContent = '❌ ' + err.message;
            }
        }

        function daftarKartu(id, nama) {
            selectedMahasiswaId = id;
            document.getElementById('modal-nama-mhs').textContent = nama;
            document.getElementById('modal-status').className = 'alert alert-secondary';
            document.getElementById('modal-status').textContent = 'Klik tombol scan lalu dekatkan kartu NFC.';
            new bootstrap.Modal(document.getElementById('modalDaftarKartu')).show();
        }

        async function startScanModal() {
            if (!('NDEFReader' in window)) {
                document.getElementById('modal-status').className = 'alert alert-danger';
                document.getElementById('modal-status').textContent = '❌ Tidak didukung di browser ini.';
                return;
            }
            try {
                const ndef = new NDEFReader();
                await ndef.scan();
                document.getElementById('modal-status').className = 'alert alert-info';
                document.getElementById('modal-status').textContent = 'Dekatkan kartu NFC...';

                ndef.onreading = (event) => {
                    simpanSerial(event.serialNumber);
                };
                ndef.onreadingerror = (event) => {
                    console.log('readingerror:', event);
                    console.log('serialNumber dari event:', event.serialNumber);
                    console.log('serialNumber dari target:', event.target?.serialNumber);
                    const serial = event.serialNumber || event.target?.serialNumber;
                    if (serial) {
                        simpanSerial(serial);
                    } else {
                        document.getElementById('modal-status').className = 'alert alert-warning';
                        document.getElementById('modal-status').textContent = '⚠️ event.serialNumber: ' + JSON.stringify(event.serialNumber) + ' | target.serialNumber: ' + JSON.stringify(event.target?.serialNumber) + ' | type: ' + event.type;
                    }
                };
            } catch (err) {
                document.getElementById('modal-status').className = 'alert alert-danger';
                document.getElementById('modal-status').textContent = '❌ ' + err.message;
            }
        }

        function simpanSerial(serialNumber) {
            document.getElementById('modal-status').textContent = 'Memproses serial: ' + serialNumber;
            fetch('{{ route("nfc.daftarKartu") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ mahasiswa_id: selectedMahasiswaId, serial_nfc: serialNumber })
            })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('modal-status').className = 'alert alert-success';
                    document.getElementById('modal-status').textContent = '✅ ' + data.message;
                    setTimeout(() => location.reload(), 1500);
                });
        }
        
        function testManual() {
            const serial = document.getElementById('input-serial-manual').value.trim();
            if (!serial) { alert('Masukkan serial dulu!'); return; }
            kirimAbsensi(serial);
        }
    </script>
@endpush