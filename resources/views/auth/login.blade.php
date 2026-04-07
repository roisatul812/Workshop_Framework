@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">

        <div style="width:420px;">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h3 class="text-center mb-2 text-primary">Sign in</h3>

                    <p class="text-center text-muted mb-4">
                        Enter details to get sign in to your account
                    </p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">

                            <label>Email</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>


                        <div class="form-group mb-4">

                            <label>Password</label>

                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>


                        <button type="submit" class="btn btn-gradient-primary w-100">
                            Login
                        </button>

                        <div class="text-center mt-3">
                            <a href="{{ url('auth/google') }}" class="btn btn-danger w-100">
                                Login with Google
                            </a>
                        </div>

                        <div class="text-center mt-3">

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif

                            <br>

                            <a href="{{ route('register') }}">
                                Belum punya akun? Register
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection