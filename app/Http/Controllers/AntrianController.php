<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;

class AntrianController extends Controller
{
    public function guest()
    {
        return view('antrian.guest');
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $nomor = (Antrian::max('nomor_antrian') ?? 0) + 1;

        $antrian = Antrian::create([
            'nomor_antrian' => $nomor,
            'nama' => $request->nama,
            'status' => 'menunggu',
        ]);

        return response()->json([
            'id' => $antrian->id,
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama' => $antrian->nama,
        ]);
    }

    public function tiket($id)
    {
        $antrian = Antrian::findOrFail($id);
        return view('antrian.tiket', compact('antrian'));
    }

    public function admin()
    {
        $menunggu = Antrian::where('status', 'menunggu')->orderBy('nomor_antrian')->get();
        $terlambat = Antrian::where('status', 'terlambat')->orderBy('nomor_antrian')->get();
        $dipanggil = Antrian::where('status', 'dipanggil')->latest('dipanggil_at')->first();

        return view('antrian.admin', compact('menunggu', 'terlambat', 'dipanggil'));
    }

    public function panggil(Request $request)
    {
        Antrian::where('status', 'dipanggil')->update(['status' => 'selesai']);

        $antrian = Antrian::where('status', 'menunggu')
            ->orderBy('nomor_antrian')
            ->first();

        if (!$antrian) {
            return response()->json(['error' => 'Tidak ada antrian'], 404);
        }

        $antrian->update([
            'status' => 'dipanggil',
            'dipanggil_at' => now(),
        ]);

        \Cache::put('antrian_dipanggil', [
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama' => $antrian->nama,
        ], 3600);

        \Cache::put('antrian_updated_at', now()->timestamp, 3600);

        return response()->json([
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama' => $antrian->nama,
        ]);
    }

    public function terlambat(Request $request)
    {
        $antrian = Antrian::findOrFail($request->id);
        $antrian->update(['status' => 'terlambat']);
        \Cache::put('antrian_updated_at', now()->timestamp, 3600);
        return response()->json(['success' => true]);
    }

    public function panggilTerlambat(Request $request)
    {
        Antrian::where('status', 'dipanggil')->update(['status' => 'selesai']);

        $antrian = Antrian::findOrFail($request->id);
        $antrian->update([
            'status' => 'dipanggil',
            'dipanggil_at' => now(),
        ]);

        \Cache::put('antrian_dipanggil', [
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama' => $antrian->nama,
        ], 3600);

        \Cache::put('antrian_updated_at', now()->timestamp, 3600);

        return response()->json([
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama' => $antrian->nama,
        ]);
    }

    public function papan()
    {
        return view('antrian.papan');
    }

    public function stream()
    {
        ignore_user_abort(true);

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        return response()->stream(function () {
            set_time_limit(0);

            // Kirim data langsung saat pertama connect
            $menunggu = Antrian::where('status', 'menunggu')->orderBy('nomor_antrian')->get();
            $terlambat = Antrian::where('status', 'terlambat')->orderBy('nomor_antrian')->get();
            $dipanggil = \Cache::get('antrian_dipanggil', null);

            echo 'event: queue-update' . PHP_EOL;
            echo 'data: ' . json_encode([
                'dipanggil' => $dipanggil,
                'menunggu' => $menunggu,
                'terlambat' => $terlambat,
            ]) . PHP_EOL;
            echo PHP_EOL;
            ob_flush();
            flush();

            while (true) {
                $menunggu = Antrian::where('status', 'menunggu')->orderBy('nomor_antrian')->get();
                $terlambat = Antrian::where('status', 'terlambat')->orderBy('nomor_antrian')->get();
                $dipanggil = \Cache::get('antrian_dipanggil', null);

                echo 'event: queue-update' . PHP_EOL;
                echo 'data: ' . json_encode([
                    'dipanggil' => $dipanggil,
                    'menunggu' => $menunggu,
                    'terlambat' => $terlambat,
                ]) . PHP_EOL;
                echo PHP_EOL;

                ob_flush();
                flush();

                if (connection_aborted())
                    break;

                usleep(300000);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    public function reset()
    {
        Antrian::truncate();
        \Cache::forget('antrian_dipanggil');
        \Cache::forget('antrian_updated_at');
        return response()->json(['success' => true]);
    }
}