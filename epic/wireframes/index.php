<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Wireframes</title>
		<!--Include Bootstrap Head Tags -->
		<?php require_once(dirname(__DIR__) . "/../lib/head-utils.php"); ?>
		<link rel="stylesheet" href="../../css/epicstyles.css">
	</head>
	<body class="footerBody">
		<div class="container">
			<main class="footerMain">
				<!-- NAV BAR -->
				<div class="row">
					<div class="col-md-6">
						<ul class="nav nav-tabs">
							<li role="presentation"><a href="../index.php">Home</a></li>
							<li role="presentation"><a href="../epic-jason.php">Jason</a></li>
							<li role="presentation"><a href="../epic-dana.php">Dana</a></li>
							<li role="presentation"><a href="../epic-jessica.php">Jessica</a></li>
							<li role="presentation"><a href="../data-design.php">Data Design</a></li>
							<li role="presentation" class="active"><a href="#">Wireframes</a></li>
						</ul>
					</div>
					<div class="col-md-6 text-right">
						<h2>jpegery</h2>
					</div>
				</div>

				<h1 class="page-header">Wireframes</h1>

				<div class="row row-eq-height">
					<div class="col-md-3 personaborder">
						<a href="desktop-home.php"><img src="thumbnail-desktop-home.png" alt="Home page, Desktop" class="img-responsive"></a><br>
						Home Page, Desktop
					</div>
					<div class="col-md-3 personaborder">
						<a href="desktop-image.php"><img src="thumbnail-desktop-image.png" alt="Single Image, Desktop" class="img-responsive"></a><br>
						Single Image, Desktop
					</div>
					<div class="col-md-3 personaborder">
						<a href="desktop-user.php"><img src="thumbnail-desktop-user.png" alt="User Profile, Desktop" class="img-responsive"></a><br>
						User Profile, Desktop
					</div>
					<div class="col-md-3 personaborder">
						<a href="desktop-settings.php"><img src="thumbnail-desktop-settings.png" alt="User Settings, Desktop" class="img-responsive"></a><br>
						User Settings, Desktop
					</div>
				</div>

				<div class="row row-eq-height">
					<div class="col-md-3 personaborder">
						<a href="mobile-home.php"><img src="thumbnail-mobile-home.png" alt="Home page, Mobile" class="img-responsive"></a><br>
						Home Page, Mobile
					</div>
					<div class="col-md-3 personaborder">
						<a href="mobile-image.php"><img src="thumbnail-mobile-image.png" alt="Single Image, Mobile" class="img-responsive"></a><br>
						Single Image, Mobile
					</div>
					<div class="col-md-3 personaborder">
						<a href="mobile-user.php"><img src="thumbnail-mobile-user.png" alt="User Profile, Mobile" class="img-responsive"></a><br>
						User Profile, Mobile
					</div>
					<div class="col-md-3 personaborder">
						<a href="mobile-settings.php"><img src="thumbnail-mobile-settings.png" alt="User Settings, Mobile" class="img-responsive"></a><br>
						User Settings, Mobile
					</div>
				</div>




			</main>

			<footer>
				<div class="col-md-12 footer text-center">
					Copyright © 2016 jpegery
				</div>
			</footer>

		</div>
	</body>
</html>