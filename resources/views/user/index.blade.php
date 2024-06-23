@extends('layouts.default')

@section('title')
Manage Employees
@endsection

@section('content')
@include('layouts.admin-nav')
@include('layouts.messenger')
<div class="container">
    <h1>Manage Employees</h1>
    <a class="btn btn-primary mb-3" href="/employee/create">Create</a>
    <div class="row justify-content-evenly">
        @foreach($users as $user)
        <div class="col-3 card mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $user->getName() }}{!! $user->user_id === auth()->user()->user_id ? ' <b>(Self)</b>' : '' !!}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ $user->getRole()->role }}</h6>
                <a href="tel:{{ $user->contact_number }}" class="card-text m-0"> {{ $user->contact_number }}</a>
                <p class="card-text">Company ID: {{ $user->company_id }}</p>
            </div>
            <div class="row mx-1">
                @if($user->getRole()->role === 'Manager')
                <a class="col btn btn-primary mb-2" href="/history/{{ $user->user_id }}">View Changes</a>
                @else
                <a class="col btn btn-primary mb-2" href="/history/{{ $user->user_id }}">View History</a>
                @endif
                @if(!$user->isAdmin())
                <div class="col-auto px-1"></div>
                <a href="/employee/update/{{ $user->user_id }}" class="col btn btn-secondary mb-2 d-flex justify-content-center align-items-center">
                    <p class="m-0">Edit</p>
                </a>
                <a href="/employee/suspend/{{ $user->user_id }}" class="col-12 btn @if($user->suspended) btn-secondary @else btn-danger @endif mb-2">@if($user->suspended) Resume @else Suspend @endif</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <ul class="list-group">
    </ul>
</div>
@endsection
