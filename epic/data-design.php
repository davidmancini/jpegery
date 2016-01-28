<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Data Design</title>
		<!--Include Bootstrap Head Tags -->
		<?php require_once(dirname(__DIR__) . "/lib/head-tags.html"); ?>
		<link rel="stylesheet" href="../css/epicstyles.css">
	</head>
	<body class="footerBody">
		<main class="footerMain">
				<div class="container">
				<div class="row">
					<div class="col-md-6">
						<!-- NAV BAR -->
						<ul class="nav nav-tabs">
							<li role="presentation"><a href="index.php">Home</a></li>
							<li role="presentation"><a href="#">Jason</a></li>
							<li role="presentation"><a href="epic-dana.php">Dana</a></li>
							<li role="presentation"><a href="epic-jessica.php">Jessica</a></li>
							<li role="presentation" class="active"><a href="#">Data Design</a></li>
						</ul>
					</div>
					<div class="col-md-6 text-right">
						<h2>jpegery</h2>
					</div>
				</div>


				<h1 class="page-header">Data Design</h1>

				<!-- CONCEPTUAL MODEL -->
				<div class="row">
					<div class="col-md-12">
						<h2>Conceptual Model</h2>
						A user posts an image and can include a caption and tags.<br>
						Other users can view the content and post comments.<br>
						All users can view the content and associated comments.
					</div>
				</div>

				<!-- ERD -->
				<div class="row">
					<div class="col-md-12">
						<h2>ERD</h2>
						<img src="../images/erd.svg" alt="ERD" class="img-responsive center-block">
					</div>
				</div>
			</div>
		</main>

		<footer>
			<div class="container">
				<div class="col-md-12 footer text-center">
					Copyright © 2016 jpegery
				</div>
			</div>
		</footer>
	</body>
</html>