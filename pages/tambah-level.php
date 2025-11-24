<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM levels WHERE id ='$id'");
$level = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['simpan'])) {
    $level_name = $_POST['level_name'];
    
    $insert = mysqli_query($config, "INSERT INTO levels (level_name) VALUES ('$level_name')");
    header("location:?page=level");
}



if (isset($_POST['update'])) {
    $level_name = $_POST['level_name'];
    $update = mysqli_query($config, "UPDATE levels SET level_name = '$level_name' WHERE id = '$id'");
    header("location:?page=level");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Levels
                </h3>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Levels</label>
                        <input class="form-control" type="text" name="level_name" placeholder="" required value="<?php echo $level['level_name'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=level" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>