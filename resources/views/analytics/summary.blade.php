@extends('layouts.default')

@section('title', 'Analytics')

@section('content')
@include('layouts.admin-nav')
<div class="container">
    <h1>Total Products: {{ count($products) }}</h1>
    <h3 class="text-success m-0">In Stock: {{ count(array_filter($products->toArray(), fn($product) => $product['stock_quantity'] > 0)) }}</h3>
    <h3 class="text-danger">Out of Stock: {{ count(array_filter($products->toArray(), fn($product) => $product['stock_quantity'] === 0)) }}</h2>

        <table class="table table-bordered">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Cost (Original Price)</th>
                <th>Retail Price</th>
                <th>Wholesale Price</th>
                <th>Current Stock</th>
                <th>
                    <div class="d-flex align-items-start">
                        <p class="m-0 me-2">Status</p>
                        @php($stat_sort = request('stat_sort' ))
                        @if (!isset($stat_sort))
                        <a href="{{ request()->fullUrlWithQuery(['stat_sort' => 'acs']) }}" class="m-0 text-decoration-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5m-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5" />
                            </svg>️
                        </a>
                        @elseif($stat_sort === 'acs')
                        <a href="{{ request()->fullUrlWithQuery(['stat_sort' => 'desc']) }}" class="m-0 text-success text-decoration-none">IN</a>
                        @else
                        <a href="{{ request()->fullUrlWithQuery(['stat_sort' => '']) }}" class="m-0 text-danger text-decoration-none">OUT</a>
                        @endif
                    </div>
                </th>
                <th>Inventory Cost</th>
                <th>Retail Value</th>
                <th>Wholesale Value</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->original_price }} PHP</td>
                    <td>{{ $product->price }} PHP</td>
                    <td>{{ $product->wholesale_price }} PHP</td>
                    <td>{{ $product->stock_quantity }}</td>
                    <td class="{{ $product->stock_quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->stock_quantity > 0 ? 'In Stock' : 'No Stock' }}</td>
                    <td>{{ number_format($product->stock_quantity * $product->original_price, 2) }} PHP</td>
                    <td>{{ number_format($product->stock_quantity * $product->price, 2) }} PHP</td>
                    <td>{{ number_format($product->stock_quantity * $product->wholesale_price, 2) }} PHP</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endsection