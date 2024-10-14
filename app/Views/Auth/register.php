<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets') ?>/img/apple-icon.png">
	<link rel="icon" type="image/png" href="<?= base_url('assets') ?>/img/favicon.png">
	<title><?= $title ?? '' ?> | Register</title>
	<!--     Fonts and icons     -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<!-- Nucleo Icons -->
	<link href="<?= base_url('assets') ?>/css/nucleo-icons.css" rel="stylesheet" />
	<link href="<?= base_url('assets') ?>/css/nucleo-svg.css" rel="stylesheet" />
	<!-- Font Awesome Icons -->
	<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
	<link href="<?= base_url('assets') ?>/css/nucleo-svg.css" rel="stylesheet" />
	<!-- CSS Files -->
	<link id="pagestyle" href="<?= base_url('assets') ?>/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
</head>

<body class="">
	<main class="main-content  mt-0">
		<section>
			<div class="page-header min-vh-100">
				<div class="container">
					<div class="row">
						<div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
							<div class="card card-plain">
								<div class="card-header pb-0 text-start">
									<h4 class="font-weight-bolder">Register</h4>
									<p class="mb-0">Enter your email and password to register</p>
								</div>
								<div class="card-body">
									
									<?= view('App\Views\Auth\_message_block') ?>

									<form action="<?= url_to('register') ?>" method="post">
                                        <?= csrf_field() ?>

                                        <div class="form-group">
                                            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                                                name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?=lang('Auth.username')?>" value="<?= old('username') ?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Register</button>
                                        </div>
                                        <p class="text-sm mt-3 mb-0"><?=lang('Auth.alreadyRegistered')?> <a class="text-dark font-weight-bolder" href="<?= url_to('login') ?>"><?=lang('Auth.signIn')?></a></p>
                                    </form>
								</div>
							</div>
						</div>
						<div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
							<div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-size: cover;">
								<span class="mask bg-gradient-primary opacity-6"></span>
								<h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new currency"</h4>
								<p class="text-white position-relative">The more effortless the writing looks, the more effort the writer actually put into the process.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>
	<!--   Core JS Files   -->
	<script src="<?= base_url('assets') ?>/js/core/popper.min.js"></script>
	<script src="<?= base_url('assets') ?>/js/core/bootstrap.min.js"></script>
	<script src="<?= base_url('assets') ?>/js/plugins/perfect-scrollbar.min.js"></script>
	<script src="<?= base_url('assets') ?>/js/plugins/smooth-scrollbar.min.js"></script>
	<script>
		var win = navigator.platform.indexOf('Win') > -1;
		if (win && document.querySelector('#sidenav-scrollbar')) {
		var options = {
			damping: '0.5'
		}
		Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
		}
	</script>
	<!-- Github buttons -->
	<script async defer src="https://buttons.github.io/buttons.js"></script>
	<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
	<script src="<?= base_url('assets') ?>/js/argon-dashboard.min.js?v=2.0.4"></script>
</body>

</html>