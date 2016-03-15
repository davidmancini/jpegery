app.controller('logoutController', ["$scope", "$window", "logoutService", function($scope, $window, logoutService) {
	logoutService.logout()
		.then(function() {
			$window.location = ".";
		});
}]);