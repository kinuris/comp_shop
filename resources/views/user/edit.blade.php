@extends('layouts.default')

@section('title')
Edit Employee
@endsection

@section('content')
@include('layouts.admin-nav')
@include('layouts.messenger')

<div class="container">
    <h1>Inspecting: {{ $user->company_id }}</h1>
</div>
<form class="container" action="/employee/update/{{ $user->user_id }}" method="post">
    @csrf
    @method('PUT')

    <div class="row mb-4 mb-md-2">
        <div class="col form-group">
            <label for="first-name">First Name:</label>
            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" id="first-name" value="{{ old('first_name', $user->first_name) }}">
            @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col form-group">
            <label for="middle-name">Middle Name:</label>
            <input class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" type="text" name="middle_name" id="middle-name" value="{{ old('middle_name', $user->middle_name) }}">
            @error('middle_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 col-md form-group">
            <label for="last-name">Last Name:</label>
            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last-name" value="{{ old('last_name', $user->last_name) }}">
            @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-2">
        <div class="col form-group">
            <label for="gender">Gender:</label>
            <select class="form-select {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                @foreach(\App\Models\Gender::all() as $gender)
                <option value="{{ $gender->id }}" {{ (old('gender', $user->fk_gender) == $gender->id) ? 'selected' : '' }}>{{ $gender->gender }}</option>
                @endforeach
            </select>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col form-group">
            <label for="">Role:</label>
            <select class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" id="role">
                @foreach(\App\Models\Role::where('role', '!=', 'Admin')->get() as $role)
                <option value="{{ $role->id }}" {{ (old('role', $user->fk_role) == $role->id) ? 'selected' : '' }}>{{ $role->role }}</option>
                @endforeach
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 col-md form-group">
            <label for="birthdate">Birthdate:</label>
            <input class="form-control {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="date" name="birthdate" id="birthdate" value="{{ date('Y-m-d', strtotime($user->birthdate)) }}">
            @error('birthdate')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group mb-2">
        <label for="number">Contact Number:</label>
        <input type="tel" class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="contact_number" id="number" minlength="11" maxlength="11" value="{{ $user->contact_number }}">
        @error('contact_number')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <a class="btn btn-danger" href="/employee">Back</a>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
@endsection
