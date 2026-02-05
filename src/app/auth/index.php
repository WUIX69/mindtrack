<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?= shared('elements/meta') ?> <!-- rcs Meta Tags -->
	<title>VetSync - Sign In</title>
	<?= shared('elements/styles'); ?> <!-- rcs Styles -->
</head>

<body>

	<div class="shared-standalone-content">
		<?= shared('layouts/loader/window') ?> <!-- Window Spinner -->
	</div>

	<div class="container-body">
		<main class="container-main">
			<section class="auth-section">
				<?= partial('components/header-logo') ?> <!-- Header -->
				<div class="auth-wrapper box column">
					<?= partial('components/header-in') ?> <!-- Section in header -->
					<form class="ui large form" id="loginForm">
						<div class="field">
							<label for="email">Email</label>
							<div class="ui input">
								<input type="text" name="email" placeholder="E-mail address">
							</div>
						</div>
						<div class="field">
							<label for="password">Password</label>
							<div class="ui input">
								<input type="password" name="password" placeholder="Password">
							</div>
						</div>
						<div class="field clearing">
							<div class="ui checkbox remember-me">
								<input type="checkbox" name="remember">
								<label for="remember">Remember me</label>
							</div>
							<div class="ui text forgot-password">
								<a href="#">Forgot Password?</a>
							</div>
						</div>
						<div class="actions">
							<?= partial('components/ui/continue-btn'); ?>
						</div>
						<div class="ui error message"></div>
					</form>
					<div class="ui text text-center">
						Don't have an account? <a href="register.php">Sign Up</a>
					</div>
				</div>
				<?= partial('components/terms-privacy') ?> <!-- Terms & Privacy -->
			</section>
		</main>
	</div>

	<!-- Scripts -->
	<?= shared('elements/scripts'); ?> <!-- rcs Scripts -->
	<script src="<?= featured('auth/js/login.js', true) ?>"></script>
</body>

</html>