<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<div class="btn-group pull-right" role="group" aria-label="...">
		<button type="button" class="btn btn-default"><i class="fa fa-users"></i>&nbsp;Following</button>
		<button type="button" class="btn btn-default"><i class="fa fa-exchange"></i>&nbsp;Followers</button>
		<button type="button" class="btn btn-default"><i class="fa fa-fire"></i>&nbsp;Trending</button>
		<button type="button" class="btn btn-default"><i class="fa fa-trophy"></i>&nbsp;Most Popular</button>
		<div class="btn-group" role="group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View By&nbsp;<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a href="#">Not Yet Followed</a></li>
				<li><a href="#">Other...</a></li>
			</ul>
		</div>
	</div><!--End Button Group-->
	<div ng-app='myApp' ng-controller='ScrollController'>
	<div infinite-scroll='loadMore()' infinite-scroll-distance='2'>
		<img ng-repeat='image in images' ng-src='http://placehold.it/225x250&text={{image}}'>
	</div>
</div>

