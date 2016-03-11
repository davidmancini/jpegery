<?php
/*grab current directory*/
$CURRENT_DIR = __DIR__;

require_once("php/partials/head-utils.php");
?>

<?php require_once("php/partials/header.php");?>


	<body>
		<div class="mainContent">
				<?php require_once("php/partials/header.php"); ?>
			<main>
				<div class="container contentContainer">
					<div ng-view></div>

				</div><!--/contentContainer-->
			</main>
		</div><!--/mainContent-->
			<?php require_once("php/partials/footer.php") ?>
	</body>
</html>