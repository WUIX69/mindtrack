<?php
global $activeLink;
$activeLink = uriPagePath();
?>
<header class="site-header">
    <nav class="navbar">
        <div class="navbar-container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="logo-cont">
                        <a href="<?= app('landing') ?>" class="navbar-logo">
                            <!-- <img src="<?= asset('img/logo.png'); ?>" alt="Logo"> -->
                            <div class="logo-text">
                                <h3 class="logo-text-main">VET<span class="ui teal text">SYNC</span></h3>
                            </div>
                        </a>
                        <button class="mobile-menu-btn"><!-- For mobile view support (Hamburger) -->
                            <span class="material-icons-sharp">menu</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="nav-links">
                        <a href="<?= app('landing') ?>"
                            class="nav-link <?= ($activeLink === 'index' || $activeLink === '') ? 'active' : '' ?>">Home</a>
                        <a href="<?= app('landing/services') ?>"
                            class="nav-link <?= ($activeLink === 'services' || $activeLink === 'service-single-view') ? 'active' : '' ?>">Services</a>
                        <a href="<?= app('landing/products') ?>"
                            class="nav-link <?= ($activeLink === 'products' || $activeLink === 'product-single-view') ? 'active' : '' ?>">Products</a>
                        <a href="<?= app('landing/contact') ?>"
                            class="nav-link <?= $activeLink === 'contact' ? 'active' : '' ?>">Contact
                            Us</a>
                        <a href="<?= app('landing/about') ?>"
                            class="nav-link <?= $activeLink === 'about' ? 'active' : '' ?>">About
                            Us</a>
                        <a href="<?= app('auth') ?>" class="nav-link ">Login</a>
                        <div class="actions d-none"><!-- Only show for mobile view -->
                            <?= partial('ui/booknow-btn') ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="actions">
                        <?= partial('ui/booknow-btn') ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>