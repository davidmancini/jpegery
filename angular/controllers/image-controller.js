app.controller('imageController', ['$scope', '$http', '$window', 'imageService', 'commentService', function($scope, $http, $window, imageService, commentService) {
	$scope.commentData = {};
	$scope.alerts = [];
	$scope.images = [];

	$scope.images = imageService.all();

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