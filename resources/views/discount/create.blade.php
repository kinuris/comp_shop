@extends('layouts.default')

@section('title')
Create Discounts
@endsection

@section('content')
@include('layouts.admin-nav')
<div class="container">
    <h1>Create Discounts</h1>
</div>
<div class="container">
    <form action="/discount/create" method="post">
        @csrf
        <div class="form-floating mb-3">
            <input class="form-control" type="text" name="name" id="name">
            <label for="name">Name:<label>
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" name="type" id="type">
                <option value="absolute">Absolute Discount</option>
                <option value="percentage">Percentage Discount</option>
            </select>
            <label for="type">Discount Type:</label>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="value" id="value">
            <label for="value">Value:</label>
        </div>

        <div class="form-group mb-3">
            <label for="general">General Discount:</label>
            <input type="checkbox" name="general" id="general">
        </div>

        <div id="applicable" class="form-group mb-3">
            <label for="choice">Choose Applicable Products:</label>
            <select class="form-select" multiple name="applicable[]" id="choice"></select>
        </div>

        <a class="btn btn-danger" href="/discount">Back</a>
        <button class="btn btn-primary" type="submit">Save Discount</button>
    </form>
</div>

<script>
    window.addEventListener('load', function() {
        const element = document.getElementById('choice');
        const general = document.getElementById('general');

        general.addEventListener('change', function() {
            document.querySelector('#applicable').style.display = general.checked ? 'none' : 'block';
        });

        const choices = new Choices(element, {
            allowHTML: true,
            removeItemButton: true,
            searchPlaceholderValue: 'Choose applicable products or do it later',
            searchResultLimit: 10,
            choices: [
                <?php

                use App\Models\Category;

                foreach ($products as $product) {
                    $category = Category::query()->find($product->fk_category);

                    echo "{ value: $product->id, label: '$category->category: $product->product_name (₱$product->price)' },\n";
                }
                ?>
            ]
        });
    });
</script>
@endsection
