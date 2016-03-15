app.controller('settingsController', ["$scope", "currentProfile", function($scope, currentProfile) {

	$scope.profile = null;
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
					};
				}
			});
	};

	if ($scope.profile === null) {
		$scope.getCurrentProfile();
	}
}]);