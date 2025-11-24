<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/rorr.css">
    <meta name="csrf-token" content="csrf_token()">

</head>

<body>
    <div class="container-fluid container-pos">
        <div class="row h-100">
            <div class="col-md-8 product-section">
                <div class="mb-4">
                    <h4 class="mb-3" id="product-title"><i class="fas fa-store"></i>Product </h4>
                    <input type="text" id="searchProduct" class="form-control search-box" placeholder="Find Product">
                </div>
                <div class="mb-4">
                    <button class="btn btn-primary category-btn active" onclick="filterCategory('all',this)">All/Menu</button>
                </div>

                <div class="row" id="productGrid">

                </div>
            </div>

            <div class="col-md-4 cart-section">
                <div class="cart-header">
                    <h4>Cart</h4>
                    <small>Order # <span class="orderNumber"> {{ $order_code ?? '' }} </span></small>
                </div>
                <div class="cart-items" id="cartItems">
                    <div class="text-center textmuted mt-5">
                        <i class="bi bi-cart mb-3"></i>
                        <p>Cart Empty</p>
                    </div>
                </div>

                <div class="cart-footer">
                    <div class="total-section">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp. 0.0</span>
                            <input type="hidden" id="subtotal_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak (10%)</span>
                            <span id="tax">Rp. 0.0</span>
                            <input type="hidden" id="tax_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Grandtotal</span>
                            <span id="total">Rp. 0.0</span>
                            <input type="hidden" id="total_value">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <button class="btn btn-outline-danger w-100" id="clearCart"><i class="bi bi-trash"> Clear Cart</i></button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-checkout btn-primary w-100" onclick="processPayment()"><i class="bi bi-cash"> Payment</i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="card">
        <!-- <h3>Nama Product</h3>
        <p>description product</p> -->
    </div>

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control">
                            <option value="">--Select One--</option>
                            <option value="cash">Cash</option>
                            <option value="cashless">Cashless</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-process" onclick="handlePayment()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script
        type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <script src="{{ asset('assets/js/rorr.js') }}"></script>

</body>

</html>