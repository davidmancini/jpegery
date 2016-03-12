app.controller("LoginController", ["$scope", "$http", "$window", "LoginService", function($scope, $http, $window, LoginService) {

	$scope.loginData = {};
	$scope.alerts = [];

	$scope.submit = function(loginData, validated) {

		if(validated === true) {
			LoginService.login(loginData)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location = ".";
					} else {
						$scope.alerts[0] = {
							type: "danger",
							msg: "You could not be logged in."
						};
					}
				})
		}
	};

}]);