@extends('layouts.auth')

@section('title', 'Register Peta Fasilitas Umum')

@section('content')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="w-50 row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body text-center">
                        <img src="{{ asset('svg/logo.svg') }}" alt="Logo Fasilitas Umum" class="mb-3" width="120">
                        <h1 class="h4 text-gray-900 mb-4 text-center">Register</h1>

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

                        <form method="POST" action="{{ route('register.process') }}">
                            @csrf

                            <div class="form-group">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Nama"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Konfirmasi Password" required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Register
                            </button>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a href="{{ route('login') }}">Sudah punya akun</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
