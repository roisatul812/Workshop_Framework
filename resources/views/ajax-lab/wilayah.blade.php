@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Studi Kasus 2 - Cascading Wilayah</h3>

    <a href="{{ url('/ajax-lab') }}" class="btn btn-secondary mb-4">
        ← Kembali
    </a>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <label class="mb-1">Provinsi</label>
                <select id="provinsi" class="form-control form-control-sm">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="mb-1">Kota / Kabupaten</label>
                <select id="kota" class="form-control form-control-sm">
                    <option value="">Pilih Kota</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="mb-1">Kecamatan</label>
                <select id="kecamatan" class="form-control form-control-sm">
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="mb-1">Kelurahan</label>
                <select id="kelurahan" class="form-control form-control-sm">
                    <option value="">Pilih Kelurahan</option>
                </select>
            </div>

            <hr>

            <div class="mt-3">
                <h5>Output Wilayah</h5>
                <p>
                    <b id="hasilWilayah">-</b>
                </p>
            </div>

        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$(document).ready(function(){

    // LOAD PROVINSI
    $.ajax({

        url: "/get-provinsi",

        type: "GET",

        success:function(data){

            $.each(data,function(i,val){

                $("#provinsi").append(
                    `<option value="${val.id}">${val.name}</option>`
                );

            });

        }

    });

});


// ============================
// PROVINSI → KOTA
// ============================

$("#provinsi").change(function(){

    let id = $(this).val();

    $("#kota").html('<option>Pilih Kota</option>');
    $("#kecamatan").html('<option>Pilih Kecamatan</option>');
    $("#kelurahan").html('<option>Pilih Kelurahan</option>');
    $("#hasilWilayah").text("-");

    $.ajax({

        url:"/get-kota",

        type:"GET",

        data:{
            provinsi_id:id
        },

        success:function(data){

            $.each(data,function(i,val){

                $("#kota").append(
                    `<option value="${val.id}">${val.name}</option>`
                );

            });

        }

    });

});


// ============================
// KOTA → KECAMATAN
// ============================

$("#kota").change(function(){

    let id = $(this).val();

    $("#kecamatan").html('<option>Pilih Kecamatan</option>');
    $("#kelurahan").html('<option>Pilih Kelurahan</option>');
    $("#hasilWilayah").text("-");

    $.ajax({

        url:"/get-kecamatan",

        type:"GET",

        data:{
            kota_id:id
        },

        success:function(data){

            $.each(data,function(i,val){

                $("#kecamatan").append(
                    `<option value="${val.id}">${val.name}</option>`
                );

            });

        }

    });

});


// ============================
// KECAMATAN → KELURAHAN
// ============================

$("#kecamatan").change(function(){

    let id = $(this).val();

    $("#kelurahan").html('<option>Pilih Kelurahan</option>');
    $("#hasilWilayah").text("-");

    $.ajax({

        url:"/get-kelurahan",

        type:"GET",

        data:{
            kecamatan_id:id
        },

        success:function(data){

            $.each(data,function(i,val){

                $("#kelurahan").append(
                    `<option value="${val.id}">${val.name}</option>`
                );

            });

        }

    });

});


// ============================
// OUTPUT WILAYAH
// ============================

$("#kelurahan").change(function(){

    let prov = $("#provinsi option:selected").text();
    let kota = $("#kota option:selected").text();
    let kec = $("#kecamatan option:selected").text();
    let kel = $("#kelurahan option:selected").text();

    $("#hasilWilayah").text(
        prov + " - " + kota + " - " + kec + " - " + kel
    );

});

</script>

@endsection