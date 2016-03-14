app.controller('imageController', ['$scope', '$http', '$window', 'imageService', function($scope, $http, $window, imageService) {
	$scope.commentData = {};
	$scope.alerts = [];

	$scope.submit = function(commentData, validated) {
		if(validated === true) {
			imageService.comment(commentData)
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