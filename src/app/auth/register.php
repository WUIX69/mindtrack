<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta') ?> <!-- rcs Meta Tags -->
    <title>Mindtrack - Sign Up</title>
    <?= shared('elements/styles'); ?> <!-- rcs Styles -->
</head>

<body>

    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window') ?> <!-- Window Spinner -->
    </div>

    <div class="container-body">
        <main class="container-main">
            <section class="auth-section mt-0">
                <?= partial('header-logo') ?> <!-- Header Logo -->
                <div class="auth-wrapper box column">
                    <?= partial('header-in') ?> <!-- Section in header -->
                    <form class="ui large form" id="registerForm">
                        <div class="two fields">
                            <div class="field">
                                <label for="firstname">First name</label>
                                <div class="ui input">
                                    <input type="text" name="firstname" placeholder="First Name">
                                </div>
                            </div>
                            <div class="field">
                                <label for="lastname">Last name</label>
                                <div class="ui input">
                                    <input type="text" name="lastname" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <label for="email">E-mail address</label>
                            <div class="ui input">
                                <input type="email" name="email" placeholder="E-mail address">
                            </div>
                        </div>
                        <div class="field">
                            <label for="password">Password</label>
                            <div class="ui input">
                                <input type="password" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="field">
                            <label for="confirm_password">Confirm Password</label>
                            <div class="ui input">
                                <input type="password" name="confirm_password" placeholder="Confirm Password">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui checkbox terms">
                                <input type="checkbox" name="terms">
                                <label for="terms">I agree to the Terms and Conditions</label>
                            </div>
                        </div>
                        <div class="actions">
                            <?= partial('ui/continue-btn'); ?>
                        </div>
                        <div class="ui error message"></div>
                    </form>
                    <div class="ui text text-center">
                        Already have an account? <a href="index.php">Login</a>
                    </div>
                </div>
                <?= partial('terms-privacy') ?> <!-- Terms & Privacy -->
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <?= shared('elements/scripts'); ?> <!-- rcs Scripts -->
    <script src="<?= featured('auth/js/register.js', true) ?>"></script>
</body>

</html>