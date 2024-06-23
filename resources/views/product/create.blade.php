@extends('layouts.default')

@section('title')
Create Product
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

@include('layouts.messenger')
<form class="container" action="/product/create" method="post" enctype="multipart/form-data">
    <h1>Create Product</h1>
    @csrf

    <div class="form-group mb-2">
        <label for="name">Product Name:</label>
        <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="name">
        @error('product_name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="row mb-2">
        <div class="col form-group">
            <label for="category">Category:</label>
            <select class="form-select {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category">
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
            @error('category')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col form-group">
            <label for="supplier">Supplier:</label>
            <select class="form-select {{ $errors->has('supplier') ? 'is-invalid' : '' }}" name="supplier" id="supplier">
                @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                @endforeach
            </select>
            @error('supplier')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row mb-2">
        <div class="col form-group">
            <label for="stock-quantity">Stock Quantity:</label>
            <input class="form-control {{ $errors->has('stock_quantity') ? 'is-invalid' : '' }}" type="number" name="stock_quantity" id="stock-quantity">
            @error('stock_quantity')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col form-group">
            <label for="price">Price:</label>
            <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price">
            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="row mb-2">
        <div class="col form-group">
            <label for="available">Available:</label>
            <input class="form-check-input {{ $errors->has('available') ? 'is-invalid' : '' }}" type="checkbox" name="available" id="available">
            @error('available')
            <span class="invalid-feedback" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

        <div class="col form-group">
            <label for="product-image">Product Image:</label>
            <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="product-image">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="description">Product Description:</label>
        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description" rows="5" placeholder="Enter your description here"></textarea>
        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <a href="/product" class="btn btn-danger">Back</a>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
@endsection
