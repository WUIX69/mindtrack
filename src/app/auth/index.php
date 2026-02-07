<?php
$pageTitle = "MindTrack - Sign In";
$showNavbar = false;
$showFooter = false;

// Custom head content for the specific background style
$headContent = <<<'HTML'
<style>
.bg-medical-office {
    background-image: linear-gradient(rgba(17, 18, 33, 0.4), rgba(71, 82, 235, 0.2)), url(https://lh3.googleusercontent.com/aida-public/AB6AXuD_8MnBWkCdvf7QGAdj_gnfOKNauQ5VRDzkU_gFCQur1SVQFDVGlnhwW1sCfAxLsQbgTqXRnqOuV-DSQN3V1O31Amut_ApyCiMrAy0V0mYK6kixEeHBpQUqx3vrO_jV2fUoGwaEHb4-Io-0v3sMUaYK2AEth4kv47FQv0xwoW0qSzPLqbRvnkOa4DDGvAxSb4m3EU0OKdoSDmJbJWDnx9KUgd3r79DkGrl-NDPF2eOis_JFmuzFRgeECoffbsj5pr5meYJIJDnQghU);
    background-size: cover;
    background-position: center;
}
</style>
HTML;

include __DIR__ . '/../layout.php';
?>

<div class="flex min-h-screen w-full flex-col @container lg:flex-row">
	<!-- Left Side: Hero Image & Quote -->
	<div class="relative hidden lg:flex lg:w-1/2 items-center justify-center p-12 bg-medical-office overflow-hidden"
		data-alt="Calm medical office interior with soft lighting">
		<div class="absolute inset-0 bg-primary/20 backdrop-blur-[2px]"></div>
		<div class="relative z-10 max-w-lg text-center">
			<div class="mb-8 flex justify-center">
				<div class="flex items-center gap-2 text-white">
					<span class="material-symbols-outlined text-4xl">psychology</span>
					<span class="text-2xl font-black tracking-tight">MindTrack</span>
				</div>
			</div>
			<h1 class="text-white text-4xl font-bold leading-tight tracking-tight lg:text-5xl">
				"Your mental health is a priority. Your happiness is an essential. Your self-care is a necessity."
			</h1>
			<div class="mt-8 h-1 w-20 bg-white/40 mx-auto rounded-full"></div>
		</div>
	</div>
	<!-- Right Side: Sign-In Form -->
	<div class="flex flex-1 flex-col items-center justify-center bg-base-100 px-6 py-12 lg:px-20">
		<div class="w-full max-w-md">
			<!-- Mobile Header -->
			<div class="mb-10 lg:hidden flex items-center gap-2 text-primary">
				<span class="material-symbols-outlined text-3xl">psychology</span>
				<span class="text-xl font-black tracking-tight">MindTrack</span>
			</div>
			<div class="flex flex-col gap-2 mb-10">
				<h2 class="text-3xl font-bold text-base-content">Welcome Back</h2>
				<p class="text-base-content/70">Enter your credentials to access your patient portal.</p>
			</div>
			<!-- Form Section -->
			<form class="flex flex-col gap-6" onsubmit="return false;">
				<div class="form-control w-full gap-2">
					<label class="label p-0">
						<span class="label-text font-semibold text-base-content/80">Email Address</span>
					</label>
					<input type="email" placeholder="name@example.com"
						class="input input-bordered w-full h-12 focus:input-primary" />
				</div>
				<div class="form-control w-full gap-2">
					<label class="label p-0">
						<span class="label-text font-semibold text-base-content/80">Password</span>
					</label>
					<div class="relative flex items-center">
						<input type="password" placeholder="••••••••"
							class="input input-bordered w-full h-12 focus:input-primary" />
						<button class="absolute right-3 text-base-content/40 hover:text-base-content/70" type="button">
							<span class="material-symbols-outlined text-xl">visibility</span>
						</button>
					</div>
				</div>
				<div class="flex items-center justify-between">
					<label class="flex items-center gap-2 cursor-pointer group">
						<input type="checkbox" class="checkbox checkbox-primary checkbox-sm" />
						<span
							class="text-sm text-base-content/70 group-hover:text-base-content transition-colors">Remember
							Me</span>
					</label>
					<a class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors"
						href="#">Forgot
						Password?</a>
				</div>
				<button class="btn btn-primary w-full h-12 text-white font-bold shadow-lg shadow-primary/20">
					Sign In
				</button>
			</form>
			<!-- Divider -->
			<div class="divider my-10 text-sm text-base-content/50">Or sign in with</div>

			<!-- Social Logins -->
			<div class="grid grid-cols-2 gap-4 mb-10">
				<button
					class="btn btn-outline border-base-content/10 hover:bg-base-200 gap-2 h-12 font-semibold text-base-content">
					<svg class="w-5 h-5" viewbox="0 0 24 24">
						<path
							d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
							fill="#4285F4"></path>
						<path
							d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
							fill="#34A853"></path>
						<path
							d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
							fill="#FBBC05"></path>
						<path
							d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 12-4.53z"
							fill="#EA4335"></path>
					</svg>
					<span class="text-sm">Google</span>
				</button>
				<button
					class="btn btn-outline border-base-content/10 hover:bg-base-200 gap-2 h-12 font-semibold text-base-content">
					<svg class="w-5 h-5 fill-current text-current" viewbox="0 0 24 24">
						<path
							d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701z">
						</path>
					</svg>
					<span class="text-sm">Apple</span>
				</button>
			</div>
			<!-- Footer Text -->
			<p class="text-center text-sm text-base-content/70">
				Don't have an account?
				<a class="font-bold text-primary hover:underline" href="signup.php">Sign Up</a>
			</p>
		</div>
		<!-- Accessibility/Legal Footer -->
		<footer class="mt-auto pt-10 flex gap-6 text-xs text-base-content/40">
			<a class="hover:text-base-content/70" href="#">Privacy Policy</a>
			<a class="hover:text-base-content/70" href="#">Terms of Service</a>
			<a class="hover:text-base-content/70" href="#">Contact Support</a>
		</footer>
	</div>
</div>