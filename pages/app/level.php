<?php

$query = mysqli_query($config, "SELECT * FROM levels");
$levels = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM levels WHERE id = $id");
    header("location:?page=app/level&hapus=berhasil");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Levels</h3>
                <div class="mb-3" align="right">
                    <a class="btn btn-primary" href="?page=add/tambah-level"><i class="bi bi-plus-circle"></i> Add Level</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Level Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($levels as $key => $lvl) {
                        ?>
                            <tr>
                                <td><?php echo $key + 1 ?></td>
                                <td><?php echo $lvl['level_name'] ?></td>
                                <td>
                                    <a class="btn btn-warning" href="?page=add/tambah-role&edit=<?php echo $lvl['id'] ?>">
                                        <i class="bi bi-plus-circle"></i>
                                    </a>
                                    <a class="btn btn-success" href="?page=add/tambah-level&edit=<?php echo $lvl['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="?page=app/level&&delete=<?php echo $lvl['id'] ?>">
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