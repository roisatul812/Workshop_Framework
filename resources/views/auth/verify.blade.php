@extends('layouts.auth')

@section('content')

    <div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">

        <div style="width:420px;">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h3 class="text-center mb-2 text-primary">Verifikasi OTP</h3>

                    <p class="text-center text-muted mb-4">
                        Masukkan kode OTP yang dikirim ke email kamu
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ url('/verify') }}">
                        @csrf

                        <div class="form-group mb-4">

                            <label>Kode OTP</label>

                            <input type="text" name="otp" class="form-control" maxlength="6" pattern="[0-9]{6}"
                                placeholder="Masukkan 6 digit OTP" required>

                        </div>

                        <button type="submit" class="btn btn-gradient-primary w-100">
                            Verifikasi
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection