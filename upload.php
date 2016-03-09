<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.js"></script>
		<script type="text/javascript" src="https://angular-file-upload.appspot.com/js/ng-file-upload-shim.js"></script>
		<script type="text/javascript" src="https://angular-file-upload.appspot.com/js/ng-file-upload.js"></script>
		<title>Jpegery</title>
		<script src="script.js"></script>
		<?php require_once("lib/head-tags.html") ?><!--Includes Bootstrap, Google Fonts, Font Awesome, etc. -->
		<link rel="stylesheet" href="css/style.css"><!--Overrides core Bootstrap-->
	</head>
	<body ng-app="FileUpload">
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
						<div class="col-sm-9"><!--Upload Image-->
							<h2>Upload Image</h2>
							<form ng-controller="MyCtrl" name="form">
								<div class="form-group">
									<label for="image" class="col-sm-2 control-label">Select Image&nbsp;<i class="fa fa-file-image-o"></i></label>
									<button ngf-select ng-model="file" name="file">Select Image</button>
								</div>
								<div class="form-group">
									<label for="text" class="col-sm-2 control-label">Caption&nbsp;<i class="fa fa-commenting-o"></i></label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="text" placeholder="Caption">
									</div>
								</div>
								<button type="submit" ng-click="submit()" class="btn btn-default pull-right"><i class="fa fa-cloud-upload"></i>&nbsp;Post</button>
							</form>

						</div><!--/Upload Image-->

					</div><!--/settingsRow-->
				</div><!--/contentContainer-->
			</main>
		</div><!--/mainContent-->
		<footer>
			<?php require_once("lib/footer.php") ?>
		</footer>
	</body>
</html>