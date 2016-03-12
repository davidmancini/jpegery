app.controller('settingsController', ["$scope", "profileService", function($scope, profileService) {

	$scope.profile = null;
	$scope.alerts = [];

	if ($scope.profile === null) {
		$scope.getCurrentProfile();
	}
}]);