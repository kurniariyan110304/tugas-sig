@extends('layouts.auth')

@section('title','Login')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-6 col-md-8">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-4">
          <h1 class="h4 text-gray-900 mb-4 text-center">Login</h1>

          {{-- Error global (opsional) --}}
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login.process') }}">
            @csrf

            <div class="form-group">
              <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Email"
                value="{{ old('email') }}"
                required
                autofocus
              >
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <input
                type="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Password"
                required
              >
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <div class="custom-control custom-checkbox small">
                <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="1">
                <label class="custom-control-label" for="remember">Remember me</label>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">
              Login
            </button>
          </form>

          <hr>
          <div class="text-center">
            <a href="{{ route('register') }}">Buat akun</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 