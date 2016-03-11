<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.js"></script>
		<script type="text/javascript" src="https://angular-file-upload.appspot.com/js/ng-file-upload-shim.js"></script>
		<script type="text/javascript" src="https://angular-file-upload.appspot.com/js/ng-file-upload.js"></script>
		<title>Jpegery</title>
		<script src="js/app.js"></script>
		<script src="js/script.js"></script>
		<?php require_once("lib/head-utils.php") ?><!--Includes Bootstrap, Google Fonts, Font Awesome, etc. -->
		<link rel="stylesheet" href="css/style.css"><!--Overrides core Bootstrap-->
	</head>
	<body ng-app="FileUpload">
		<div class="mainContent">
			<header>
				<?php require_once("lib/header.php"); ?>
			</header>

			<main>
				<div class="container contentContainer">


				</div><!--/contentContainer-->
			</main>
		</div><!--/mainContent-->
		<footer>
			<?php require_once("lib/footer.php") ?>
		</footer>
	</body>
</html>