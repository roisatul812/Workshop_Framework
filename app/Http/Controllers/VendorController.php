<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{

    public function index()
    {

        $vendor = Vendor::all();

        return view('vendor.index', compact('vendor'));

    }


    public function store(Request $request)
    {

        Vendor::create([
            'nama_vendor' => $request->nama_vendor,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/vendor');

    }


    public function update(Request $request, $id)
    {

        Vendor::where('id',$id)->update([
            'nama_vendor' => $request->nama_vendor,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/vendor');

    }


    public function delete($id)
    {

        Vendor::where('id',$id)->delete();

        return redirect('/vendor');

    }

}