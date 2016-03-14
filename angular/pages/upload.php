<div class="row aboveRow">
	<ng-include src="'angular/templates/content-search.php'"></ng-include>
	<div class="pull-left col-sm-3">
		<img src="images/placeholder.png" alt="Placeholder Image" width="150">
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
		<h2>Upload Image</h2>
		<form ng-controller="uploadController" name="form" id="form">
			<div class="form-group">
				<!--									<label for="image" class="col-sm-2 control-label">Select Image&nbsp;<i class="fa fa-file-image-o"></i></label>-->
				<button class="form-control" ngf-select ng-model="file" name="file" ngf-pattern="'image/*'"
						  ngf-accept="'image/*'">Select Image&nbsp;<i class="fa fa-file-image-o"></i></button>
			</div>
			<div class="form-group">
				<label for="caption" class="col-sm-2 control-label">Caption&nbsp;<i class="fa fa-commenting-o"></i></label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="caption" name="caption" placeholder="Caption" ng-model="caption">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-6">
					<input type="text" class="form-control" id="tags" name="tags" placeholder="Please separate your tags with # and spaces" ng-model="tags">
				</div>
			</div>
			<button type="submit" ng-click="submit()" class="btn btn-default pull-right"><i class="fa fa-cloud-upload"></i>&nbsp;Post</button>
		</form>

	</div><!--/Upload Image-->

</div><!--/settingsRow-->