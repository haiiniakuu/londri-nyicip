<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM menus WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $link = $_POST['link'];
    $order = $_POST['order'];

    $update = mysqli_query($config, "UPDATE menus SET name= '$name', icon= '$icon', link= '$link', `order`= '$order' WHERE id = '$id'");
    header("location:?page=app/menu&&ubah=berhasil");
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $icon = $_POST['icon'];
    $link = $_POST['link'];
    $order = $_POST['order'];

    $query = mysqli_query($config, "INSERT INTO menus (name, icon, link, `order`) Values ('$name', '$icon','$link','$order')");
    header("location:?page=app/menu");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> Menu
                </h3>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" placeholder="Enter your name" required value="<?php echo $rowEdit['name'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Icon</label>
                        <input class="form-control" type="text" name="icon" placeholder="Enter your icon" required value="<?php echo $rowEdit['icon'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Link</label>
                        <input class="form-control" type="text" name="link" placeholder="Enter your link" required value="<?php echo $rowEdit['link'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Order</label>
                        <input class="form-control" type="text" name="order" placeholder="Enter your order" required value="<?php echo $rowEdit['order'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=app/menu" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>