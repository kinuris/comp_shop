@extends('layouts.default')

@section('title')
Restock Product
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

@include('layouts.messenger')
<div class="container">
    <h1>Restocking {{ $product->product_name }}</h1>
    <h3>Current Stock: {{ $product->stock_quantity }}</h3>
    <form action="/product/restock/{{ $product->id }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-2">
            <label for="stock">Restock Quantity:</label>
            <input class="form-control {{ $errors->has('stock') ? 'is-invalid' : '' }}" type="number" name="stock" id="stock" value="{{ old('stock') }}">
            @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a class="btn btn-danger" href="/product">Back</a>
        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
    <h4 class="mt-3">Restock History:</h4>
    <div class="list-group">
        @php($history = \App\Models\ProductRestock::where('fk_product', '=', $product->id)->get())
        @foreach($history as $restock)
        <div class="list-group-item">
            <div class="row">
                <p class="col m-0">{{ \App\Models\User::find($restock->fk_user)->getName() }}</p>
                <p class="col m-0 {{ $restock->amount > 0 ? 'text-success' : 'text-danger' }}" style="font-size: 24px; line-height: 24px;">{{ $restock->amount > 0 ? '+' : '' }}{{ $restock->amount }} ({{ $restock->amount > 0 ? 'Added' : 'Subtracted'}})</p>
                <p class="col m-0 text-end">{{ $restock->created_at }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
