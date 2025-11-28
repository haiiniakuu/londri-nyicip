<?php
include '../config/config.php';

$queryServices = mysqli_query($config, "SELECT * FROM services");
$rowServices = mysqli_fetch_all($queryServices, MYSQLI_ASSOC);

$queryCustomers = mysqli_query($config, "SELECT * FROM customers");
$rowCustomers = mysqli_fetch_all($queryCustomers, MYSQLI_ASSOC);

$queryTax = mysqli_query($config, "SELECT * FROM taxs WHERE is_active = 1 ORDER BY id DESC LIMIT 1");
$rowTax = mysqli_fetch_assoc($queryTax);
//query product
// $queryProducts = mysqli_query($config, "SELECT s.name, p.* FROM products p LEFT JOIN categories c ON c.id = p.category_id");
// $fetchProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);

if (isset($_GET['payment'])) {

    mysqli_begin_transaction($config);
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data["Cart"];
    // $total = array_reduce($cart, function ($sum, $item) {
    //     return $sum + ($item['price'] * $item['qty']);
    // }, 0);

    $orderCode = $data['order_code'];
    $orderEndDate = $data['end_date'];
    $orderStatus = 0;
    $orderPay = $data['pay'];
    $orderChange = $data['change'];
    $tax = $data['tax'];
    $orderTotal = 0;
    $orderAmounth = $data['grandTotal'];
    $customer_id = $data['customer_id'];

    $subtotal = $data['subtotal'];

    try {
        // code...
        $insertOrder = mysqli_query($config, "INSERT INTO trans_order(order_code, order_end_date, order_status, pay, `change`, tax, order_total, id_customer) 
        VALUES ('$orderCode', '$orderEndDate', '$orderStatus', '$orderPay', '$orderChange', '$tax', '$orderAmounth', '$customer_id') ");

        if (!$insertOrder) {
            throw new Exception("insert failled to table orders", mysqli_error($config));
        }

        // $insertOrder = mysqli_query($config, "INSERT INTO trans_order(order_code, order_end_date, order_status, opay, order_change, order_tax, order_total, id_customer) 
        // VALUES ('$orderCode', '$orderEndDate', $orderStatus, $orderPay, $orderChange, $tax, $orderAmounth, $customer_id)");

        // if (!$insertOrder) {
        //     throw new Exception("insert failled to table orders", mysqli_error($config));
        // }


        $idOrder = mysqli_insert_id($config);
        foreach ($cart as $v) {
            $product_id = $v['id'];
            $qty = $v['qty'];
            $order_price = $v['price'];
            $subtotal = $qty * $order_price;

            $insertOrderDetails = mysqli_query($config, "INSERT INTO trans_order_details(id_order, id_service, qty, price,subtotal) 
            VALUES ('$idOrder','$product_id', '$qty', '$order_price', '$subtotal')");
            if (!$insertOrderDetails) {
                throw new Exception("insert failled to table orders", mysqli_error($config));
            }
        }
        mysqli_commit($config);
        $response = [
            'status' => 'success',
            'message' => 'Transaction success',
            'id_order' => $idOrder,
            'order_code' => $orderCode
        ];
        echo json_encode($response);
    } catch (\Throwable $th) {
        mysqli_rollback($config);
        $response = ['status' => 'Error', 'message' => $th->getMessage()];
        echo json_encode($response);
        die;

        // throw $th;
    }



    // header("location:?page=pos");
    // exit;
    return;
}

$orderNumbers = mysqli_query($config, "SELECT id FROM trans_order ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($orderNumbers);

$nextId = $row ? $row['id'] + 1 : 1;


$order_code = "ORD-" . DATE('dmY') . str_pad($nextId, 4, "0", STR_PAD_LEFT);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Point Of Sale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/rorr.css">

</head>

<body>
    <div class="container-fluid container-pos">
        <div class="row h-100">
            <div class="col-md-8 product-section">
                <div class="card shadow-sm mb-3">
                    <div class="card-header text-center">
                        <b>Customer</b>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="" class="form-label">Customer Name</label>
                                <select name="id_customer" id="id_customer" class="form-control" onchange="selectCustomer()">
                                    <option>--Select One--</option>
                                    <?php foreach ($rowCustomers as $customer):  ?>
                                        <option value="<?php echo $customer['id'] ?>" data-phone="<?php echo $customer['phone'] ?>"><?php echo $customer['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" placeholder="Phone Number" id="phone" readonly>
                            </div>

                            <div class="col-md-6">
                                <label for="" class="form-label">End Date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-3">
                    <div class="card-header text-center">
                        <b>Laundry Service</b>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <?php foreach ($rowServices as $service) :  ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card service-card p-2" onclick="openModal(<?php echo htmlspecialchars(json_encode($service)) ?>)">
                                        <h6><?php echo $service['name'] ?></h6>
                                        <small class="text-muted">Rp. <?php echo number_format($service['price'])  ?>/kg</small>
                                    </div>
                                </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>

                <!-- Button trigger modal -->
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Launch demo modal
                </button> -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="modal_id">
                                <input type="hidden" id="modal_price">
                                <input type="hidden" id="modal_type">

                                <div class="mb-3">
                                    <label for="" form-label>Service Name</label>
                                    <input type="text" name="modal_name" class="form-control" id="modal_name" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="" form-label>Weight / Qty</label>
                                    <input type="number" name="modal_qty" placeholder="Weight / Qty" class="form-control" id="modal_qty" step="0.1" min="0">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 cart-section">
                <div class="cart-header mt-3" style="border-radius: 10px;">
                    <h4>Cart</h4>
                    <small>Order # <span class="orderNumber"><?php echo $order_code ?></span></small>
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
                            <span>Tax (<?php echo $rowTax['percent'] ?>%)</span>
                            <span id="tax">Rp. 0.0</span>
                            <input type="hidden" id="tax_value">
                            <input type="hidden" class="tax" value="<?php echo $rowTax['percent'] ?>">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Grandtotal</span>
                            <span id="total">Rp. 0.0</span>
                            <input type="hidden" id="total_value">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pay</span>
                            <input type="number" id="pay" placeholder="Enter the payment amount" class="form-control w-50" oninput="calculateChange()">
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Change</span>
                            <input type="number" id="change" class="form-control w-50" readonly>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <button class="btn btn-clear-cart btn-outline-danger w-100" id="clearCart"><i class="bi bi-trash"> Clear Cart</i></button>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script src="../assets//js/rorr.js"></script>

</body>

</html>