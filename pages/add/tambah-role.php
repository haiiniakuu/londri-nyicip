<?php

$id = isset($_GET['edit']) ? $_GET['edit'] : '';
$query = mysqli_query($config, "SELECT * FROM levels WHERE id ='$id'");
$rowEdit = mysqli_fetch_assoc($query);

$queryMenus = mysqli_query($config, "SELECT * FROM menus ORDER BY id DESC");
$rowMenu = mysqli_fetch_all($queryMenus, MYSQLI_ASSOC);

$select_id = $rowEdit['id'];
$selectedMenu = mysqli_query($config, "SELECT * FROM role_menus WHERE id_level='$select_id' ");
$rowMenus = mysqli_fetch_all($selectedMenu, MYSQLI_ASSOC);
$selectedMenuId = [];
foreach ($rowMenus as $selectedMenuIds){
    $selectedMenuId[] = $selectedMenuIds['id_menu'];
}

if (isset($_POST['simpan'])) {
    $level_id = $_POST['id_level'];
    $menu_id = $_POST['id_menu'];

    mysqli_query($config, "DELETE FROM role_menus WHERE id_level = '$level_id'");
    foreach ($menu_id as $key => $menu) {
        $insert = mysqli_query($config, "INSERT INTO role_menus (id_menu, id_level) VALUES ('$menu', '$level_id') ");
    }

    header("location:?page=app/level&tambah=success");
}
?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">
                    <?php echo isset($_GET['edit']) ? 'Edit' : 'Add' ?>
                </h3>

                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="" class="form-label">Level Name</label>
                        <input class="form-control" type="text" readonly placeholder="" required value="<?php echo $rowEdit['level_name'] ?? '' ?>">
                        <input type="hidden" name="id_level" value="<?php echo $rowEdit['id'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <?php foreach ($rowMenu as $menu): ?>
                            <label for="" class="form-label">
                                <input type="checkbox" name="id_menu[]" id="" value="<?php echo $menu['id'] ?>" 
                                <?php echo in_array($menu['id'], $selectedMenuId) ? 'checked' : '' ?>> <?php echo $menu['name'] ?>
                            </label>
                        <?php endforeach ?>
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary" type="submit" name="simpan">Simpan
                        </button>
                        <a href="?page=app/level" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>