@extends('layouts.template')

@section('content')
    <div class="card d-flex justify-content-center mx-auto p-2" style="width: 40rem; height: 25rem;">
        <div class="card-body p-5">
            <center>
                <h2>Login</h2>
            </center>
            <form action="{{ route('login.auth') }}" method="POST">
                @csrf
                @if (Session::get('failed'))
                    <div class="alert alert-danger mt-3"> {{ Session::get('failed') }}</div>
                @endif
                <div class="mb-3">
                    <label for="email" class="form-label @error('email') is-invalid @enderror">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label @error('password') is-invalid @enderror">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        value="{{ old('password') }}">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
@endsection
