@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">

<div style="width:420px;">

<div class="card shadow-lg border-0">

<div class="card-body p-5">

<h3 class="text-center mb-2 text-primary">Register</h3>

<p class="text-center text-muted mb-4">
Create your account
</p>

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="form-group mb-3">

<label>Name</label>

<input id="name"
type="text"
class="form-control @error('name') is-invalid @enderror"
name="name"
value="{{ old('name') }}"
required
autocomplete="name"
autofocus>

@error('name')
<span class="invalid-feedback">
<strong>{{ $message }}</strong>
</span>
@enderror

</div>


<div class="form-group mb-3">

<label>Email</label>

<input id="email"
type="email"
class="form-control @error('email') is-invalid @enderror"
name="email"
value="{{ old('email') }}"
required
autocomplete="email">

@error('email')
<span class="invalid-feedback">
<strong>{{ $message }}</strong>
</span>
@enderror

</div>


<div class="form-group mb-3">

<label>Password</label>

<input id="password"
type="password"
class="form-control @error('password') is-invalid @enderror"
name="password"
required
autocomplete="new-password">

@error('password')
<span class="invalid-feedback">
<strong>{{ $message }}</strong>
</span>
@enderror

</div>


<div class="form-group mb-4">

<label>Confirm Password</label>

<input id="password-confirm"
type="password"
class="form-control"
name="password_confirmation"
required
autocomplete="new-password">

</div>


<button type="submit" class="btn btn-gradient-primary w-100">
Register
</button>

</form>

</div>

</div>

</div>

</div>

@endsection