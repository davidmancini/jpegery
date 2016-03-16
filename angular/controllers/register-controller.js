app.controller("registerController", ["$scope", "$http", "$window", "profileService", function($scope, $http, $window, profileService) {
	$scope.loginData = {};
	$scope.alerts = [];

	$scope.createProfile = function(registerData, validated) {
		if(validated === true) {

			profileService.create(registerData)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location = ".";
					} else {
						$scope.alerts[0] = {
							type: "danger",
							msg: "You could not be registered."
						};
					}
				})
		}
	};

}]);