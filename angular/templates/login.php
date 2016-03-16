<form id="loginForm" name="loginForm" ng-submit="submit(loginData, loginForm.$valid);" novalidate>
<!--	Username: <input type="text" name="emailHandlePhone" id="emailHandlePhone" ng-model="loginData.emailHandlePhone"><br>-->

	<div class="form-group" ng-class=" { 'has-error':loginForm.emailHandlePhone.$touched && loginForm.emailHandlePhone.$invalid } ">
		<label for="emailHandlePhone">Email, Handle, or Phone</label>
		<input type="text" class="form-control" id="emailHandlePhone" name="emailHandlePhone" placeholder="Email, Handle, or Phone" ng-model="loginData.emailHandlePhone" ng-minlength="2" ng-maxlength="32" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="loginForm.emailHandlePhone.$error" ng-if="loginForm.emailHandlePhone.$touched" ng-hide="loginForm.emailHandlePhone.$valid">
			<p ng-message="minlength">Login is too short</p>
			<p ng-message="maxlength">Login is too long</p>
			<p ng-message="required">Login is required</p>
		</div>
	</div>

<!--	Password: <input type="password" name="password" id="password" ng-model="loginData.password">-->

	<div class="form-group" ng-class="{ 'has-error':loginForm.password.$touched && loginForm.password.$invalid }">
		<label for="password">Password</label>
		<input type="password" class="form-control" name="password" id="password" ng-model="loginData.password" ng-minlength="6" ng-maxlength="50" ng-required="true">
		<div class="alert alert-danger" role="alert" ng-messages="loginForm.password.$error" ng-if="loginForm.password.$touched" ng-hide="loginForm.password.$valid">
			<p ng-message="minlength">Password is too short</p>
			<p ng-message="maxlength">Password is too long</p>
			<p ng-message="required">Password is required</p>
		</div>
	</div>

	<button type="submit" name="submit" id="submit" class="btn btn-primary">Login</button>
</form>
<uib-alert ng-repeat="alert in alerts" type="{{ alert.type }}" close="alerts.length = 0;">{{ alert.msg }}</uib-alert>