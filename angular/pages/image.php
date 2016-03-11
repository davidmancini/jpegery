<?php require_once("lib/content-search.php"); ?>
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
		<p class="text-center"><a href="#">{{Author}}</a> {{Time Published}}</p>
		<div>
			<img src="images/placeholder.png" alt="Placeholder Image" class="center-block img-responsive">
		</div>
		<div class="imageData">
			<div class="imageText text-center">
				{Image Text}
			</div>
		</div><!--/imageData-->
	</div><!--/Image-->

	<div class="col-sm-3 col-xs-12 center-block"><!--Tag cloud and up/downvotes-->
		<h3 class="text-center">Tags</h3>
		<p class="text-center">{{Tag Cloud}}</p><br>
		<div class="upDownVote text-center">
			<div class="btn-group btn-group-xs" role="group" aria-label="Up and Down Votes">
				<button type="button" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i>&nbsp;#</button>
				<button type="button" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i>&nbsp;#</button>
			</div>
		</div>
	</div>
</div><!--/row-->

<div class="row"><!--commentRow-->
	<div class="col-sm-3">
		<!--Empty; used to center comments with the row above-->
	</div>
	<div class="col-sm-6 col-xs-12"><!--commentGroup-->
		<div class="submit-comment">
			<form action="">
				<div class="input-group">
					<textarea name="comment" id="comment" cols="30" rows="3" class="form-control" placeholder="Comment"></textarea>
					<span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-comment"></i>&nbsp;Comment</button></span>
				</div>
			</form>
		</div>
		<div class="commentSection">
			<div class="comment">
				<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" width="100"></a>
				<a href="#">{{User Name}}</a>&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti deserunt fugit harum rem tempore. Adipisci aspernatur culpa, facere impedit maxime nemo nihil officia optio quidem reprehenderit suscipit velit veritatis voluptatum.
				<p class="pull-right commentTime"><i class="fa fa-comment-o"></i>&nbsp;{{Comment Time}}</p>
			</div>
			<div class="comment">
				<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" width="100"></a>
				<a href="#">{{User Name}}</a>&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti deserunt fugit harum rem tempore. Adipisci aspernatur culpa, facere impedit maxime nemo nihil officia optio quidem reprehenderit suscipit velit veritatis voluptatum.
				<p class="pull-right commentTime"><i class="fa fa-comment-o"></i>&nbsp;{{Comment Time}}</p>
			</div>
			<div class="comment">
				<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" width="100"></a>
				<a href="#">{{User Name}}</a>&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti deserunt fugit harum rem tempore. Adipisci aspernatur culpa, facere impedit maxime nemo nihil officia optio quidem reprehenderit suscipit velit veritatis voluptatum.
				<p class="pull-right commentTime"><i class="fa fa-comment-o"></i>&nbsp;{{Comment Time}}</p>
			</div>
		</div><!--/commentSection-->
	</div><!--/commentGroup-->
</div><!--/commentRow-->