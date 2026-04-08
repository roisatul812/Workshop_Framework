<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = Customer::all();
        return view('customer.index', compact('customer'));
    }

    public function create1()
    {
        return view('customer.create1');
    }

    public function create2()
    {
        return view('customer.create2');
    }

    public function store1(Request $request)
    {

        Customer::create([
            'name' => $request->nama,
            'email' => $request->email,
            'foto' => $request->foto
        ]);

        return redirect('/customer');
    }

    public function store2(Request $request)
    {
        $file = $request->file('foto');

        $namaFile = time() . '_' . preg_replace('/[^A-Za-z0-9.\-]/', '', $file->getClientOriginalName());

        $file->move(public_path('uploads'), $namaFile);

        Customer::create([
            'name' => $request->nama,
            'email' => $request->email,
            'foto' => 'uploads/' . $namaFile
        ]);
        return redirect('/customer');
    }
}