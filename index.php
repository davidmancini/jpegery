<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Jpegery</title>
		<?php require_once("lib/head-tags.html")?><!--Includes Bootstrap, Google Fonts, Font Awesome, etc. -->
		<link rel="stylesheet" href="css/style.css"><!--Overrides core Bootstrap-->
	</head>
	<body>
		<div class="mainContent">
			<header>
				<!--NAV BAR-->
				<nav class="navbar navbar-default navbar-fixed-top">
					<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<a class="navbar-brand" href="#">jpegery</a>
							</div>
							<div class="collapse navbar-collapse" id="navbar-collapse">
								<ul class="nav navbar-nav navbar-right">
									<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
									<li><a href="#">Link</a></li>
								</ul>
						</div><!--/navbar-collapse-->
					</div><!--/container-fluid-->
				</nav><!--END NAV BAR-->
			</header>

			<main>
				<div class="container contentContainer">
						<div class="row">
						<div class="col-md-6">

						</div>
						<div class="col-md-6">

						</div>
					</div>
					<div class="row">
						<div class="col-md-3">

						</div>
						<div class="col-md-3">

						</div>
						<div class="col-md-3">

						</div>
						<div class="col-md-3">

						</div>
					</div>
				</div><!--/contentContainer-->
			</main>
		</div><!--/mainContent-->
		<footer>
			<?php require_once("footer.php")?>
		</footer>
	</body>
</html>