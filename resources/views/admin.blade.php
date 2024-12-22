@extends('layouts.default')

@section('title')
Admin Account
@endsection

@section('content')
@include('layouts.admin-nav')
@include('layouts.messenger')

<div class="container">
    <h2>Welcome, {{ auth()->user()->getName() }}</h2>
    @include('layouts.analytics')
</div>
@endsection
