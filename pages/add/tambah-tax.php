<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$query = mysqli_query($config, "SELECT * FROM taxs WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $percent = $_POST['percent'];
    $is_active = $_POST['is_active'];

    $update = mysqli_query($config, "UPDATE taxs SET percent= '$percent', is_active= '$is_active' WHERE id = '$id'");
    header("location:?page=app/tax&&ubah=berhasil");
}

if (isset($_POST['simpan'])) {
    $percent = $_POST['percent'];
    $is_active = $_POST['is_active'];

    $insert = mysqli_query($config, "INSERT INTO taxs (percent, is_active) Values ('$percent', '$is_active')");
    header("location:?page=app/tax");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Tax
                </h3>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Tax</label>
                        <input class="form-control" type="text" name="percent" placeholder="Enter your name" required value="<?php echo $rowEdit['percent'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Is Active</label><br>
                        <input type="radio" name="is_active" <?php echo $rowEdit ? $rowEdit == 0 ? 'checked' : '' : '' ?> value="1" value="0"> Draft 
                        <input type="radio" name="is_active" <?php echo $rowEdit ? $rowEdit == 1 ? 'checked' : '' : '' ?> value="1" > Active
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=app/tax" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>