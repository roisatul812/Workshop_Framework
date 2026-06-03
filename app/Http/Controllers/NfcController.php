<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Absensi;

class NfcController extends Controller
{
    // Halaman utama NFC scanner + daftar absensi
    public function index()
    {
        $mahasiswas = Mahasiswa::latest()->get();
        $absensis   = Absensi::with('mahasiswa')->latest()->take(20)->get();
        return view('nfc.index', compact('mahasiswas', 'absensis'));
    }

    // Simpan mahasiswa baru
    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nim'        => 'required|string|unique:mahasiswas,nim',
            'nama'       => 'required|string|max:100',
            'serial_nfc' => 'nullable|string|unique:mahasiswas,serial_nfc',
        ]);

        Mahasiswa::create($request->only('nim', 'nama', 'serial_nfc'));

        return redirect()->route('nfc.index')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    // Daftarkan kartu NFC ke mahasiswa
    public function daftarKartu(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'serial_nfc'   => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
        $mahasiswa->update(['serial_nfc' => $request->serial_nfc]);

        return response()->json([
            'success' => true,
            'message' => 'Kartu NFC berhasil didaftarkan ke ' . $mahasiswa->nama,
        ]);
    }

    // Proses scan NFC untuk absensi
    public function scan(Request $request)
    {
        $request->validate([
            'serial_nfc' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::where('serial_nfc', $request->serial_nfc)->first();

        if (!$mahasiswa) {
            // Kartu tidak dikenal — tetap catat
            Absensi::create([
                'mahasiswa_id' => null,
                'waktu_absen'  => now(),
                'status'       => 'tidak_dikenal',
                'serial_nfc'   => $request->serial_nfc,
            ]);

            return response()->json([
                'status'  => 'tidak_dikenal',
                'message' => 'Kartu tidak terdaftar!',
                'serial'  => $request->serial_nfc,
            ]);
        }

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('waktu_absen', today())
            ->where('status', 'hadir')
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'status'  => 'sudah_absen',
                'message' => $mahasiswa->nama . ' sudah absen hari ini!',
                'nama'    => $mahasiswa->nama,
                'nim'     => $mahasiswa->nim,
            ]);
        }

        Absensi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'waktu_absen'  => now(),
            'status'       => 'hadir',
            'serial_nfc'   => $request->serial_nfc,
        ]);

        return response()->json([
            'status'  => 'hadir',
            'message' => 'Selamat datang, ' . $mahasiswa->nama . '!',
            'nama'    => $mahasiswa->nama,
            'nim'     => $mahasiswa->nim,
        ]);
    }

    // Hapus mahasiswa
    public function deleteMahasiswa($id)
    {
        Mahasiswa::findOrFail($id)->delete();
        return redirect()->route('nfc.index')->with('success', 'Data mahasiswa dihapus!');
    }
}