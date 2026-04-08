<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\AjaxLabController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;

Auth::routes();

Route::get('auth/google',[GoogleController::class,'redirect']);
Route::get('auth/google/callback',[GoogleController::class,'callback']);

Route::get('/verify',function(){
    return view('auth.verify');
})->middleware('auth');

Route::post('/verify',[OTPController::class,'verify'])->middleware('auth');
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('kategori', KategoriController::class)->middleware('auth');

Route::resource('buku', BukuController::class)->middleware('auth');

Route::get('/cetak',[PDFController::class,'form']);
Route::post('/cetak',[PDFController::class,'cetak']);

Route::get('/barang',[BarangController::class,'index']);

Route::get('/cetak-harga',[BarangController::class,'index']);

Route::post('/cetak-harga',[BarangController::class,'cetakHarga']);

Route::prefix('js-lab')->group(function(){

Route::get('/', function(){
    return view('js-lab.index');
});

Route::get('/spinner', function(){
    return view('js-lab.spinner');
});

Route::get('/crud', function(){
    return view('js-lab.crud');
});

Route::get('/kota', function(){
    return view('js-lab.kota');
});

});

Route::get('/ajax-lab', [AjaxLabController::class,'index']);

Route::get('/ajax-lab/submit', [AjaxLabController::class,'submitPage']);

Route::post('/ajax-lab/submit', [AjaxLabController::class,'submitAjax'])
        ->name('ajax.submit');

Route::get('/ajax-lab/wilayah',[AjaxLabController::class,'wilayah']);

Route::get('/get-provinsi',[AjaxLabController::class,'getProvinsi']);

Route::get('/get-kota',[AjaxLabController::class,'getKota']);

Route::get('/get-kecamatan',[AjaxLabController::class,'getKecamatan']);

Route::get('/get-kelurahan',[AjaxLabController::class,'getKelurahan']);

Route::get('/ajax-lab/axios',[AjaxLabController::class,'axiosPage']);

Route::get('/axios-user',[AjaxLabController::class,'getUsers']);

Route::get('/kantin', [PesananController::class,'index']);

Route::post('/kantin/pesan', [PesananController::class,'store']);

Route::post('/checkout', [PesananController::class,'checkout']);

Route::get('/checkout/{id}', [PaymentController::class,'index']);

Route::post('/payment/{id}', [PaymentController::class,'pay']);

Route::middleware('auth')->group(function(){

    Route::get('/vendor', [VendorController::class,'index']);
    Route::post('/vendor/store', [VendorController::class,'store']);
    Route::post('/vendor/update/{id}', [VendorController::class,'update']);
    Route::get('/vendor/delete/{id}', [VendorController::class,'delete']);

    Route::get('/menu', [MenuController::class,'index']);
    Route::post('/menu/store', [MenuController::class,'store']);

    Route::get('/transaksi', [PesananController::class,'transaksi']);

    Route::post('/midtrans/callback', [PaymentController::class,'callback']);
});

Route::middleware('auth')->group(function(){

Route::get('/customer', [CustomerController::class,'index']);
Route::get('/customer/create1', [CustomerController::class,'create1']);
Route::get('/customer/create2', [CustomerController::class,'create2']);
Route::post('/customer/store1', [CustomerController::class,'store1']);
Route::post('/customer/store2', [CustomerController::class,'store2']);

});

Route::get('/scan', function () {
    return view('qr.scan');
});