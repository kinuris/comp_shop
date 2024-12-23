@extends('layouts.default')

@section('title')
Product List
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

@include('layouts.messenger')
<div class="container p-0 my-2">
    <form class="row w-75 mx-auto">
        <a class="btn btn-primary col-md-auto d-flex align-items-center" href="/product/create">
            <p class="m-0">Add Product</p>
        </a>
        <div class="col form-floating p-0 m-0 mx-md-2 mb-2 mb-sm-0">
            <input class="form-control" type="text" name="search" id="search" value="{{ request()->query('search') }}">
            <label for="search">Search Product</label>
        </div>
        <input class="col-md-auto btn btn-primary" type="submit" value="Search">
    </form>
    {{ $products->withQueryString()->links() }}
</div>
<ul class="p-0">
    @foreach(array_chunk($products->items(), 4) as $group)
    <div class="row justify-content-center justify-content-md-evenly mx-auto" style="max-width: 100vw;">
        @foreach($group as $product)
        <div class="d-flex justify-content-center justify-content-md-evenly col-12 col-md-6 col-lg-3 mb-3 p-0">
            <div class="card" style="width: 18rem; aspect-ratio: 4/5;">
                <!-- <img src="{{ $product['image_link'] ? asset('storage/product/image/' . $product['image_link']) : asset('/assets/images/default_product.jpg') }}" class="card-img-top" alt="{{ $product['product_name'] }}"> -->
                <div class="card-body position-relative">
                    <div class="row">
                        <h5 class="card-title fw-bold col m-0 {{ $product['stock_quantity'] === 0 || !$product['available'] ? 'text-decoration-line-through text-danger' : '' }}" style="color: #233754;">{{ $product['product_name'] }}</h5>
                        <div class="col-auto">
                            <h5 class="m-0 text-end" style="color: #233754;">₱{{ $product['price'] }}</h5>
                            <h5 class="m-0 text-end" style="font-size: 12px;">WHOLESALE: ₱{{ $product['wholesale_price'] }}</h5>
                            <h5 class="m-0 text-end" style="font-size: 12px;">ORIGINAL: ₱{{ $product['original_price'] }}</h5>
                        </div>
                    </div>
                    <p class="{{ $product['stock_quantity'] === 0 ? 'text-danger' : '' }}" style="font-size: 10px">STOCKS: ({{ $product['stock_quantity'] }})</p>
                    <p class="card-text">{{ $product->description }}</p>
                    <div class="position-absolute bottom-0">
                        <div class="btn-group mb-3 ms-1">
                            <a href="/product/restock/{{ $product->id }}" class="btn text-white" style="background-color: #FE9A01;">Restock</a>
                            <a href="/product/update/{{ $product->id }}" class="btn text-white btn-secondary">Edit</a>
                            <a href="/product/avail/toggle/{{ $product->id }}" class="btn text-white {{ $product->available ? 'btn-danger' : 'btn-primary' }}">{{ $product->available ? 'Unavailable' : 'Allow' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</ul>
@endsection