<div class="row aboveRow">
	<?php require_once("lib/content-search.php"); ?>
	<div class="pull-left col-sm-3">
		<img src="images/placeholder.png" alt="Placeholder Image" width="150">
	</div>
	<div class="col-sm-9 userInfo">
		<h2>{{User Name}}</h2>
	</div>
</div><!--End Row-->

<div class="row"><!--settingsRow-->
	<div class="col-sm-3">
		<!--Empty; to align with above-->
	</div>
	<div class="col-sm-9"><!--Personal Settings-->
		<div class="settingsBox">
			<h2>Personal Settings</h2>
			<form action="" class="form-horizontal" name="personalSettings" id="personalSettings">
				<div class="form-group">
					<label for="firstName" class="col-sm-2 control-label">First Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="firstName" value="{{First Name}}">
					</div>
				</div>
				<div class="form-group">
					<label for="lastName" class="col-sm-2 control-label">Last Name</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lastName" value="{{Last Name}}">
					</div>
				</div>
				<div class="form-group">
					<label for="handle" class="col-sm-2 control-label">Handle</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="handle" value="{{Handle}}">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="email" value="{{Email}}">
					</div>
				</div>
				<button type="submit" class="btn btn-default pull-right">Update</button>
			</form>
		</div>

	</div><!--/Personal Settings-->
	<div class="col-sm-3">
		<!--Empty; to align with above-->
	</div>
	<div class="col-sm-9"><!--Security Settings-->
		<div class="settingsBox">
			<h2>Security</h2>
			<form action="" class="form-horizontal" name="securitySettings" id="securitySettings">
				<div class="form-group">
					<label for="oldPassword" class="col-sm-2 control-label">Old Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="oldPassword" placeholder="Old Password" ">
					</div>
				</div>
				<div class="form-group">
					<label for="newPassword1" class="col-sm-2 control-label">New Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="newPassword1" placeholder="New Password">
					</div>
				</div>
				<div class="form-group">
					<label for="newPassword2" class="col-sm-2 control-label">Confirm New Password</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="newPassword2" placeholder="Confirm New Password" ">
					</div>
				</div>
				<button type="submit" class="btn btn-default pull-right">Change Password</button>
			</form>
		</div>
	</div><!--/Security Settings-->
</div><!--/settingsRow-->
