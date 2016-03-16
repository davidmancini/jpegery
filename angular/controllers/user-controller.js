app.controller('userController', ['$http', '$scope', 'profileService', 'imageService', function($http, $scope, profileService, imageService){
	$scope.alerts = [];
	$scope.images = [];
	$scope.image = null;
	//$scope.profile = null;

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
	if($scope.comments.length === 0 && $scope.profile !== null) {
		$scope.comments = $scope.getImagesByProfileId()
	}

}]);