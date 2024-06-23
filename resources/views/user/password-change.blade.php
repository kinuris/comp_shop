@extends('layouts.default')

@section('title')
Change Password
@endsection

@section('content')
@if(auth()->user()->getRole()->role === 'Admin')
@include('layouts.admin-nav')
@elseif(auth()->user()->getRole()->role === 'Manager')
@include('layouts.manager-nav')
@else
@include('layouts.user-nav')
@endif

@include('layouts.messenger')

<div class="container">
    <h1>Change Password</h1>
</div>
<form class="container" method="post" action="/password-change/{{ auth()->user()->user_id }}">
    @csrf
    @method('PUT')

    <div class="form-group mb-3">
        <label for="old-password">Old Password:</label>
        <input class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}" type="password" name="old_password" id="old-password" required>
        @error('old_password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="new-password">New Password:</label>
        <input class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}" type="password" name="new_password" id="new-password" required>
        @error('new_password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="new-password-confirm">Confirm New Password:</label>
        <input class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : '' }}" type="password" name="new_password_confirmation" id="new-password-confirm" required>
        @error('new_password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Change Password</button>
</form>


@endsection
