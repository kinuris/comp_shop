<div>
    <div class="container mt-5">
        <h1 class="text-center">Sales Statistics</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date</label>
                        <input name="start" type="datetime-local" class="form-control" id="startDate" step="1" value="{{ $start->format("Y-m-d\TH:i:s") }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date</label>
                        <input name="end" type="datetime-local" class="form-control" id="endDate" step="1" value="{{ $end->format("Y-m-d\TH:i:s") }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Show Statistics</button>
                </form>
            </div>
        </div>
    </div>
    <h3 class="mt-4 text-center">Total Sales: <i>{{ $start->format("m/d/Y - H:i:s") }}</i> to <i>{{ $end->format("m/d/Y - H:i:s") }}</i></h3>
    <?php

    use App\Models\Product;

    $items = array();
    $total = 0;

    foreach ($transactions as $transaction) {
        foreach ($transaction->getItems() as $pid => $qty) {
            $product = Product::find($pid);
            $total += $product->price * $qty;

            for ($i = 0; $i < $qty; $i++) {
                array_push($items, $product);
            }
        }
    }

    $categories = array_unique(array_map(fn ($item) => $item->fk_category, $items));
    ?>

    <h1 class="text-center">₱{{ number_format($total, 2, '.', ',') }}</h1>
    <div class="container mt-4">
        <h4>By Category:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop through your categories -->
                @foreach($categories as $cid)
                @php($category = \App\Models\Category::find($cid))
                @php($filtered = array_filter($items, fn($item) => $item->fk_category === $cid))
                @php($prices = array_map(fn($item) => $item->price, $filtered))
                <tr>
                    <td>{{ $category->category }}</td>
                    <td>x{{ count($filtered) }}</td>
                    <td>₱{{ number_format(array_sum($prices), 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="container mt-4">
        <h4>By Product:</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach(array_count_values(array_map(fn($item) => $item->id, $items)) as $pid => $qty)
                @php($product = \App\Models\Product::find($pid))
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>x{{ $qty }}</td>
                    <td>₱{{ $product->price * $qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
