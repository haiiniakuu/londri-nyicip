<?php

$query = mysqli_query($config, "SELECT * FROM users u ORDER BY u.id DESC");
$users = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete =  mysqli_query($config, "DELETE FROM users WHERE id = $id ");
    header("location:?page=users&&hapus=berhasil");
}

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Data User</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="?page=tambah-users"><i class="bi bi-plus-circle"></i> Add User</a>
                    <a class="btn btn-warning" href="?page=restore-users"><i class="bi bi-plus-circle"></i> Restore User</a>
                </div>

                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name </th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $key => $value) { ?>

                            <tr>
                                <td><?php echo $key += 1 ?></td>
                                <td><?php echo $value['name'] ?></td>
                                <td><?php echo $value['email'] ?></td>  
                                <td>
                                    <a class="btn btn-success" href="?page=tambah-users&&edit=<?php echo $value['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=users&&delete=<?php echo $value['id'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>