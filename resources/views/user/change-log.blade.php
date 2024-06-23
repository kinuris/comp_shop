@extends('layouts.default')

@section('title')
Product Changelog
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

<div class="container">
    <h1>{{ $user->getName() }} Changelog:</h1>

    @foreach($changes as $change)
    @php($isSnapshot = $change->kind() === 'snapshot')
    <div class="list-group">
        @if($isSnapshot)
        <div class="list-group-item mb-2">
            <div class="row">
                <p class="col-auto m-0">ID-{{ $change->fk_product }}</p>
                <p class="{{ $change->isCreation() ? 'text-primary' : 'text-info' }} col-auto m-0 fw-bold">{{ ucwords($change->kind()) }} {{ $change->isCreation() ? '(Creation)' : '' }}</p>
                <p class="col m-0">{{ $change->product()->product_name }}</p>
                <p class="col-auto m-0"><b>Edited: {{ $change->created_at }}</b></p>
                @php($previous = $change->previous())
                @if($previous)
                <div class="row">
                    @foreach($previous->diff($change) as $field => [$from, $to])
                    <p class="col-auto m-0"><b>{{ $field }}</b> &#8658; {{ $from }} &rarr; {{ $to }}</p>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="list-group-item mb-2">
            <div class="row">
                <p class="col-auto m-0">ID-{{ $change->fk_product }}</p>
                <p class="col-auto {{ $change->isAdd() ? 'text-success' : 'text-danger' }} m-0 fw-bold">{{ ucwords($change->kind()) }}</p>
                <p class="col m-0">{{ $change->product()->product_name }}</p>
                <p class="col m-0 {{ $change->amount > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 24px; line-height: 24px;">{{ $change->amount > 0 ? '+' : '' }}{{ $change->amount }} ({{ $change->amount > 0 ? 'Added' : 'Subtracted'}})</p>
                <p class="col-auto m-0"><b>Edited: {{ $change->created_at }}</b></p>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

@endsection
