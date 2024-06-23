@extends('layouts.default')

@section('title')
Edit Product
@endsection

@section('content')

@if(auth()->user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif

@include('layouts.messenger')
<form class="container" action="/product/update/{{ $product->id }}" method="post" enctype="multipart/form-data">
    @CSRF
    @method('PUT')

    <div class="form-group mb-2">
        <label for="name">Product Name:</label>
        <input class="form-control {{ $errors->has('product_name') ? 'is-invalid' : '' }}" type="text" name="product_name" id="name" value="{{ old('product_name', $product->product_name) }}">
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
                <option value="{{ $category->id }}" {{ (old('category', $product->fk_category) == $category->id) ? "selected" : "" }}>{{ $category->category }}</option>
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
                <option value="{{ $supplier->id }}" {{ (old('supplier', $product->fk_supplier) == $supplier->id) ? "selected" : "" }}>{{ $supplier->company_name }}</option>
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
            <label for="price">Price:</label>
            <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', $product->price) }}">
            @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="col form-group">
            <label for="product-image">Product Image:</label>
            <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file" name="image" id="product-image" accept="image/jpg,image/jpeg,image/png">
            @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-auto form-group mb-2">
        <label for="available">Available:</label>
        <input class="form-check-input {{ $errors->has('available') ? 'is-invalid' : '' }}" type="checkbox" name="available" id="available" {{ old('available', $product->available) ? 'checked' : '' }}>
        @error('available')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="description">Product Description:</label>
        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" id="description" name="description" rows="5" placeholder="Enter your description here">{{ $product->description }}</textarea>
        @error('description')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>

    <a class="btn btn-danger" href="/product">Back</a>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>
@endsection
