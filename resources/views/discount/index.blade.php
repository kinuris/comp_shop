@extends('layouts.default')

@section('title')
Manage Discounts
@endsection

@section('content')
@include('layouts.admin-nav')
@include('layouts.messenger')
<div class="container">
    <h1>Manage Discounts</h1>
    <a class="btn btn-primary mb-3" href="/discount/create">Create</a>

    <ul class="list-group">
        @foreach($discounts as $discount)
        <div class="list-group-item">
            <div class="row">
                <p class="col-auto">{{ $discount->name }}</p>
                <div class="col"></div>
                <a class="col-auto btn btn-primary ms-1">View</a>
                <a href="/discount/update/{{ $discount->id }}" class="col-auto btn btn-secondary ms-1">Edit</a>
                <a href="/discount/disable/{{ $discount->id }}" class="col-auto btn btn-danger ms-1">Disable</a>
            </div>
        </div>
        @endforeach
    </ul>
</div>
@endsection
