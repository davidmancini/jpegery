<form id="registerForm" name="registerForm" ng-submit="createProfile(registerData, registerForm.$valid);" novalidate>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profileNameF.$touched && registerForm.profileNameF.$invalid } ">
		<label for="profileNameF">First Name</label>
		<input type="text" class="form-control" id="profileNameF" name="profileNameF" placeholder="First Name" ng-model="registerData.profileNameF" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profileNameF.$error" ng-if="registerForm.profileNameF.$touched" ng-hide="registerForm.profileNameF.$valid">
			<p ng-message="minlength">First Name is too short</p>
			<p ng-message="maxlength">First Name is too long</p>
			<p ng-message="required">First Name is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profileNameL.$touched && registerForm.profileNameL.$invalid } ">
		<label for="profileNameL">Last Name</label>
		<input type="text" class="form-control" id="profileNameL" name="profileNameL" placeholder="Last Name" ng-model="registerData.profileNameL" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profileNameL.$error" ng-if="registerForm.profileNameL.$touched" ng-hide="registerForm.profileNameL.$valid">
			<p ng-message="minlength">Last Na me is too short</p>
			<p ng-message="maxlength">Last Name is too long</p>
			<p ng-message="required">Last Name is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profileHandle.$touched && registerForm.profileHandle.$invalid } ">
		<label for="profileHandle">Handle</label>
		<input type="text" class="form-control" id="profileHandle" name="profileHandle" placeholder="Handle" ng-model="registerData.profileHandle" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profileHandle.$error" ng-if="registerForm.profileHandle.$touched" ng-hide="registerForm.profileHandle.$valid">
			<p ng-message="minlength">Handle is too short</p>
			<p ng-message="maxlength">Handle is too long</p>
			<p ng-message="required">Handle is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profileEmail.$touched && registerForm.profileEmail.$invalid } ">
		<label for="profileEmail">Email</label>
		<input type="text" class="form-control" id="profileEmail" name="profileEmail" placeholder="Email" ng-model="registerData.profileEmail" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profileEmail.$error" ng-if="registerForm.profileEmail.$touched" ng-hide="registerForm.profileEmail.$valid">
			<p ng-message="minlength">Email is too short</p>
			<p ng-message="maxlength">Email is too long</p>
			<p ng-message="required">Email is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profilePhone.$touched && registerForm.profilePhone.$invalid } ">
		<label for="profilePhone">Phone Number</label>
		<input type="text" class="form-control" id="profilePhone" name="profilePhone" placeholder="Phone Number" ng-model="registerData.profilePhone" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profilePhone.$error" ng-if="registerForm.profilePhone.$touched" ng-hide="registerForm.profilePhone.$valid">
			<p ng-message="minlength">Phone Number is too short</p>
			<p ng-message="maxlength">Phone Number is too long</p>
			<p ng-message="required">Phone Number is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profilePassword.$touched && registerForm.profilePassword.$invalid } ">
		<label for="profilePassword">Password</label>
		<input type="password" class="form-control" id="profilePassword" name="profilePassword" placeholder="Password" ng-model="registerData.profilePassword" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profilePassword.$error" ng-if="registerForm.profilePassword.$touched" ng-hide="registerForm.profilePassword.$valid">
			<p ng-message="minlength">Password is too short</p>
			<p ng-message="maxlength">Password is too long</p>
			<p ng-message="required">Password is required</p>
		</div>
	</div>

	<div class="form-group" ng-class=" { 'has-error':registerForm.profilePassword2.$touched && registerForm.profilePassword2.$invalid } ">
		<label for="profilePassword2">Confirm Password</label>
		<input type="password" class="form-control" id="profilePassword2" name="profilePassword2" placeholder="Password" ng-model="registerData.profilePassword2" ng-minlength="2" ng-maxlength="32" ng-required="true" pw-check="profilePassword">
		<div class="alert alert-danger" role="alert" ng-messages="registerForm.profilePassword2.$error" ng-if="registerForm.profilePassword2.$touched" ng-hide="registerForm.profilePassword2.$valid">
			<p ng-message="minlength">Password Confirmation is too short</p>
			<p ng-message="maxlength">Password Confirmation is too long</p>
			<p ng-message="required">Password Confirmation is required</p>
			<p ng-message="pwmatch">Passwords Don't Match</p>
		</div>
	</div>

	<button type="submit" name="submit" id="submit" class="btn btn-primary">Register</button>
</form>
<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>