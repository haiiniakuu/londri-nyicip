<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM customers WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update = mysqli_query($config, "UPDATE customers SET name= '$name', phone= '$phone', address= '$address' WHERE id = '$id'");
    header("location:?page=app/customer&&ubah=berhasil");
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $query = mysqli_query($config, "INSERT INTO customers (name, phone, address) Values ('$name', '$phone','$address')");
    header("location:?page=app/customer");
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
                        <input class="form-control" type="text" name="name" placeholder="Enter your name" required value="<?php echo $rowEdit['name'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input class="form-control" type="text" name="phone" placeholder="Enter your phone" required value="<?php echo $rowEdit['phone'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" placeholder="Enter your address" required value="<?php echo $rowEdit['address'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=app/customer" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>