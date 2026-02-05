<?php
global $activeLink;
$activeLink = uriPagePath();
?>
<aside class="sidebar">
    <div class="sidebar-logo">
        <img class="rounded-circle" src="<?= asset('img/logo.jpg'); ?>">
        <h2>Admin<span class="text-danger">Panel</span></h2>
    </div>
    <div class="sidebar-menu">
        <ul class="nav navbar-nav">
            <li class="nav-item <?= ($activeLink == 'index' || $activeLink == '') ? 'active' : ''; ?>">
                <a class="nav-link" href="index.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">dashboard</span>
                        <h3>Dashboard</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'users' ? 'active' : ''; ?>">
                <a class="nav-link" href="users.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">person_outline</span>
                        <h3>Users</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'appointments' ? 'active' : ''; ?>">
                <a class="nav-link" href="appointments.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">book_outline</span>
                        <h3>Appointments</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'services' ? 'active' : ''; ?>">
                <a class="nav-link" href="services.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">medical_services</span>
                        <h3>Services</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'products' ? 'active' : ''; ?>">
                <a class="nav-link" href="products.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">shopping_cart</span>
                        <h3>Products</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'analytics' ? 'active' : ''; ?>">
                <a class="nav-link" href="analytics.php">
                    <div class="nav-content">
                        <span class="material-icons-sharp">analytics</span>
                        <h3>Analytics</h3>
                    </div>
                </a>
            </li>
            <li class="nav-item <?= $activeLink == 'settings' ? 'active' : ''; ?>">
                <div class="nav-link">
                    <div class="nav-content">
                        <div class="ui accordion">
                            <div class="title">
                                <span class="material-icons-sharp">settings</span>
                                <h3>Settings</h3>
                                <i class="dropdown icon"></i>
                            </div>
                            <div class="content">
                                <div class="transition hidden">
                                    <ul class="menu-nav navbar-nav">
                                        <li class="menu-nav-item">
                                            <a class="menu-nav-link" href="settings.php#profile">
                                                <div class="menu-nav-content">
                                                    <span class="material-icons-sharp">person_outline</span>
                                                    <h3>Profile</h3>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu-nav-item">
                                            <a class="menu-nav-link" href="settings.php#password">
                                                <div class="menu-nav-content">
                                                    <span class="material-icons-sharp">password</span>
                                                    <h3>Password</h3>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu-nav-item">
                                            <a class="menu-nav-link" href="settings.php#urls">
                                                <div class="menu-nav-content">
                                                    <span class="material-icons-sharp">language</span>
                                                    <h3>URLs</h3>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="menu-nav-item">
                                            <a class="menu-nav-link" href="settings.php#deactivate">
                                                <div class="menu-nav-content">
                                                    <span class="material-icons-sharp">person_off</span>
                                                    <h3>Deactivate</h3>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item <?= $activeLink == 'logout' ? 'active' : ''; ?>">
                <a class="nav-link" href="javascript:void(0);">
                    <div class="nav-content">
                        <span class="material-icons-sharp">logout</span>
                        <h3>Logout</h3>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</aside>