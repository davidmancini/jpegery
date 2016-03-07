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
					<?php require_once ("lib/content-search.php"); ?>
					<div class="row">
							<div class="col-sm-3 hidden-xs nextImageColumn"><!--Next Images; disappears on screens smaller than small-->
							<h3 class="text-center">Next Images</h3>
							<div class="nextImageGroup">
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>
								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
								<div class="col-sm-6">
									<div>
										<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" class="img-responsive nextImage"></a>
									</div>								</div>
							</div><!--/nextImageGroup-->
						</div><!--/nextImageColumn-->

						<div class="col-sm-6 col-xs-12"><!--Image-->
							<h2 class="text-center">{Image Title}</h2>
							<img src="images/placeholder.png" alt="Placeholder Image" class="center-block img-responsive">
							<div class="imageData">
								<div class="imageText text-center">
									{Image Text}
								</div>
								<div class="submit-comment">
									<form action="">
										<div class="input-group">
											<textarea name="comment" id="comment" cols="30" rows="3" class="form-control" placeholder="Comment"></textarea>
											<span class="input-group-btn"><button type="submit" class="btn btn-default">Submit</button></span>
										</div>
									</form>
								</div>
								<div class="comments">

								</div>
							</div><!--/imageData-->
						</div><!--/Image-->


						<div class="col-sm-3 col-xs-12 center-block"><!--Tag cloud and up/downvotes-->
							<h3 class="text-center">Tags</h3>
							{{Tag Cloud}}
						</div>

					</div><!--/row-->
				</div><!--/contentContainer-->
			</main>

		</div><!--/mainContent-->
		<footer>
			<?php require_once("lib/footer.php") ?>
		</footer>
	</body>
</html>