app.controller('imageController', ['$scope', '$http', '$window', 'imageService', 'commentService', function($scope, $http, $window, imageService, commentService) {
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.images = [];
	$scope.comments = [];

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