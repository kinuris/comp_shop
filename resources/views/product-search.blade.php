@extends('layouts.default')

@section('title')
Retail Price
@endsection

@section('content')
<livewire:product-search :wholesale=false />
@endsection
