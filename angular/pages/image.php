<ng-include src="'angular/templates/content-search.php'"></ng-include>
<div class="row">
	<div class="col-sm-3 hidden-xs nextImageColumn"><!--Next Images; disappears on screens smaller than small-->
		<h3 class="text-center">Next Images</h3>
		<div class="nextImageGroup">

			<div class="col-sm-6">
				<div ng-repeat="nextImage in images |orderBy:'-imageDate'">
					<a href="{{nextImage.imageFileName}}"><img src="{{nextImage.imageFileName}}" class="center-block img-responsive"></a>
				</div>
			</div>
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
		<p class="text-center"><a href="#">{{getProfileByProfileId(image.imageProfileId).profileHandle}}</a> {{image.imageDate | date : 'short' }}</p>
		<div>
			<img src="{{image.imageFileName}}" alt="{{image.imageText}}" class="center-block img-responsive">
		</div>
		<div class="imageData">
			<div class="imageText text-center">
				{{image.imageText}}
			</div>
		</div><!--/imageData-->
	</div><!--/Image-->

	<div class="col-sm-3 col-xs-12 center-block"><!--Tag cloud and up/downvotes-->
		<h3 class="text-center">Tags</h3>
		<p class="text-center"></p><br>
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
			<form name="commentForm" id="commentForm" ng-submit="submit(commentData, commentForm.$valid);" novalidate>
				<div class="input-group">
					<input type="text" class="form-control" name="comment" id="comment" cols="30" rows="3" ng-minlength="2" ng-maxlength="1024" ng-required="true" placeholder="Comment">
					<span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-comment"></i>&nbsp;Comment</button></span>
				</div>
			</form>
		</div>
		<div class="commentSection">
			<div class="row">
				<div class="col-md-12">
					<ul>
						<li ng-repeat="comment in comments">
							{{getProfileByProfileId(comment.commentProfileId).profileHandle}} said: {{comment.commentText}}
							{{comment.commentDate | date : 'short'}}
						</li>
					</ul>
				</div>
			</div>
<!--			<div class="comment">-->
<!--				<a href="#"><img src="images/placeholder.png" alt="Placeholder Image" width="100"></a>-->
<!--				<a href="#">{{User Name}}</a>&nbsp;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti deserunt fugit harum rem tempore. Adipisci aspernatur culpa, facere impedit maxime nemo nihil officia optio quidem reprehenderit suscipit velit veritatis voluptatum.-->
<!--				<p class="pull-right commentTime"><i class="fa fa-comment-o"></i>&nbsp;{{Comment Time}}</p>-->
<!--			</div>-->

		</div><!--/commentSection-->
	</div><!--/commentGroup-->
</div><!--/commentRow-->