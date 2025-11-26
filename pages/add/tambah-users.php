<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$queryEdit = mysqli_query($config, "SELECT * FROM users WHERE id='$id'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

$queryLevels = mysqli_query($config, "SELECT * FROM levels ORDER BY id DESC");
$rowLevels =  mysqli_fetch_all($queryLevels, MYSQLI_ASSOC);

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $id_level = $_POST['id_level'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if ($password) {
        $query = mysqli_query($config, "UPDATE users SET name= '$name', id_level= '$id_level', email= '$email', password= '$password' WHERE id='$id'");
    } else {
        $query = mysqli_query($config, "UPDATE users SET name= '$name', id_level= '$id_level', email= '$email' WHERE id='$id'");
    }

    if ($query) {
        header("location:?page=app/users&&ubah=berhasil");
    }
}

if (isset($_POST['simpan'])) {
    $name = $_POST['name'];
    $id_level = $_POST['id_level'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $query = mysqli_query($config, "INSERT INTO users(name, email, id_level, password) Values ('$name', '$email', '$id_level', '$password')");

    if ($query) {
        header("location:?page=app/users&&tambah=berhasil");
    }
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

                    <div class="mb-3">
                        <label for="" class="form-label">Level Name</label>
                        <select name="id_level" id="" class="form-control">
                            <option value="">Choose One</option>
                            <?php foreach ($rowLevels as $rl): ?>
                                <option <?php echo $rl['id'] ? 'selected' : '' ?> value="<?php echo $rl['id'] ?>"><?php echo $rl['level_name'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Email</label>
                        <input class="form-control" type="text" name="email" placeholder="Enter your email" required value="<?php echo $rowEdit['email'] ?? '' ?>">
                    </div>

                    <div class=" mb-3">
                        <label for="" class="form-label">Password <small>kosongkan jika ingin mengubah</small></label>
                        <input class="form-control" type="password" name="password" placeholder="Enter your password">
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="<?php echo ($id) ? 'update' : 'simpan' ?>">
                            <?php echo ($id) ? 'simpan perubahan' : 'simpan' ?>
                        </button>
                        <a href="?page=app/users" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>