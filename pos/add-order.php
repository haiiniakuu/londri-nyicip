<?php
include '../config/config.php';

$queryCats = mysqli_query($config, "SELECT * FROM services");
$fetchCats = mysqli_fetch_all($queryCats, MYSQLI_ASSOC);

//query product
// $queryProducts = mysqli_query($config, "SELECT s.name, p.* FROM products p LEFT JOIN categories c ON c.id = p.category_id");
// $fetchProducts = mysqli_fetch_all($queryProducts, MYSQLI_ASSOC);

if (isset($_GET['payment'])) {

    mysqli_begin_transaction($config);
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data["Cart"];
    $total = array_reduce($cart, function ($sum, $item) {
        return $sum + ($item['product_price'] * $item['quantity']);
    }, 0);
    $tax = $data['tax'];

    $orderCode = $data['order_code'];
    $orderDate = date("Y-m-d H:i:s");
    $orderAmount = $data['grandTotal'];
    $orderChange = 0;
    $orderStatus = 1;
    $subtotal = $data['subtotal'];

    try {
        //code...
        $insertOrder = mysqli_query($config, "INSERT INTO trans_order(order_code, order_date, order_amount, order_subtotal, order_status) VALUES ('$orderCode', '$orderDate', '$orderAmount', '$subtotal', '$orderStatus') ");

        if (!$insertOrder) {
            throw new Exception("insert failled to table orders", mysqli_error($config));
        }

        $idOrder = mysqli_insert_id($config);
        foreach ($cart as $v) {
            $product_id = $v['id'];
            $qty = $v['quantity'];
            $order_price = $v['product_price'];
            $subtotal = $qty * $order_price;

            $insertOrderDetails = mysqli_query($config, "INSERT INTO order_details(order_id, product_id, qty, order_price,order_subtotal) VALUES ('$idOrder','$product_id', '$qty', '$order_price ', '$subtotal')");
            if (!$insertOrderDetails) {
                throw new Exception("insert failled to table orders", mysqli_error($config));
            }
        }
        mysqli_commit($config);
        $response = [
            'status' => 'success',
            'message' => 'Transaction success',
            'order_id' => $idOrder,
            'order_code' => $orderCode
        ];
        echo json_encode($response,);
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

$orderNumbers = mysqli_query($config, "SELECT id FROM services ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($orderNumbers);

$nextId = $row ? $row['id'] + 1 : 1;


$order_code = "ORD-" . DATE('dmY') . str_pad($nextId, 4, "0", STR_PAD_RIGHT);


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
    <link rel="stylesheet" href="../assets/css/rorr.css">

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
                    <?php foreach ($fetchCats as $ord) { ?>
                        <button class="btn btn-outline-primary category-btn" onclick="filterCategory('<?php echo $ord['name'] ?>', this)"><?php echo $ord['name'] ?></button>
                    <?php } ?>
                </div>

                <div class="row" id="productGrid">

                </div>
            </div>

            <div class="col-md-4 cart-section">
                <div class="cart-header">
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
                            <input type="hid   den" id="subtotal_value">
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

    <script>
        const products = <?php echo json_encode(($fetchProducts)); ?>
    </script>

    <script src="../assets//js/rorr.js"></script>

</body>

</html>