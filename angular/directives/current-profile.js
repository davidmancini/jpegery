app.directive("currentProfile", ["profileService", function(profileService){
	return({
		// detect current profile based on visibility
		link: function postLink(scope) {
			console.log("???");
			scope.getCurrentProfile = function() {
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
		},
		restrict: "E",
		template: "<span></span>",
		transclude: true
	});
}]);