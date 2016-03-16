app.controller('imageController', ['$scope', '$http', '$window', 'imageService', 'commentService', 'profileService', '$routeParams', function($scope, $http, $window, imageService, commentService, profileService, $routeParams) {
	$scope.currentImageId = $routeParams.imageId;
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.images = [];
	$scope.comments = [];
	$scope.image = null;
	$scope.profile = null;
	$scope.imgId = null;
	$scope.imageContributor = null;
	$scope.handle = null;

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
		$scope.getAllImages();
	}

	$scope.getCommentsByImageId = function() {
		$scope.imgId = $scope.image.imageId;
		commentService.fetchByImageId($scope.imgId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.comments = result.data.data;
					//console.log("This worked");
				}
				else {
					//console.log("This did not work");
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
		$window.location = "image/" + img.imageId;
		//$scope.image = img;
		//$scope.comments = $scope.getCommentsByImageId();
		//$scope.getProfileByProfileId($scope.image.imageProfileId);
	};

	//$scope.getProfileHandleByProfileId = function(profileId) {
	//	return profileService.fetchHandleById(profileId)
	//};
	//
	$scope.getProfileByProfileId = function(profileId) {
		console.log(profileId);
		profileService.fetchByProfileId(profileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.imageContributor = result.data.data;
					console.log($scope.imageContributor.profileHandle);
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "Could not find user."
					};
				}
			});
	};


	$scope.getCurrentProfile = function() {
		profileService.fetchCurrent(true)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.profile = result.data.data;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not logged in."
					};
				}
			});
	};

	if($scope.profile === null) {
		$scope.profile = $scope.getCurrentProfile();
	}
	$scope.getCurrentImage = function() {
		imageService.fetchByImageId($scope.currentImageId)
			.then(function(result) {
				//console.log("Getting current image");
				//console.log(result);
				//console.log("Got current image");
				if(result.data.status === 200) {
					$scope.image = result.data.data;
					$scope.comments = $scope.getCommentsByImageId();
					$scope.getProfileByProfileId($scope.image.imageProfileId);
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "You are not viewing an image.."
					};
				}
			});
	};


	if($scope.image === null) {
		$scope.image = $scope.getCurrentImage();
	}

	$scope.getCommenterHandle = function(profileId) {
		profileService.fetchByProfileId(profileId)
			.then(function(result) {
				if(result.data.status === 200) {
					$scope.handle = result.data.data.profileHandle;
				} else {
					$scope.alerts[0] = {
						type: "danger",
						msg: "Could not find user."
					};
				}
			});
	};


	$scope.submit = function(commentData, validated) {
		if(validated === true) {
			commentData.commentProfileId = $scope.profile.profileId;
			commentData.commentImageId = $scope.image.imageId;
			commentService.comment(commentData)
				.then(function(reply) {
					if(reply.status === 200) {
						$window.location = "image/" + $scope.image.imageId;
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