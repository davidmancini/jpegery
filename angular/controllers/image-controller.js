app.controller('imageController', ['$scope', '$http', '$window', 'imageService', 'commentService', 'profileService', function($scope, $http, $window, imageService, commentService, profileService) {
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.images = [];
	$scope.comments = [];
	$scope.image = null;
	$scope.profile = null;

	$scope.getAllImages = function() {
		imageService.all()
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.images = result.data.data;
				}
				else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "Images could not be loaded"
					}
				}
			})
	};
	if($scope.images.length === 0) {
		$scope.images = $scope.getAllImages();
	}

	$scope.changeImage = function(img) {
		$scope.image =img;
	};
	//$scope.getAllComments = function() {
	//	commentService.all()
	//		.then(function(result) {
	//			if(result.data.status === 200) {
	//				$scope.comments = result.data.data;
	//			}
	//			else {
	//				$scope.alerts[0] = {
	//					type: "danger",
	//					msg: "Comments could not be loaded"
	//				}
	//			}
	//		})
	//};
	//$scope.comments = commentService.all();

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
		$scope.profile = $scope.getCurrentProfile();
	}
	$scope.getCurrentImage = function() {
		profileService.fetchCurrent(true)
			.then(function(result) {
				if (result.data.status === 200) {
					$scope.image = result.data.data;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not viewing an image.."
					};
				}
			});
	};

	if ($scope.image === null) {
		$scope.image = $scope.getCurrentProfile();
	}
	$scope.submit = function(commentData, validated) {
		if(validated === true) {
			commentService.comment(commentData)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location = ".";
					} else {
						$scope.alerts[0] = {
							type: "danger",
							msg: "Your comment could not be posted"
						};
					}
				})
		}
	};
}]);