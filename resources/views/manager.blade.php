@extends('layouts.default')

@section('title')
Manager Board
@endsection

@section('content')
@include('layouts.manager-nav')
@include('layouts.messenger')
<div class="container">
    <h2>Welcome, {{ auth()->user()->getName() }}</h2>
    @include('layouts.analytics')
</div>
@endsection
