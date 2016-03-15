<footer>
	<div class="container-fluid footer">
		<div class="row">
			<div class="col-xs-6">
				<?php if(empty($_SESSION["profile"])) { ?>
					<a href="login"><i class="fa fa-sign-in"></i>&nbsp;Log In</a>&nbsp;&nbsp;
				<?php }
				if(!empty($_SESSION["profile"])) { ?>
					<a href="logout"><i class="fa fa-sign-out"></i>&nbsp;Log Out</a>&nbsp;&nbsp;
				<?php } ?>
<!--				<a href="help"><i class="fa fa-info"></i>&nbsp;Help</a>&nbsp;&nbsp;-->
				<a href="faq"><i class="fa fa-question"></i>&nbsp;FAQ</a>
			</div>
			<div class="col-xs-6 text-right">
				<a href="contact-us"><i class="fa fa-envelope-o"></i>&nbsp;Contact Us</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<p class="text-center">Copyright &copy; 2015-<?php echo date("Y");?>&nbsp;jpegery<br>All Rights Reserved.</p>
				<img src="images/jpegerylogo.png" alt="jpegery" class="img-responsive center-block" width="150">
			</div>
		</div>
	</div>
</footer>