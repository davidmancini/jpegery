<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<div class="col-md-6">
		<div class="pull-left col-md-4 col-xs-12">
			<img src="images/placeholder.png" alt="Placeholder Image" width="150">
		</div>

		<div class="col-md-8 col-xs-12 userInfo">
			<h2>{{User Name}}</h2>
			<p>340 Uploaded Images</p>
			<p>Member Since 2015</p>
			<button type="button" href="#" class="btn btn-default"><i class="fa fa-user-plus"></i>&nbsp;Follow</button>
		</div>

	</div>

	<div class="col-md-6">
		<div class="btn-group pull-right" role="group" aria-label="...">
			<button type="button" class="btn btn-default"><i class="fa fa-angle-double-up"></i>&nbsp;Newest</button>
			<button type="button" class="btn btn-default"><i class="fa fa-trophy"></i>&nbsp;Most Popular</button>
			<button type="button" class="btn btn-default"><i class="fa fa-fire"></i>&nbsp;Most Commented</button>
			<button type="button" class="btn btn-default"><i class="fa fa-angle-double-down"></i>&nbsp;Oldest</button>
		</div><!--End Button Group-->
	</div>
</div><!--End Row-->

<div class="row contentRow contentImageRow">
	<div class="col-xs-6 col-sm-4 col-md-3" ng-repeat="image in images">
		<div><a href="#"><img src="{{image.imageFileName}}" alt="{{image.imageText}}" class="img-responsive contentImage"></a>
		</div>
		<div class="upDownVote text-center">
			<div class="btn-group btn-group-xs" role="group" aria-label="Up and Down Votes">
				<button type="button" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i>&nbsp;#</button>
				<button type="button" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i>&nbsp;#</button>
			</div>
		</div>
	</div>
</div>

