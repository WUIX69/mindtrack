<?php
global $activeLink;

$navbarTitle = '';
switch ($activeLink) {
    case 'index':
    case '':
        $navbarTitle = 'dashboard';
        break;
    case 'users':
        $navbarTitle = 'users';
        break;
    case 'appointments':
        $navbarTitle = 'appointments';
        break;
    case 'services':
        $navbarTitle = 'services';
        break;
    case 'products':
        $navbarTitle = 'products';
        break;
    case 'analytics':
        $navbarTitle = 'analytics';
        break;
    case 'settings':
        $navbarTitle = 'settings';
        break;
    default:
        $navbarTitle = 'unknown';
        break;
}
$navbarTitle = $navbarTitle != 'dashboard' ? $navbarTitle . ' Management' : $navbarTitle;
?>
<nav class="navbar">
    <div class="container">
        <h1 class="text-capitalize"><?= $navbarTitle ?></h1>

        <!-- Nav -->
        <div class="nav">
            <div class="dark-mode-toggle">
                <span class="material-icons-sharp light active">
                    light_mode
                </span>
                <span class="material-icons-sharp dark">
                    dark_mode
                </span>
            </div>
            <div class="profile">
                <div class="info">
                    <span>Hey, <b>Jordan</b></span>
                    <small class="text-muted">Admin</small>
                </div>
                <div class="profile-photo">
                    <img class="rounded-circle" width="37" src="<?= asset('img/profiles/user-1.jpg'); ?>" />
                </div>
            </div>
        </div>
        <!-- End of Nav -->
    </div>
</nav>