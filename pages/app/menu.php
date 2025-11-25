<?php
$query = mysqli_query($config, "SELECT * FROM menus ORDER BY `order` ASC");
$menu = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM  menus WHERE id = '$id'");
    header("location:?page=app/menu&hapus=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Menu</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="?page=add/tambah-menu"><i class="bi bi-plus-circle"></i> Add Menu</a>
                </div>

                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Link</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($menu as $key => $m) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $m['name'] ?></td>
                                <td><?php echo $m['icon'] ?></td>
                                <td><?php echo $m['link'] ?></td>
                                <td><?php echo $m['order'] ?></td>
                                <td>
                                    <a class="btn btn-success" href="?page=add/tambah-menu&edit=<?php echo $m['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=app/menu&delete=<?php echo $m['id'] ?>">
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