@extends('layouts.default')

@section('title')
Records History
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

@include('layouts.messenger')
<div class="container">
    <h1>Records History</h1>
    <form action="">
        <div class="row mb-3">
            <div class="p-0 col form-floating">
                <input value="{{ request()->query('search') }}" class="form-control" type="text" name="search" id="search">
                <label for="search">Search Transaction Date</label>
            </div>
            <button class="col-auto btn btn-primary ms-2" type="submit">Search</button>
        </div>
        <div class="d-flex mb-3 align-items-center">
            <label class="form-label mb-0 me-2" for="start">Start:</label>
            <input value="{{ date_format($start, 'Y-m-d') }}" class="form-control me-3" type="date" name="start" id="start">

            <label class="form-label mb-0 me-2" for="end">End:</label>
            <input value="{{ date_format($end, 'Y-m-d') }}" class="form-control me-3" type="date" name="end" id="end">

            <label class="form-label mb-0 me-2" for="method">Payment Method:</label>
            <select class="form-select" name="methodsort" id="method">
                <option value="-1">All</option>
                @foreach (\App\Models\PaymentMethod::all() as $methods)
                <option value="{{ $methods->id }}" {{ (request()->query('methodsort') == $methods->id) ? "selected" : "" }}>{{ $methods->method_name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <div class="d-flex mb-3">
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="btn @if (request()->query('sort') !== 'oldest') btn-primary @else btn-secondary @endif me-2">Latest First</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}" class="btn @if (request()->query('sort') === 'oldest') btn-primary @else btn-secondary @endif">Oldest First</a>
    </div>
    <div class="row justify-content-evenly">
        @foreach($history as $items)
        <div class="card col-6 mb-3" style="width: 18rem;">
            <div class="card-body">
                @php($tid = $items[0]->id)
                <h5 class="card-title">Transaction ID: {{ $tid }}</h5>
                @php($transaction = \App\Models\PaymentTransaction::find($tid))
                <h6 class="card-subtitle mb-2 text-muted">Date of Transaction: {{ date_format($transaction->created_at, 'M. d, Y H:i:s') }}</h6>
                @if(isset($peek_user))
                <a href="/history/{{ $peek_user }}?modal={{ $tid }}" class="btn btn-primary">View Receipt</a>
                @else
                <a href="/history?modal={{ $tid }}" class="btn btn-primary">View Receipt</a>
                @endif
                <a href="/history/delete/{{ $tid }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
        @endforeach
    </div>
</div>

@if(isset($modal))
{!! $modal !!}
<script>
    window.addEventListener('load', function() {
        const modal = document.getElementById('receiptModal');
        new bootstrap.Modal(modal).show();
    });
</script>
@endif

@endsection