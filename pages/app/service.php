<?php
$query = mysqli_query($config, "SELECT * FROM services");
$service = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM  services WHERE id = '$id'");
    header("location:?page=app/service&hapus=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Services</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="?page=add/tambah-service"><i class="bi bi-plus-circle"></i> Add Services</a>
                </div>

                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Service Name</th>
                            <th>Price </th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($service as $key => $s) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $s['name'] ?></td>
                                <td>Rp. <?php echo number_format($s['price']) ?></td>
                                <td><?php echo $s['description'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="?page=add/tambah-service&edit=<?php echo $s['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=app/service&delete=<?php echo $s['id'] ?>">
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