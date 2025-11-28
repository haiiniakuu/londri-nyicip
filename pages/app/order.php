<?php

$orders = mysqli_query($config, "SELECT c.name, `to`.* FROM trans_order `to` LEFT JOIN customers c ON c.id= to.id_customer ORDER BY to.id DESC");
$order = mysqli_fetch_all($orders, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $q_delete = mysqli_query($config, "DELETE FROM trans_order WHERE id = '$id'");
    header("location:?page=app/order&hapus=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Order</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="pos/add-order.php"><i class="bi bi-plus-circle"></i> Add Order</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order Code</th>
                            <th>Order End Date</th>
                            <th>Order Status</th>
                            <th>Order Pay</th>
                            <th>Order Change</th>
                            <th>Order Tax 10%</th>
                            <th>Order Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($order as $key => $or) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $or['order_code'] ?></td>
                                <td><?php echo $or['order_end_date'] ?></td>
                                <td><?php echo $or['order_status'] ?></td>
                                <td>Rp. <?php echo number_format($or['pay'])  ?></td>
                                <td>Rp. <?php echo number_format($or['change'])  ?></td>
                                <td>Rp. <?php echo number_format($or['tax']) ?></td>
                                <td>Rp. <?php echo number_format($or['order_total']) ?></td>
                                <td>
                                    <a class="btn btn-success" href="pos/print.php?id=<?php echo $or['id'] ?>">
                                        <i class="bi bi-pencil">print</i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=app/order&delete=<?php echo $or['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>