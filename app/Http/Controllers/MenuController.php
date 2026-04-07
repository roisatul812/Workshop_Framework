<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Vendor;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::with('vendor')->get();
        $vendor = Vendor::all();
        return view('menu.index', compact('menu','vendor'));
    }

    public function store(Request $request)
    {
        Menu::create([
            'vendor_id' => $request->vendor_id,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga
        ]);
        return redirect('/menu');
    }

    public function update(Request $request, $id)
    {
        Menu::where('id',$id)->update([
            'vendor_id' => $request->vendor_id,
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga
        ]);
        return redirect('/menu');
    }

    public function delete($id)
    {
        Menu::where('id',$id)->delete();
        return redirect('/menu');
    }
}