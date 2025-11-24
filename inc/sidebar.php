<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="?page=dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=users">
                        <i class="bi bi-circle"></i><span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="?page=level">
                        <i class="bi bi-circle"></i><span>Levels</span>
                    </a>
                </li>
                <li>
                    <a href="?page=customer">
                        <i class="bi bi-circle"></i><span>Customer</span>
                    </a>
                </li>
                <li>
                    <a href="?page=service">
                        <i class="bi bi-circle"></i><span>Services</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-journal-text"></i><span>Transaction</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="?page=transaction">
                        <i class="bi bi-circle"></i><span>Transaction</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->
    </ul>
</aside>