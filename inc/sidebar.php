<?php
$level_id = $_SESSION['ID_LEVEL'] ?? '';

$queryLevelMenu = mysqli_query($config, "SELECT * FROM menus JOIN role_menus ON menus.id = role_menus.id_menu WHERE id_level ='$level_id' ORDER BY `order` ASC");
$rowLevelMenus = mysqli_fetch_all($queryLevelMenu, MYSQLI_ASSOC);
?>
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php foreach ($rowLevelMenus as $rowLevelMenu): ?>

            <li class="nav-item">
                <a class="nav-link collapsed" href="?page=<?php echo $rowLevelMenu['link'] ?>">
                    <i class="<?php echo $rowLevelMenu['icon'] ?>"></i>
                    <span><?php echo $rowLevelMenu['name'] ?></span>
                </a>
            </li><!-- End Dashboard Nav -->
        <?php endforeach ?>

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=app/users">
                        <i class="bi bi-circle"></i><span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="?page=app/level">
                        <i class="bi bi-circle"></i><span>Levels</span>
                    </a>
                </li>
                <li>
                    <a href="?page=app/customer">
                        <i class="bi bi-circle"></i><span>Customer</span>
                    </a>
                </li>
                <li>
                    <a href="?page=app/service">
                        <i class="bi bi-circle"></i><span>Services</span>
                    </a>
                </li>
                <li>
                    <a href="?page=app/menu">
                        <i class="bi bi-circle"></i><span>Menu</span>
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- End Components Nav -->

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=app/transaction">
                        <i class="bi bi-circle"></i><span>Transaction</span>
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- End Forms Nav -->
    </ul>
</aside>