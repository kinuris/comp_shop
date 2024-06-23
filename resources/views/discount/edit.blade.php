@extends('layouts.default')

@section('title')
Edit Discount
@endsection

@section('content')
@include('layouts.admin-nav')
<div class="container">
    <h1>{{ $discount->name }}</h1>
    <form action="/discount/update/{{ $discount->id }}" method="post">
        @csrf

        <div class="form-floating mb-3">
            <input class="form-control" type="text" name="name" id="name" value="{{ $discount->name }}">
            <label for="name">Name:</label>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <select class="form-select" name="type" id="type">
                <option value="absolute" {{ $discount->isAbsolute() ? 'selected' : '' }}>Absolute Discount</option>
                <option value="percentage" {{ $discount->isAbsolute() ? '' : 'selected' }}>Percentage Discount</option>
            </select>
            <label for="type">Discount Type:</label>
            @error('type')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" type="number" name="value" id="value" value="{{ $discount->isAbsolute() ? $discount->absolute_discount : $discount->percentage_discount }}">
            <label for="value">Value:</label>
            @error('value')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div id="applicable" class="form-group mb-3">
            <label for="choice">Choose Applicable Products:</label>
            <select class="form-select" multiple name="applicable[]" id="choice"></select>
            @error('applicable')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="general">General Discount:</label>
            <input type="checkbox" name="general" id="general" {{ $discount->isGeneral() ? 'checked' : '' }}>
            @error('general')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>


        <a href="/discount" class="btn btn-danger">Back</a>
        <button class="btn btn-primary" type="submit">Save Discount</button>
    </form>
    <script>
        const general = document.getElementById('general');
        const applicable = document.getElementById('applicable');

        window.addEventListener('load', function() {
            if (general.checked) {
                applicable.style.display = 'none';
            } else {
                applicable.style.display = 'block';
            }

            general.addEventListener('change', function() {
                if (general.checked) {
                    applicable.style.display = 'none';
                } else {
                    applicable.style.display = 'block';
                }
            });

            const element = document.getElementById('choice');
            const choices = new Choices(element, {
                allowHTML: true,
                removeItemButton: true,
                searchPlaceholderValue: 'Choose applicable products or do it later',
                searchResultLimit: 10,
                choices: [
                    <?php

                    use App\Models\Category;
                    use App\Models\ApplicableDiscount;

                    foreach ($products as $product) {
                        $category = Category::query()->find($product->fk_category);
                        $selected = count(ApplicableDiscount::query()
                            ->where('fk_product', '=', $product->id)
                            ->where('fk_discount', '=', $discount->id)
                            ->get()) > 0 ? 'true' : 'false';

                        echo "{ value: $product->id, label: \"$category->category: $product->product_name (₱$product->price)\", selected: $selected },\n";
                    }
                    ?>
                ]
            });

        });
    </script>
</div>
@endsection
