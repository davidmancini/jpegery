app.controller("loginController", ["$scope", "$http", "$window", "loginService", function($scope, $http, $window, loginService) {
	$scope.loginData = {};
	$scope.alerts = [];

	$scope.submit = function(loginData, validated) {
		if(validated === true) {
			loginService.login(loginData)
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