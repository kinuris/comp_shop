<div class="modal fade" id="receiptModal" tabIndex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-1">
                <table class="table mb-1">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($discounts = $transaction->getDiscounts())
                        <?php $subtotal = 0 ?>

                        @foreach($transaction->getItems() as $pid => $qty)
                        @php($product = \App\Models\Product::find($pid))
                        <?php $total = 0 ?>
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td><b>x</b>{{ $qty }}</td>
                            @if(isset($discounts[$pid]))

                            @php($discount = \App\Models\Discount::find($discounts[$pid]))
                            @if($discount->type === 'absolute')

                            @php($price = $product->price - $discount->absolute_discount)
                            <td>₱{{ $price }}</td>
                            <?php $total += $price * $qty ?>

                            @else

                            @php($price = $product->price - ($discount->percentage_discount / 100) * $product->price)
                            <td>₱{{ $price }}</td>
                            <?php $total += $price * $qty ?>

                            @endif

                            @else
                            <td>₱{{ $product->price }}</td>
                            <?php $total += $product->price * $qty ?>
                            @endif
                            <td>₱{{ round($total, 2) }}</td>
                        </tr>
                        <?php $subtotal += $total ?>
                        @endforeach
                    </tbody>
                </table>
                <p class="m-0 text-secondary fw-bold">SUBTOTAL: ₱{{ round($subtotal, 2) }}</p>
                <p class="m-0 text-secondary fw-bold">SALES TAX: ₱{{ round($subtotal * 0.12, 2) }}</p>
                <p class="m-0 text-secondary fw-bold">TOTAL: ₱{{ round($subtotal + $subtotal * 0.12, 2) }}</p>
            </div>
            <div class="modal-footer">
                <h2 class="me-auto m-0">Thank You!</h2>
                <p class="modal-title text-muted me-auto m-0" style="font-size: 12px">Transaction ID: {{ $transaction->id }}</p>
                <p class="modal-title text-muted me-auto m-0" style="font-size: 12px">Date: {{ $transaction->created_at }}</p>
                @php($method = \App\Models\PaymentMethod::find($transaction->fk_payment_method))
                <p class="modal-title text-muted me-auto m-0 w-100" style="font-size: 12px">Payment Method: {{ $method->method_name }}</p>
            </div>
            <div id="footer" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt()">Print</button>
            </div>
        </div>
    </div>
    <script>
        function printReceipt() {
            printJS({
                printable: 'receiptModal',
                type: 'html',
                css: '{{ asset("css/bootstrap.min.css") }}',
                ignoreElements: ['footer'],
            });
        }
    </script>
</div>
