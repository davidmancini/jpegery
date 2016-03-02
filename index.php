<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Jpegery</title>
		<?php require_once("lib/head-tags.html") ?><!--Includes Bootstrap, Google Fonts, Font Awesome, etc. -->
		<link rel="stylesheet" href="css/style.css"><!--Overrides core Bootstrap-->
	</head>
	<body>
		<div class="mainContent">
			<header>
				<?php require_once("lib/header.php"); ?>
			</header>

			<main>
				<div class="container contentContainer">
					<div class="row">
						<div class="col-md-6 text-center">
							<!--Blank section. Could be used for company banner?-->
						</div>
						<div class="col-md-6 text-center">
							<div class="input-group search hidden-sm hidden-md hidden-lg"><!--Search box is only visible when search box on nav bar disappears-->
								<input type="text" class="form-control" name="search" id="search" placeholder="Search for...">
									<span class="input-group-btn">
										<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
									</span>
							</div>
							<div class="btn-group" role="group" aria-label="...">
								<button type="button" class="btn btn-default">Following</button>
								<button type="button" class="btn btn-default">Followers</button>
								<button type="button" class="btn btn-default">Trending</button>
								<button type="button" class="btn btn-default">Most Popular</button>
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View By&nbsp;<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a href="#">Not Yet Followed</a></li>
										<li><a href="#">Other...</a></li>
									</ul>
								</div>
							</div><!--End Button Group-->
						</div>
					</div>

					<div class="row contentRow contentImageRow">
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage">
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
						<div class="col-xs-6 col-sm-4 col-md-3">
							<a href="#"><img src="images/placeholder.png" alt="Placeholder image" class="img-responsive contentImage"></a>
						</div>
					</div><!--/contentContainer-->
			</main>
		</div><!--/mainContent-->
		<footer>
			<?php require_once("lib/footer.php") ?>
		</footer>
	</body>
</html>