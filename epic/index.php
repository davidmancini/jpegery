<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8"/>
		<title>jpegery Epic</title>
		<!--Include Bootstrap Head Tags -->
		<?php require_once(dirname(__DIR__) . "/lib/head-tags.html"); ?>
		<link rel="stylesheet" href="../css/epicstyles.css">
	</head>
	<body class="footerBody">
			<div class="container">
				<main class="footerMain">
				<div class="row">
					<div class="col-md-6">
						<!-- NAV BAR -->
						<ul class="nav nav-tabs">
							<li role="presentation" class="active"><a href="#">Home</a></li>
							<li role="presentation"><a href="#">Jason</a></li>
							<li role="presentation"><a href="epic-dana.php">Dana</a></li>
							<li role="presentation"><a href="epic-jessica.php">Jessica</a></li>
							<li role="presentation"><a href="data-design.php">Data Design</a></li>
						</ul>
					</div>

					<div class="col-md-6 text-right">
						<h2>jpegery</h2>
					</div>
				</div>

				<h1 class="page-header">jpegery Epic</h1>

				<div class="row" >
					<div class="col-md-6">
						<h3>Executive Summary</h3>
						<p>jpegery is a web-based, image-sharing platform.  Our goals are to make it easier for creators of original content to get the recognition they deserve and to make it easier for users to discover new images.<br>
							jpegery will provide users with two primary methods of discovering images that appeal to them. First, they can search through hashtags and users.  Then, they can follow the tags and accounts they like the most.
						</p>
					</div>
					<div class="col-md-6">
						<h3>System Goals</h3>
						<p>By using this site, the end user will be able to:</p>
						<ul>
							<li>Create a unique profile</li>
							<li>Upload original content (images)</li>
							<li>View content that others have submitted</li>
							<li>Comment on content</li>
							<li>Include other content in the commenting system</li>
							<li>Tag content</li>
							<li>Up or down vote posted images</li>
							<li>Follow the creators of images they like</li>
							<li>Utilize facebook log in</li>
						</ul>
					</div>
				</div>

				<h3>Personas</h3><br>
				<div class="row row-eq-height">
					<div class="col-md-6 personaborder">
						<a href="epic-jason.php"><img src="../images/persona1.jpg" alt="Persona 1" class="img-circle img-responsive center-block"></a><br>
							<p class="text-center"><strong>Jason Holmes, 23</strong><br>Graduate Student, TA<br>
							Infrequent poster interested in his images' comments.<br><br>
							<a href="epic-jason.php">Read Jason's Story</a></p>
						</div>
					<div class="col-md-6 personaborder">
						<a href="epic-dana.php"><img src="../images/persona2.jpg" alt="Persona 2" class="img-circle img-responsive center-block"></a><br>
						<p class="text-center"><strong>Dana McNeill, 26</strong><br>Accounting<br>
						Frequent poster interested in the social aspect.<br><br>
						<a href="epic-dana.php">Read Dana's Story</a></p>
					</div>
					<div class="col-md-6 personaborder">
						<a href="epic-jessica.php"><img src="../images/persona3.jpg" alt="Persona 3" class="img-circle img-responsive center-block"></a><br>
						<p class="text-center"><strong>Jessica Kelso, 14</strong><br>Student<br>
						Frequent Commenter and Viewer, but does not post.<br><br>
						<a href="epic-jessica.php">Read Jessica's Story</a></p>
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