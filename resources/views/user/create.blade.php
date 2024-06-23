@extends('layouts.default')

@section('title')
Create Employee
@endsection

@section('content')
@include('layouts.admin-nav')
@include('layouts.messenger')
<form class="container" action="/employee/create" method="post">
    <h1>Create User</h1>
    @csrf

    <div class="row mb-4 mb-md-2">
        <div class="col form-group">
            <label for="first-name">First Name:</label>
            <input class="form-control {{ $errors->has('first_name') ? 'is-invalid' : '' }}" type="text" name="first_name" id="first-name">
            @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col form-group">
            <label for="middle-name">Middle Name:</label>
            <input class="form-control {{ $errors->has('middle_name') ? 'is-invalid' : '' }}" type="text" name="middle_name" id="middle-name">
            @error('middle_name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 col-md form-group">
            <label for="last-name">Last Name:</label>
            <input class="form-control {{ $errors->has('last_name') ? 'is-invalid' : '' }}" type="text" name="last_name" id="last-name">
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
                <option value="{{ $gender->id }}">{{ $gender->gender }}</option>
                @endforeach
            </select>
            @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col form-group">
            <label for="role">Role:</label>
            <select class="form-select {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role" id="role">
                @foreach(\App\Models\Role::where('role', '!=', 'Admin')->get() as $role)
                <option value="{{ $role->id }}">{{ $role->role }}</option>
                @endforeach
            </select>
            @error('role')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-12 col-md form-group">
            <label for="birthdate">Birthdate:</label>
            <input class="form-control {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="date" name="birthdate" id="birthdate">
            @error('birthdate')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="form-group mb-2">
        <label for="number">Contact Number:</label>
        <input type="tel" class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="contact_number" id="number" minlength="11" maxlength="11">
        @error('contact_number')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <p class="m-0 mb-3 text-secondary">NOTE: Default password is user first name concatenated with user last name all lower caps</p>

    <a href="/employee" class="btn btn-danger">Back</a>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
@endsection
