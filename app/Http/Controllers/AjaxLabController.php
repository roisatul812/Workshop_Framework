<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxLabController extends Controller
{

    public function index()
    {
        return view('ajax-lab.index');
    }

    public function submitPage()
    {
        return view('ajax-lab.submit');
    }

    public function submitAjax(Request $req)
    {

        $name = $req->name;

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data received successfully',
            'data' => [
                'name' => $name
            ]
        ]);
    }

    public function wilayah()
    {
        return view('ajax-lab.wilayah');
    }

    public function getProvinsi()
    {
        $provinsi = DB::table('reg_provinces')->get();
        return response()->json($provinsi);
    }

    public function getKota(Request $req)
    {
        $kota = DB::table('reg_regencies')
            ->where('province_id', $req->provinsi_id)
            ->get();

        return response()->json($kota);
    }

    public function getKecamatan(Request $req)
    {
        $kecamatan = DB::table('reg_districts')
            ->where('regency_id', $req->kota_id)
            ->get();

        return response()->json($kecamatan);
    }

    public function getKelurahan(Request $req)
    {
        $kelurahan = DB::table('reg_villages')
            ->where('district_id', $req->kecamatan_id)
            ->get();

        return response()->json($kelurahan);
    }
    public function axiosPage()
    {
        return view('ajax-lab.axios');
    }

    public function getUsers()
    {
        $users = [
            ['nama' => 'Andi', 'email' => 'andi@mail.com'],
            ['nama' => 'Budi', 'email' => 'budi@mail.com'],
            ['nama' => 'Citra', 'email' => 'citra@mail.com']
        ];

        return response()->json($users);
    }
}