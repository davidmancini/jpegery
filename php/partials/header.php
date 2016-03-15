<header>
	<!--NAV BAR-->
	<nav class="navbar navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">jpegery</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
<!--					<li class="active"><a href="#">Current <span class="sr-only">(current)</span></a></li>-->
					<?php if(empty($_SESSION["profile"])) { ?>
						<li><a href="login"><i class="fa fa-sign-in"></i>&nbsp;Log In</a></li>
						<li><a href="register"><i class="fa fa-user"></i>&nbsp;Register</a></li>
					<?php }
					if(!empty($_SESSION["profile"])) {?>
						<li><a href="#"><i class="fa fa-sign-out"></i>&nbsp;Log Out (doesn't exist yet)</a></li>
						<li><a href="settings"><i class="fa fa-cog"></i>&nbsp;Settings</a></li>
					<?php } ?>
				</ul>
				<form class="navbar-form navbar-right hidden-xs" role="search"><!--Search box is hidden when nav bar collapses-->
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search for...">
					</div>
					<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div><!--/navbar-collapse-->
		</div><!--/container-fluid-->
	</nav><!--END NAV BAR-->
</header>