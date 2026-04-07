@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Studi Kasus 1 - AJAX Submit</h3>

        <a href="{{ url('/ajax-lab') }}" class="btn btn-secondary mb-4">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <label class="mb-2">Name</label>

                <input type="text" id="myIdname" class="form-control mb-3" placeholder="Masukkan nama">

                <span id="subbutton">
                    <button class="btn btn-primary" onclick="submitText()">
                        Submit
                    </button>
                </span>

                <hr>

                <p>Output: <b id="freetxt">-</b></p>

            </div>
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        function submitText() {

            var btn = $("#subbutton");
            btn.html('<button class="btn btn-secondary">Submitting...</button>');

            var name = $("#myIdname").val();

            $.ajax({

                url: "{{ route('ajax.submit') }}",
                type: "POST",

                data: {
                    _token: "{{ csrf_token() }}",
                    name: name
                },

                success: function (response) {

                    btn.html('<button class="btn btn-primary" onclick="submitText()">Submit</button>');

                    console.log(response);

                    if (response.status == "success") {

                        $("#freetxt").text(response.data.name);

                        Swal.fire(
                            'Success',
                            'Data berhasil dikirim',
                            'success'
                        );

                        $("#myIdname").val('');

                    }

                },

                error: function () {

                    btn.html('<button class="btn btn-primary" onclick="submitText()">Submit</button>');

                    Swal.fire(
                        'Error',
                        'Terjadi kesalahan',
                        'error'
                    );

                }

            });

        }

    </script>

@endsection