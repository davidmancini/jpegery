<ng-include src="'angular/templates/content-search.php'"></ng-include>
<div class="row">
	<div class="col-sm-3 hidden-xs nextImageColumn"><!--Next Images; disappears on screens smaller than small-->
		<h3 class="text-center">Newest Images</h3>
		<div class="nextImageGroup">

			<!--			<div class="col-sm-6">-->
			<div ng-repeat="nextImage in images | orderBy: nextImage.imageDate:true | limitTo: 16" class="col-sm-6">
				<div class="thumbnail nextImage">
					<img ng-click="changeImage(nextImage)" ng-src="{{nextImage.imageFileName}}"
						  class="center-block img-responsive">
				</div>
			</div>
			<!--			</div>-->
		</div><!--/nextImageGroup-->
	</div><!--/nextImageColumn-->

	<div class="col-sm-6 col-xs-12"><!--Image-->
		<h2 class="text-center">{{image.imageText}}</h2>
		<div>
			<p class="text-center"><a href="#">{{imageContributor.profileHandle}}</a></p>
			<img ng-src="{{image.imageFileName}}" alt="{{image.imageText}}" class="center-block img-responsive">
		</div>
		<div class="imageData">
			<div class="imageText text-center">
				<div class="upDownVote text-center">
					<div class="btn-group btn-group-xs" role="group" aria-label="Up and Down Votes">
						<button type="button" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i>&nbsp;#</button>
						<button type="button" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i>&nbsp;#</button>
					</div>
				</div>
				<small>Posted on {{image.imageDate | date : 'short' }}</small>
			</div>
		</div><!--/imageData-->
	</div><!--/Image-->
</div><!--/row-->

<div class="row"><!--commentRow-->
	<div class="col-sm-3">
		<!--Empty; used to center comments with the row above-->
	</div>
	<div class="col-sm-6 col-xs-12"><!--commentGroup-->
		<div class="submit-comment">
			<form name="commentForm" id="commentForm" ng-submit="submit(commentData, commentForm.$valid);" novalidate>
				<div class="input-group">
					<input type="text" class="form-control" name="comment" id="comment" cols="30" rows="3" ng-minlength="2"
							 ng-maxlength="1024" ng-required="true" placeholder="Comment" ng-model="commentData.commentText">
					<span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="fa fa-comment"></i>&nbsp;Comment
						</button></span>
				</div>
			</form>
		</div>
		<div class="commentSection">
			<div class="row">
				<div class="col-md-12">
					<div ng-repeat="nextComment in comments | orderBy:'-commentDate'"
						  ng-init="getCommenterHandle(nextComment.commentProfileId)">
						<p>{{handle}} said: {{nextComment.commentText}}</p>
						{{comment.commentDate | date : 'short'}}
					</div>
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