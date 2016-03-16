<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<div class="pull-left col-sm-3">
		<!--User's Avatar-->
<!--		<img src="images/placeholder.png" alt="Placeholder Image" width="150">-->
	</div>
	<div class="col-sm-9 userInfo">
		<h2>{{profile.profileNameF}} {{profile.profileNameL}}</h2>
	</div>
</div><!--End Row-->

<div class="row"><!--settingsRow-->
	<div class="col-sm-3">
		<!--Empty; to align with above-->
	</div>
	<div class="col-sm-9"><!--Upload Image-->
		<h1 class="text-center">Post an Image</h1>
		<form ng-controller="uploadController" name="form" id="form">
			<div class="form-group">
				<label for="file" class="control-label"><i class="fa fa-file-image-o"></i>&nbsp;Select Image</label>
				<input type="file" class="form-control" ngf-select ng-model="file" name="file" ngf-pattern="'image/*'"
						  ngf-accept="'image/*'">
			</div>
			<div class="form-group">
				<label for="caption" class="control-label"><i class="fa fa-commenting-o"></i>&nbsp;Caption</label>
				<input type="text" class="form-control" id="caption" name="caption" placeholder="Caption" ng-model="caption">
			</div>
			<button type="submit" ng-click="submit()" class="btn btn-default pull-right"><i class="fa fa-cloud-upload"></i>&nbsp;Post</button>
		</form>

	</div><!--/Upload Image-->

</div><!--/settingsRow-->