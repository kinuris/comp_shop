<div>
    @include('layouts.user-nav')
    @include('layouts.messenger')
    <div class="container">
        <div class="card m-3">
            <div class="card-img-top">
                <hr>
                <h1 class="text-center">Shopping Cart</h1>
                <hr>
                <div class="m-1 row">
                    <h2 class="col-4 text-end text-lg-start" style="font-size: 20px;">Unit</h2>
                    <h2 class="col-3 text-end text-lg-start" style="font-size: 20px;">QTY</h2>
                    <h2 class="col-4 text-end text-lg-start" style="font-size: 20px;">Price</h2>
                    <hr>
                </div>
                @foreach($this->itemsAndQuantity as [$product, $qty])
                <div class="row">
                    <p class="col-4 ps-lg-4 text-end text-lg-start {{ $product->stock_quantity < $qty ? 'text-danger' : '' }}">
                        <b>{{ $product->product_name }}</b>
                        @if(isset($this->discountAssoc[$product->id]))
                        <img wire:click="chooseDiscount({{ $product->id }})" width="20px" src="{{ asset('assets/images/applied.png') }}" alt="Discounted Item">
                        @else
                        <img wire:click="chooseDiscount({{ $product->id }})" width="24px" src="{{ asset('assets/images/discount.png') }}" alt="Discounted Item">
                        @endif
                    </p>
                    <p class="col-3 text-end text-lg-start" style="font-size: 20px;">
                        <a wire:click="removeProduct({{ $product->id }})" class="text-decoration-none" style="font-size: 20px;">&lt;</a>
                        {{ $qty }}
                        <a wire:click="addProduct({{ $product->id }})" class="text-decoration-none" style="font-size: 20px;">&gt;</a>
                    </p>
                    @if(isset($this->discountAssoc[$product->id]))
                    <p class="col-4 text-end text-lg-start">₱{{ \App\Models\Discount::find($this->discountAssoc[$product->id])->solveFinal($product->price) * $qty }} <i class="d-block d-md-inline" style="font-size: 12px; color: grey;">{{ $qty }} x ₱{{ \App\Models\Discount::find($this->discountAssoc[$product->id])->solveFinal($product->price) }}</i></p>
                    @else
                    <p class="col-4 text-end text-lg-start">₱{{ $product->price * $qty }} <i class="d-block d-md-inline" style="font-size: 12px; color: grey;">{{ $qty }} x ₱{{ $product->price }}</i></p>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="card-body">
                <div class="d-flex w-25 justify-content-between">
                    <p>Total:</p>
                    <p class="fw-bold">₱{{ $this->totalPrice }}</p>
                </div>
                <div class="container row p-0 mx-auto">
                    <a wire:click="checkout()" class="btn btn-primary col col-md-2 me-2 mb-md-0 d-flex justify-content-center align-items-center">
                        <p class="m-0">CHECK OUT</p>
                    </a>
                    <div class="form-floating col-6 col-md p-0">
                        <select wire:model="method" class="form-select" id="payment-method">
                            @foreach($methods as $method)
                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                            @endforeach
                        </select>
                        <label for="payment-method">Payment Method</label>
                    </div>
                </div>
            </div>
        </div>
        <label for="search" class="d-none">Search</label>
        <input wire:model.live="search" class="form-control me-2 mb-3" type="text" name="search" id="search" placeholder="Search">

        {{ $products->withQueryString()->links() }}
    </div>

    @foreach(array_chunk($products->items(), 4) as $group)
    <div class="row justify-content-center justify-content-md-evenly mx-auto " style="max-width: 100vw;">
        @foreach($group as $product)
        <div class="d-flex justify-content-center justify-content-md-evenly col-12 col-md-6 col-lg-3 mb-3 p-0">
            <div class="card overflow-hidden" style="width: 18rem">
                <img src="{{ $product['image_link'] ? asset('storage/product/image/' . $product['image_link']) : asset('/assets/images/default_product.jpg') }}" class="card-img-top" alt="{{ $product['product_name'] }}">
                <div class="card-body position-relative">
                    @if(\App\Models\ApplicableDiscount::where('fk_product', '=', $product->id)->first())
                    <div class="position-absolute bottom-0 end-0 w-100" style="height: 20px;">
                        <p title="discounts" class="position-absolute m-0 text-white" style="padding: 0px 0px 4px 0; z-index: 1; transform: rotate(45deg);">{{ count(\App\Models\ApplicableDiscount::able()->where('fk_product', '=', $product->id)->get()) }}</p>
                        <div title="discounts" class="position-absolute" style="z-index: 0; transform: rotate(45deg); width: 48px; height: 10px; border-bottom: 24px solid red; left: -18px; bottom: -6px"></div>
                    </div>
                    @endif
                    <div class="row">
                        <h5 class="card-title fw-bold col m-0 {{ $product->stock_quantity === 0 ? 'text-decoration-line-through text-danger' : '' }}" style="color: #233754;">{{ $product['product_name'] }}</h5>
                        <h5 class="col-auto fw-bold m-0" style="color: #233754;">₱{{ $product['price'] }}</h5>
                    </div>
                    <p class="{{ $product->stock_quantity === 0 ? 'text-danger' : '' }}" style="font-size: 10px">STOCKS: ({{ $product->stock_quantity }})<b class="{{ $product->stock_quantity < $this->getSelectedQuantity($product->id) ? 'text-danger' : '' }}">{{ $this->getSelectedQuantity($product->id) ? ' x' . $this->getSelectedQuantity($product->id) : '' }}</b></p>
                    <p class="card-text">{{ $product->description }}</p>
                    <a wire:click="addProduct({{ $product['id'] }})" class="btn text-white" style="background-color: #FE9A01;">Add</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    <!-- Insufficient Modal -->
    <div class="modal fade" id="insufficient-modal" tabindex="-1" aria-labelledby="insufficientModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="insufficientModal">Insufficient Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @foreach($this->insufficient as $item)
                    <p><b class="text-danger"><i>{{ $item->product_name }}</i></b> has <b class="text-danger"><i>{{ $item->stock_quantity }}</i></b> items left. <b class="text-danger">{{ $item->required }}</b> Required.</p>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Discounts Modal -->
    <!-- <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true"> -->
    <!--     <div class="modal-dialog" role="document"> -->
    <!--         <div class="modal-content"> -->
    <!--             <div class="modal-header"> -->
    <!--                 <h5 class="modal-title" id="discountModalLabel">Discounts for Product XYZ</h5> -->
    <!--                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
    <!--                     <span aria-hidden="true">&times;</span> -->
    <!--                 </button> -->
    <!--             </div> -->
    <!--             <div class="modal-body"> -->
    <!--                 <div class="card"> -->
    <!--                     <div class="card-header"> -->
    <!--                         10% Off -->
    <!--                     </div> -->
    <!--                     <div class="card-body"> -->
    <!--                         <p class="card-text">Use code <strong>DISCOUNT10</strong> at checkout.</p> -->
    <!--                     </div> -->
    <!--                 </div> -->
    <!--                 <div class="card mt-3"> -->
    <!--                     <div class="card-header"> -->
    <!--                         $5 Off -->
    <!--                     </div> -->
    <!--                     <div class="card-body"> -->
    <!--                         <p class="card-text">Automatically applied when you buy 2 or more items.</p> -->
    <!--                     </div> -->
    <!--                 </div> -->
    <!--             </div> -->
    <!--             <div class="modal-footer"> -->
    <!--                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
    <!--             </div> -->
    <!--         </div> -->
    <!--     </div> -->
    <!-- </div> -->
</div>

@script
<script>
    const insufficientModal = new bootstrap.Modal(document.querySelector('#insufficient-modal'));
    const printReceipt = document.querySelector('#print');

    $wire.on('show-discounts', function({
        product,
        discounts
    }) {
        const existing = document.body.querySelector('#discountModal');
        if (existing) {
            existing.addEventListener('hide.bs.modal', function() {
                setTimeout(() => document.body.removeChild(existing), 500);
            });

            bootstrap.Modal.getOrCreateInstance(existing).hide();
        }

        function createModal() {
            const discount = createDiscountModal(discounts, product);
            document.body.appendChild(discount);

            discount.addEventListener('hide.bs.modal', function() {
                setTimeout(() => document.body.removeChild(discount), 1000);
            });

            const discountModal = new bootstrap.Modal(discount);

            discountModal.show();
        }

        createModal();
    });

    $wire.on('insufficient', function() {
        insufficientModal.show();
    });

    $wire.on('checkout', function({
        items,
        quantities,
        transaction,
        discounts,
        method,
    }) {
        const receipt = createReceiptModal(items, quantities, transaction, discounts, method);
        document.body.appendChild(receipt);

        receipt.addEventListener('hide.bs.modal', function() {
            setTimeout(() => document.body.removeChild(receipt), 1000);
        });

        const receiptModal = new bootstrap.Modal(receipt);

        receiptModal.show();
    });

    function createDiscountModal(discounts, product) {
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = 'discountModal';
        modal.setAttribute('role', 'dialog')
        modal.setAttribute('tabIndex', '-1')
        modal.setAttribute('aria-labelledby', 'discountModalLabel');
        modal.setAttribute('aria-hidden', 'true');

        const modalDialog = document.createElement('div');
        modalDialog.classList.add('modal-dialog');
        modalDialog.setAttribute('role', 'document');

        const modalContent = document.createElement('div');
        modalContent.classList.add('modal-content');

        const modalHeader = document.createElement('div');
        modalHeader.classList.add('modal-header');
        const modalTitle = document.createElement('h5');
        modalTitle.classList.add('modal-title');
        modalTitle.id = 'discountModalLabel';
        modalTitle.innerHTML = `Discounts for Product <b>${product.product_name}</b>`;
        modalHeader.appendChild(modalTitle);

        const modalBody = document.createElement('div');
        modalBody.classList.add('modal-body');

        for (const discount of discounts) {
            const card = createDiscountCard(discount, product);

            modalBody.appendChild(card);
        }

        const modalFooter = document.createElement('div');
        modalFooter.classList.add('modal-footer');
        const closeButtonFooter = document.createElement('button');
        closeButtonFooter.type = 'button';
        closeButtonFooter.classList.add('btn', 'btn-secondary');
        closeButtonFooter.setAttribute('data-bs-dismiss', 'modal');
        closeButtonFooter.textContent = 'Close';
        modalFooter.appendChild(closeButtonFooter);

        modalContent.appendChild(modalHeader);
        modalContent.appendChild(modalBody);
        modalContent.appendChild(modalFooter);

        modalDialog.appendChild(modalContent);
        modal.appendChild(modalDialog);

        return modal;
    }

    function createDiscountCard(discount, product) {
        let cardTitle;
        if (discount.type === 'absolute') {
            cardTitle = `<b>₱${discount.absolute_discount}</b> Off`;
        } else {
            cardTitle = `${discount.percentage_discount}% Off`;
        }

        const card = document.createElement('div');
        card.classList.add('card', 'mb-2');

        const cardHeader = document.createElement('div');
        cardHeader.classList.add('card-header');
        cardHeader.innerHTML = cardTitle;

        const cardBody = document.createElement('div');
        cardBody.classList.add('card-body', 'd-flex', 'justify-content-between', 'align-items-center');
        cardBody.innerHTML = discount.name;

        const applyButton = document.createElement('button');
        applyButton.setAttribute('type', 'button');
        applyButton.classList.add('btn', @this.discountAssoc[product.id] === discount.id ? 'btn-primary' : 'btn-secondary');
        applyButton.innerHTML = @this.discountAssoc[product.id] === discount.id ? 'Applied' : 'Apply';
        applyButton.addEventListener('click', function(e) {
            @this.applyDiscount(product.id, discount.id);
        });

        cardBody.appendChild(applyButton);

        card.appendChild(cardHeader);
        card.appendChild(cardBody);

        return card;
    }

    function createReceiptModal(items, quantities, transaction, discounts, method) {
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = 'receiptModal';
        modal.setAttribute('tabIndex', '-1')
        modal.setAttribute('aria-labelledby', 'receiptModalLabel');
        modal.setAttribute('aria-hidden', 'true');

        function printReceipt() {
            printJS({
                printable: 'receiptModal',
                type: 'html',
                css: '{{ asset("css/bootstrap.min.css") }}',
                ignoreElements: ['footer'],
            });
        }

        const printBtn = document.createElement('button');
        printBtn.classList.add('btn', 'btn-primary');
        printBtn.onclick = printReceipt;
        printBtn.innerHTML = 'Print';

        const subtotal = items.map(function(item, index) {
            if (discounts[item.id]) {
                if (discounts[item.id].type === 'absolute') {
                    return (item.price - discounts[item.id].absolute_discount) * quantities[index];
                } else {
                    return item.price - (discounts[item.id].percentage_discount / 100) * item.price * quantities[index];
                }
            }

            return (item.price) * quantities[index];
        }).reduce((a, b) => a + b);

        modal.innerHTML = `
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
                            ${generateReceiptContent(items, quantities, discounts)}
                        </tbody>
                    </table>
                    <p class="m-0 text-secondary fw-bold">SUBTOTAL: ₱${subtotal.toFixed(2)}</p>
                    <p class="m-0 text-secondary fw-bold">SALES TAX: ₱${(subtotal * 0.12).toFixed(2)}</p>
                    <p class="m-0 text-secondary fw-bold">TOTAL: ₱${(subtotal + subtotal * 0.12).toFixed(2)}</p>
                </div>
                <div class="modal-footer">
                    <h2 class="me-auto m-0">Thank You!</h2>
                    <p class="modal-title text-muted me-auto m-0" style="font-size: 12px">Transaction ID: ${transaction.id}</p>
                    <p class="modal-title text-muted me-auto m-0" style="font-size: 12px">Date: ${transaction.created_at}</p>
                    <p class="modal-title text-muted me-auto m-0 w-100" style="font-size: 12px">Payment Method: ${method.method_name}</p>
                </div>
                <div id="footer" class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    `;

        modal.querySelector('#footer').appendChild(printBtn);

        return modal;
    }

    function generateReceiptContent(items, quantities, discounts) {
        // Calculate total amount
        let totalAmount = 0;
        const receiptItems = items.map((item, index) => {
            const discount = discounts[item.id];

            const quantity = quantities[index];

            let amount = quantity * item.price;

            if (!discount) {
                amount = quantity * item.price;
            } else if (discount.type === 'absolute') {
                amount = amount - discount.absolute_discount * quantity;
            } else {
                amount = amount - (discount.percentage_discount / 100) * amount * quantity;
            }

            totalAmount += amount;

            if (!discount) {
                return `
<tr>
    <td>${item.product_name}</td>
    <td><b>x</b>${quantity}</td>
    <td>₱${item.price}</td>
    <td>₱${amount.toFixed(2)}</td>
</tr>
`;
            }

            if (discount.type === 'absolute') {
                return `
<tr>
    <td>${item.product_name}</td>
    <td><b>x</b>${quantity}</td>
    <td>₱${item.price - discount.absolute_discount}</td>
    <td>₱${amount.toFixed(2)}</td>
</tr>
`;
            } else {
                return `
<tr>
    <td>${item.product_name}</td>
    <td><b>x</b>${quantity}</td>
    <td>₱${item.price - (discount.percentage_discount / 100) * item.price}</td>
    <td>₱${amount.toFixed(2)}</td>
</tr>
`;
            }

        });

        return receiptItems.join('\n');
    }
</script>
@endscript
