<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Jessica Kelso</title>
		<!--Include Bootstrap Head Tags -->
		<?php require_once(dirname(__DIR__) . "/lib/head-utils.php"); ?>
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
						<li role="presentation"><a href="epic-dana.php">Dana</a></li>
						<li role="presentation" class="active"><a href="#">Jessica</a></li>
						<li role="presentation"><a href="data-design.php">Data Design</a></li>
						<li role="presentation"><a href="wireframes/index.php">Wireframes</a></li>
					</ul>
				</div>
				<div class="col-md-6 text-right">
					<h2>jpegery</h2>
				</div>
			</div>


			<h1 class="page-header">Jessica Kelso</h1>

			<div class="row">
				<div class="col-md-12">
					<img src="../images/persona3.jpg" alt="Jessica Kelso" class="img-circle img-responsive center-block"><br>
					<p class="text-center"><strong>Jessica Kelso, 14</strong><br>Student<br><p></p>
				</div>
			</div>

			<!-- GOAL & HISTORY -->
			<div class="row">
				<div class="col-md-6">
					<h2>Goal</h2>
					Jessica is a social teenager who likes to look at her friends’ photos.  She wants to be a artist, but she hasn’t had the courage to post yet.  She uses other social media for sharing her own status and photos (from her phone), but uses jpegery to get inspiration from famous artists.
				</div>
				<div class="col-md-6">
					<h2>History</h2>Jessica is in middle school; her life is consumed by her school, but mostly by her friends and her social life. Her primary device is a hand-me-down iPhone 4s, but also likes the large display on her mother’s iPad. She has an old PC for homework assignments but due to system slowdown caused by years of unchecked malware, prefers to use her phone to use the web and access apps. She doesn’t know that Chrome is a better browser and is therefore still using IE.
				</div>
			</div>

			<!-- USE CASE & USER STORIES -->
			<div class="row">
				<div class="col-md-6">
					<h2>User Story</h2>
					<blockquote>“As a user, I want to follow a contributor.”</blockquote>
					<blockquote>"As a user, I want to comment on a user's image."</blockquote>
				</div>
				<div class="col-md-6">
					<h2>Use Cases</h2>
					<strong>Comment</strong>
					<ul>
						<li>Jessica: Click on the comment icon</li>
						<li>Site: Open the comment text field</li>
						<li>Jessica: Write Comment</li>
						<li>Jessica: Click Submit</li>
						<li>Site: Display comment in logical order</li>
					</ul><br>
					<strong>Follow a Contributor</strong>
					<ul>
						<li>Jessica: Click on desired content</li>
						<li>Site: Open content specific page</li>
						<li>Jessica: Click on follow contributor button</li>
						<li>Site: Add contributor to users following list</li>
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