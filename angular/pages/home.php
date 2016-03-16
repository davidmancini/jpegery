<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<div class="btn-group pull-right" role="group" aria-label="...">
		<button type="button" class="btn btn-default"><i class="fa fa-users"></i>&nbsp;Following</button>
		<button type="button" class="btn btn-default"><i class="fa fa-exchange"></i>&nbsp;Followers</button>
		<button type="button" class="btn btn-default"><i class="fa fa-fire"></i>&nbsp;Trending</button>
		<button type="button" class="btn btn-default"><i class="fa fa-trophy"></i>&nbsp;Most Popular</button>
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
					  aria-expanded="false">View By&nbsp;<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a href="#">Not Yet Followed</a></li>
				<li><a href="#">Other...</a></li>
			</ul>
		</div>
	</div><!--End Button Group-->
	<br/>
</div>

<div class="row contentRow contentImageRow">
	<div class="col-xs-6 col-sm-4 col-md-3 homeRow" ng-repeat="image in images">
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