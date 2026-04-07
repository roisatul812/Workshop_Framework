<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\User;

class PesananController extends Controller
{
    public function index()
    {
        $menu = Menu::with('vendor')->get();

        return view('kantin.index', compact('menu'));
    }

    public function store(Request $request)
    {

        $menu = Menu::find($request->menu_id);

        $cart = session()->get('cart', []);

        $cart[] = [
            'menu_id' => $menu->id,
            'nama' => $menu->nama_menu,
            'harga' => $menu->harga,
            'qty' => $request->qty,
            'subtotal' => $menu->harga * $request->qty
        ];

        session()->put('cart', $cart);

        return redirect('/kantin');

    }

    public function checkout()
    {

        $cart = session('cart');

        if (!$cart) {
            return redirect('/kantin');
        }

        $total = collect($cart)->sum('subtotal');

        // =========================
        // GENERATE GUEST USER
        // =========================

        $lastGuest = User::where('name', 'like', 'Guest_%')->count();

        $number = $lastGuest + 1;

        $guestName = 'Guest_' . str_pad($number, 6, '0', STR_PAD_LEFT);

        $guest = User::create([
            'name' => $guestName,
            'email' => strtolower($guestName) . '@mail.com',
            'password' => bcrypt('guest'),
            'role' => 'guest'
        ]);

        // =========================
        // CREATE PESANAN
        // =========================

        $pesanan = Pesanan::create([
            'user_id' => $guest->id,
            'total' => $total
        ]);

        foreach ($cart as $item) {

            DetailPesanan::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $item['menu_id'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'subtotal' => $item['subtotal']
            ]);

        }

        session()->forget('cart');

        return redirect('/checkout/' . $pesanan->id);

    }

    public function transaksi()
    {
        $pesanan = Pesanan::with(['detail.menu.vendor'])->get();
        return view('transaksi.index', compact('pesanan'));
    }
}
