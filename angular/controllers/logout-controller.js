function LogoutController($location) {
	Session.clear();
	$location.path('home');
}
