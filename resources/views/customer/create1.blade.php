@extends('layouts.app')

@section('content')

    <div class="container">

        <h3 class="mb-4">Tambah Customer 1 (Simpan ke Database)</h3>

        <a href="{{ url('/customer') }}" class="btn btn-secondary mb-3">
            ← Kembali
        </a>

        <div class="card">
            <div class="card-body">

                <form method="POST" action="/customer/store1">

                    @csrf

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="form-group">

                        <label>Kamera</label>

                        <br>

                        <video id="video" width="320" height="240" autoplay
                            style="border:1px solid #ccc; transform: scaleX(-1);"></video>

                        <br><br>

                        <button type="button" class="btn btn-primary" onclick="ambilFoto()">
                            Ambil Foto
                        </button>

                    </div>

                    <canvas id="canvas" width="320" height="240" style="display:none;"></canvas>

                    <div class="form-group mt-3">

                        <input type="hidden" name="foto" id="foto">

                        <br>

                        <img id="preview" width="200">

                    </div>

                    <button class="btn btn-success">
                        Simpan
                    </button>

                </form>

            </div>
        </div>

    </div>

    <script>

        const video = document.getElementById('video');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {

                video.srcObject = stream;

            });

        function ambilFoto() {

            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');

            context.translate(canvas.width, 0);
            context.scale(-1, 1);

            context.drawImage(video, 0, 0, 320, 240);

            context.setTransform(1, 0, 0, 1, 0, 0);

            let dataURL = canvas.toDataURL("image/png");

            document.getElementById('foto').value = dataURL;
            document.getElementById('preview').src = dataURL;
        }

    </script>

@endsection