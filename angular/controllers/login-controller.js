app.controller("LoginController", ["$scope", "$http", "LoginService", function($scope, $http, LoginService) {

	$scope.loginData = {};
	$scope.alerts = [];

	$scope.submit = function(loginData, validated) {

		if(validated === true) {

			LoginService.login(loginData)
				.then(function(reply) {
					if(reply.status === 200) {
						$scope.alerts[0] = {
							type: "success",
							msg: "You logged in successfully!"
						};
					} else {
						$scope.alerts[0] = {
							type: "danger",
							msg: "You could not be logged in."
						};
					}
					$scope.loginData = {};
				})
		}
	};

}]);