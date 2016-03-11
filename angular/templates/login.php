<form id="loginForm" name="loginForm" ng-controller="LoginController" ng-submit="submit(loginData, loginForm.$valid);" novalidate>
	Username: <input type="text" name="emailHandlePhone" id="emailHandlePhone" ng-model="loginData.emailHandlePhone"><br>
	Password: <input type="password" name="password" id="password" ng-model="loginData.password">
	<button type="submit">Log In</button>
	<pre>
		{{loginData | json}}
	</pre>
</form>