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

					<div class="row aboveRow">
						<?php require_once ("lib/content-search.php"); ?>
						<div class="pull-left col-sm-3">
							<img src="images/placeholder.png" alt="Placeholder Image" width="150">
						</div>
						<div class="col-sm-9 userInfo">
							<h2>{{User Name}}</h2>
						</div>
					</div><!--End Row-->

					<div class="row"><!--settingsRow-->
						<div class="col-sm-3">
							<!--Empty; to align with above-->
						</div>
						<div class="col-sm-9 settingsBox"><!--Personal Settings-->

						</div><!--/Personal Settings-->
						<div class="col-sm-9 settingsBox"><!--Security Settings-->

						</div><!--/Security Settings-->
					</div><!--/settingsRow-->

				</div><!--/contentContainer-->

			</main>
		</div><!--/mainContent-->
		<footer>
			<?php require_once("lib/footer.php") ?>
		</footer>
	</body>
</html>