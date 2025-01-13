@extends('layouts.default')

@section('title', 'Analytics')

@section('content')
@if (Auth::user()->isAdmin())
@include('layouts.admin-nav')
@else
@include('layouts.manager-nav')
@endif
<div class="container">
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="infoBox" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Information</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                This is an information box.
            </div>
        </div>
    </div>

    <div id="summaryPrintable">
        <h1>Total Products: {{ count($products) }}</h1>
        <h3 class="text-success m-0">In Stock: {{ count(array_filter($products->toArray(), fn($product) => $product['stock_quantity'] > 0)) }}</h3>
        <h3 class="text-danger">Out of Stock: {{ count(array_filter($products->toArray(), fn($product) => $product['stock_quantity'] === 0)) }}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
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
                </tr>
            </thead>
            <tbody>
                <?php
                $invCostTotal = 0;
                $retCostTotal = 0;
                $wholCostTotal = 0;
                ?>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->original_price }} PHP</td>
                    <td>{{ $product->price }} PHP</td>
                    @if (isset($product->wholesale_price))
                    <td>{{ $product->wholesale_price }} PHP</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <td>
                        <form class="restocking-forms" data-product-id="{{ $product->id }}" data-original-stock="{{ $product->stock_quantity }}" action="/product/restock/{{ $product->id }}" method="POST">
                            @csrf
                            <div class="d-flex">
                                <input tabindex="{{ $loop->iteration }}" type="number" name="new_stock" value="{{ $product->stock_quantity }}" class="form-control" style="max-width: 96px;" />
                                <div class="mx-1"></div>
                                <button type="button" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </td>
                    <td class="{{ $product->stock_quantity > 0 ? 'text-success' : 'text-danger' }}">{{ $product->stock_quantity > 0 ? 'In Stock' : 'No Stock' }}</td>
                    @php($invCost = $product->stock_quantity * $product->original_price)
                    <td>{{ number_format($invCost, 2) }} PHP</td>
                    @php($retCost = $product->stock_quantity * $product->price)
                    <td>{{ number_format($retCost, 2) }} PHP</td>
                    @php($wholCost = $product->stock_quantity * $product->wholesale_price)
                    @if (isset($product->wholesale_price))
                    <td>{{ number_format($wholCost, 2) }} PHP</td>
                    @else
                    <td>N/A</td>
                    @endif
                    <?php
                    $invCostTotal += $invCost;
                    $retCostTotal += $retCost;
                    $wholCostTotal += $wholCost;
                    ?>
                </tr>
                @endforeach
                <tr style="border-top: 2px solid black;">
                    <td>
                        <b>TOTAL</b>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>{{ number_format($invCostTotal, 2) }} PHP</b></td>
                    <td><b>{{ number_format($retCostTotal, 2) }} PHP</b></td>
                    <td><b>{{ number_format($wholCostTotal, 2) }} PHP</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <button class="btn btn-primary" onclick="printReceipt()">Print</button>
    <a href="/summary/export" class="btn btn-secondary">Export to Excel</a>
</div>
<script>
    document.querySelectorAll('.restocking-forms').forEach(form => {
        form.addEventListener('submit', (e) => {
            syncStock();
            e.preventDefault();
        })

        form.querySelector('button').addEventListener('click', syncStock);

        async function syncStock() {
            const originalStock = form.getAttribute('data-original-stock');
            const newStock = form.querySelector('input[name="new_stock"]').value;
            const productId = form.getAttribute('data-product-id');

            if (originalStock === newStock) {
                return;
            }

            const stock = newStock - originalStock;

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'stock';
            hiddenInput.value = stock;
            form.appendChild(hiddenInput);

            const summaryInput = document.createElement('input');
            summaryInput.type = 'hidden';
            summaryInput.name = 'summary';
            summaryInput.value = 1;
            form.appendChild(summaryInput);

            const response = await fetch('/product/restock/' + productId, {
                method: 'POST',
                body: new FormData(form),
            });

            const data = await response.json();

            if (response.ok) {
                form.setAttribute('data-original-stock', newStock);

                document.getElementById('infoBox').classList.add('show');
                document.querySelector('.toast-body').innerText = data.message;
                if (data.message.includes('subtracted')) {
                    document.querySelector('.toast-body').style.color = 'red';
                } else {
                    document.querySelector('.toast-body').style.color = 'green';
                }

                setTimeout(() => {
                    document.getElementById('infoBox').classList.remove('show');
                }, 3000);
            }
        }
    });

    function printReceipt() {
        printJS({
            printable: 'summaryPrintable',
            type: 'html',
            css: '{{ asset("css/bootstrap.min.css") }}',
            ignoreElements: ['footer'],
        });
    }
</script>
@endsection