<?php
$query = mysqli_query($config, "SELECT * FROM customers");
$customer = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM  customers WHERE id = '$id'");
    header("location:?page=app/customer&hapus=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Customer</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="?page=add/tambah-customer"><i class="bi bi-plus-circle"></i> Add Customer</a>
                </div>

                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($customer as $key => $c) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $c['name'] ?></td>
                                <td><?php echo $c['phone'] ?></td>
                                <td><?php echo $c['address'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="?page=add/tambah-customer&edit=<?php echo $c['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=app/customer&delete=<?php echo $c['id'] ?>">
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