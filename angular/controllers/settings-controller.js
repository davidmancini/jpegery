app.controller('settingsController', ["$scope", "profileService", function($scope, profileService) {

	$scope.profile = {};
	$scope.alerts = [];

	$scope.getCurrentProfile = function() {
		profileService.fetchCurrent(true)
			.then(function(result) {
				if (result.data.status === 200) {
					$scope.profile = result.data.data;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not logged in."
				}
			});
	};

}]);