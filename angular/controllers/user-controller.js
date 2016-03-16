app.controller('userController', ['$http', '$scope', 'profileService', 'imageService', '$routeParams', function($http, $scope, profileService, imageService, $routeParams) {
	$scope.alerts = [];
	$scope.images = [];
	$scope.image = null;
	$scope.profile = null;

	$scope.getProfileByProfileId = function() {
		profileService.fetchByProfileId($routeParams.profileId)
			.then(function(reply) {
				if(reply.data.status === 200) {
					//console.log(reply);
					$scope.profile = reply.data.data;
					$scope.getImagesByProfileId();
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not viewing an image.."
					};
				}
			});
	};

	$scope.getImagesByProfileId = function() {
		imageService.fetchByProfileId($scope.profile.profileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
					//console.log("This worked");
				}
				else {
					//console.log("This did not work");
					$scope.alerts[0] = {
						type: "danger",
						msg: "Images could not be loaded"
					}
				}
			})
	};

	if($scope.profile === null) {
		$scope.getProfileByProfileId();
	}

}]);