app.controller('imageController', ['$scope', '$http', '$window', 'imageService', 'commentService', 'profileService', function($scope, $http, $window, imageService, commentService, profileService) {
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.images = [];
	$scope.comments = [];
	$scope.image = null;
	$scope.profile = null;
	$scope.imgId = null;

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

	$scope.getCommentsByImageId = function() {
		$scope.imgId = $scope.image.imageId;
		commentService.fetchByImageId($scope.imgId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
					console.log("This worked");
				}
				else {
					console.log("This did not work");
					$scope.alerts[0] = {
						type: "danger",
						msg: "Comments could not be loaded"
					}
				}
			})
	};
	if($scope.comments.length === 0 && $scope.image !== null) {
		$scope.comments = $scope.getCommentsByImageId()
	}

	$scope.changeImage = function(img) {
		$scope.image =img;
		$scope.comments = $scope.getCommentsByImageId()
	};

	//$scope.getProfileHandleByProfileId = function(profileId) {
	//	profileService.fetchHandleById(profileId)
	//		.then(function(results) {
	//			if(result.data.status === 200) {
	//				return result.data.data;
	//			} else {
	//				$scope.alerts[0] = {
	//					type: "danger",
	//					msg: "We could not find the handle of the user who posted this comment"
	//				};
	//			}
	//		});
	//};

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
		$scope.image = $scope.getCurrentImage();
	}
	$scope.submit = function(commentData, validated) {
		if(validated === true) {
			commentData.commentProfileId = $scope.profile.profileId;
			commentData.commentImageId = $scope.image.imageId;
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