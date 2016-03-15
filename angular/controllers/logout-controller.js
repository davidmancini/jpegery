app.controller('contactController', function($scope) {
	function LogoutController($location) {
		Session.clear();
		$location.path('home');
	}
});