app.controller('userController', ['$http', '$scope', 'profileService', 'imageService', '$routeParams', function($http, $scope, profileService, imageService, $routeParams) {
	$scope.alerts = [];
	$scope.images = [];
	$scope.image = null;
	$scope.currentProfileId = $routeParams.profileId;
	$scope.profile = null;

	$scope.getProfileByProfileId = function() {
		profileService.fetchByProfileId($scope.currentProfileId)
			.then(function(reply) {
				if(reply.data.status === 200) {
					console.log(reply);
					$scope.profile = reply.data.data;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not viewing an image.."
					};
				}
			});
	};
	if($scope.profile === null) {
		$scope.getProfileByProfileId();
	}

	$scope.getImagesByProfileId = function() {
		$scope.profId = $scope.profile.profileId;
		imageService.fetchByProfileId($scope.profId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
					console.log("This worked");
				}
				else {
					console.log("This did not work");
					$scope.alerts[0] = {
						type: "danger",
						msg: "Images could not be loaded"
					}
				}
			})
	};

}]);