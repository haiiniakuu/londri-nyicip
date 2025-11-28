<?php
session_start();
include "../config/config.php";

$query = mysqli_query($config, "SELECT * FROM trans_order ORDER BY id DESC");
$row = mysqli_fetch_assoc($query);

$order_id = $row['id'];
$queryDetails = mysqli_query($config, "SELECT s.name AS service_name, od.* FROM trans_order_details od LEFT JOIN services s ON s.id = od.id_service WHERE id_order = '$order_id'");
$rowDetails = mysqli_fetch_all($queryDetails, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran</title>
    <style>
        body {
            width: 80mm;
            font-family: 'Courier New', Courier, monospace;
            margin: 0 auto;
            padding: 10px;
            background-color: white;
        }

        .struck-page {
            width: 100%;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h2 {
            font-size: 20px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        .info {
            margin: 15px 0;
            font-size: 11px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .separator {
            border-top: 1px dashed black;
        }

        .items {
            margin: 10px 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 12px;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            margin: 0 10px;
        }

        .item-price {
            text-align: right;
            min-width: 80px;
        }

        .totals {
            margin-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }

        .total-row.grand {
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0;
        }

        .payment {
            margin-top: 10px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>

<body>
    <div class="struck-page">
        <div class="header">
            <h2>Struk Pembayaran</h2>
            <p>jl benhil karet jakpus</p>
            <p>083343527762</p>
        </div>

        <div class="info">
            <div class="info-row">
                <?php
                $date = date("d-m-Y", strtotime($row['created_at']));
                $time = date("H:i:s", strtotime($row['order_end_date']));
                ?>
                <span><?php echo $date ?></span>
                <span><?php echo $time ?></span>
            </div>
            <div class="info-row">
                <span>Transaction Id</span>
                <span><?php echo $row['order_code'] ?></span>
            </div>
            <div class="info-row">
                <span>Cashier Name:</span>
                <span><?php echo $_SESSION['NAME'] ?></span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="items">
            <?php
            foreach ($rowDetails as $item) {
            ?>
                <div class="item">
                    <span class="item-name"><?php echo $item['service_name'] ?></span>
                    <span class="item-qty"><?php echo number_format($item['qty'], 1) ?></span>
                    <span class="item-price">Rp. <?php echo number_format($item['price']) ?></span>
                </div>
            <?php } ?>
        </div>

        <div class="separator"></div>
        <div class="totals">
            <?php foreach ($rowDetails as $detail): ?>
                <div class="total-row">
                    <span>Sub Total</span>
                    <span>Rp. <?php echo number_format($detail['subtotal']); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="total-row">
                <span>Ppn (Include)</span>
                <span>10%</span>
            </div>
        </div>

        <div class="separator"></div>
        <div class="payment">
            <div class="total-row grand">
                <span>Total</span>
                <span>Rp. <?php echo number_format($row['order_total']) ?></span>
            </div>
            <!-- <div class="total-row">
                <span>Cash</span>
                <span>Rp. 100.000</span>
            </div>
            <div class="total-row">
                <span>Change</span>
                <span>Rp. 50.000</span>
            </div> -->
        </div>

    </div>
</body>

</html>