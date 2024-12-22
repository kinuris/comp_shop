@extends('layouts.default')

@section('title')
Login
@endsection

@section('style')
<style>
    body {
        background: linear-gradient(to bottom, #f2f2f2, #ff0000);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background-color: #2f2f2f;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        padding: 30px;
        width: max(37vw, 300px);
        text-align: center;
        label: text-decoration
    }

    .login-container h1 {
        color: #ff9800;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .login-container img {
        max-width: 75%;
        margin-bottom: 20px;
    }

    .login-container .form-control {
        margin-bottom: 15px;
    }

    .login-container a {
        color: #fff;
        text-decoration: none;
        display: block;
        margin-bottom: 20px;
    }

    .login-container a:hover {
        text-decoration: underline;
    }

    .login-container .btn {
        background-color: #efc300;
        border: none;
    }

    .login-container .btn:hover {
        background-color: #ffd500;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    @include('layouts.messenger')
    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Yhamz">
    <form action="/login" method="POST">
        @csrf

        <div class="mb-3">
            <label for="company-id" class="form-label text-white" >User ID:</label>
            <input type="text" class="form-control {{ $errors->has('company_id') ? 'is-invalid' : '' }}" id="company-id" name="company_id" placeholder="Enter your User ID" required value="{{ old('company_id') }}">
            @error('company_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-white">Password:</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password" name="password" placeholder="Enter your password" required>
            @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <a href="#" class="text-white">Forgot Password?</a>

        <button type="submit" class="btn btn-primary w-100"><label for="Login" class="form-label text-black" class="form text-align: center;">Login</button>
    </form>
</div>
@endsection
