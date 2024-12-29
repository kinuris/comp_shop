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
                <input class="form-control" type="text" name="search" id="search">
                <label for="search">Search Transaction Date</label>
            </div>
            <button class="col-auto btn btn-primary ms-2" type="submit">Search</button>
        </div>
    </form>
    <div class="row justify-content-evenly">
        @foreach($history as $tid => $items)
        <div class="card col-6 mb-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Transaction ID: {{ $tid }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Date of Transaction: 2024-06-15</h6>
                @if(isset($peek_user))
                <a href="/history/{{ $peek_user }}?modal={{ $tid }}" class="btn btn-primary">View Receipt</a>
                @else
                <a href="/history?modal={{ $tid }}" class="btn btn-primary">View Receipt</a>
                @endif
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
