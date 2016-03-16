<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<!--		<div class="pull-left col-md-4 col-xs-12">-->
	<!--			<img src="images/placeholder.png" alt="Placeholder Image" width="150">-->
	<!--		</div>-->

	<div class="col-md-12 col-xs-12 userInfo center-block text-center">
		<h2>{{profile.profileHandle}}</h2>
		<!--			<p>340 Uploaded Images</p>-->
		<p>Member since {{profile.profileCreateDate | date:'M/dd/yyyy'}}</p>
		<!--			<button type="button" href="#" class="btn btn-default"><i class="fa fa-user-plus"></i>&nbsp;Follow</button>-->
	</div>

	<!--	<div class="col-md-6">-->
	<!--		<div class="btn-group pull-right" role="group" aria-label="...">-->
	<!--			<button type="button" class="btn btn-default"><i class="fa fa-angle-double-up"></i>&nbsp;Newest</button>-->
	<!--			<button type="button" class="btn btn-default"><i class="fa fa-trophy"></i>&nbsp;Most Popular</button>-->
	<!--			<button type="button" class="btn btn-default"><i class="fa fa-fire"></i>&nbsp;Most Commented</button>-->
	<!--			<button type="button" class="btn btn-default"><i class="fa fa-angle-double-down"></i>&nbsp;Oldest</button>-->
	<!--		</div>
	<!--	</div>-->
</div><!--End Row-->

<div class="row contentRow contentImageRow">
	<div class="col-xs-6 col-sm-4 col-md-3 homeRow" ng-repeat="image in images | orderBy: image.imageDate:true">
		<div>
			<a href="image/{{image.imageId}}">
				<div class="thumbnail homeImage">
					<img src="{{image.imageFileName}}" alt="{{image.imageText}}" class="img-responsive contentImage">
				</div>
			</a>
		</div>
		<div class="upDownVote text-center">
			<div class="btn-group btn-group-xs" role="group" aria-label="Up and Down Votes">
				<button type="button" class="btn btn-success"><i class="fa fa-thumbs-o-up"></i>&nbsp;#</button>
				<button type="button" class="btn btn-danger"><i class="fa fa-thumbs-o-down"></i>&nbsp;#</button>
			</div>
		</div>
	</div>
</div>
