<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM services WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $update = mysqli_query($config, "UPDATE services SET name= '$name', price= '$price', description= '$description' WHERE id = '$id'");
    header("location:?page=app/service&&ubah=berhasil");
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $query = mysqli_query($config, "INSERT INTO services (name, price, description) Values ('$name', '$price','$description')");
    header("location:?page=app/service");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?> User
                </h3>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" required value="<?php echo $rowEdit['name'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Price</label>
                        <input class="form-control" type="text" name="price" required value="<?php echo $rowEdit['price'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Description</label>
                        <input class="form-control" type="text" name="description" required value="<?php echo $rowEdit['description'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=app/service" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>