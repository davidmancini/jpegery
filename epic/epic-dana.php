<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Dana McNeill</title>
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
						<li role="presentation"><a href="index.php">Home</a></li>
						<li role="presentation"><a href="epic-jason.php">Jason</a></li>
						<li role="presentation" class="active"><a href="#">Dana</a></li>
						<li role="presentation"><a href="epic-jessica.php">Jessica</a></li>
						<li role="presentation"><a href="data-design.php">Data Design</a></li>
						<li role="presentation"><a href="wireframes/index.php">Wireframes</a></li>
					</ul>
				</div>
				<div class="col-md-6 text-right">
					<h2>jpegery</h2>
				</div>
			</div>

			<h1 class="page-header">Dana McNeill</h1>

			<div class="row">
				<div class="col-md-12">
					<img src="../images/persona2.jpg" alt="Dana McNeill" class="img-circle img-responsive center-block"><br>
					<p class="text-center"><strong>Dana McNeill, 26</strong><br>Accounting<br><p></p>
				</div>
			</div>

			<!-- GOAL & HISTORY -->
			<div class="row">
				<div class="col-md-6">
					<h2>Goal</h2>
					Following the advice of a speaker at her old University, Dana has taken to creating an image diary, drawing something that she saw or experienced every day in ink. She has posted them on jpegery every day for a bit more than a year, often providing comments describing the context of the images. This is primarily a hobby for her, and other than a vague satisfaction in how much her art has improved and how she hasn’t missed a day, she has no real goals or agendas in her drawings. However, she is probably more invested in this app than she would like to admit.				</div>
				<div class="col-md-6">
					<h2>History</h2>
					Dana grew up a military brat, living on a base for most of her childhood. She’s aggressive in the stock market, particularly with tech stocks. As a result of her stock market success she is able to afford new and powerful devices. She uses the latest iPhone +, an iPad Air, and an iMac with two extra displays.				</div>
			</div>

			<!-- USE CASE & USER STORIES -->
			<div class="row">
				<div class="col-md-6">
					<h2>User Story</h2>
					<blockquote>“As a user, I want to view the images in my feed.”</blockquote>
				</div>
				<div class="col-md-6">
					<h2>Use Case</h2>
					<strong>View Content in Feed</strong>
					<ul>
						<li>Dana: Access site</li>
						<li>Site: Displays generic welcome page with authentication fields</li>
						<li>Dana: Enters username and password</li>
						<li>Site: Queries database and verifies dana is a registered user and has entered the correct password</li>
						<li>Site: Displays user profile</li>
						<li>Dana: Views content in feed</li>
					</ul>
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