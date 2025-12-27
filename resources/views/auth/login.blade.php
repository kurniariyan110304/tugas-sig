@extends('layouts.auth')

@section('title', 'Login Peta Fasilitas Umum')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-75 justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-4 text-center">
                        <img src="{{ asset('svg/logo.svg') }}" alt="Logo Fasilitas Umum" class="mb-3" width="120">
                        <h1 class="h4 text-gray-900 mb-4 text-center">Login</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
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
