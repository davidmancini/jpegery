app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	// route for the home page
		.when('/', {
			controller  : 'mainController',
			templateUrl : 'angular/pages/home.php'
		})

		// route for the about page
		.when('/user', {
			controller  : 'userController',
			templateUrl : 'angular/pages/user.php'
		})

		// route for the sign up page
		.when('/upload', {
			controller  : 'uploadController',
			templateUrl : 'angular/pages/upload.php'
		})

		// route for the about page
		.when('/settings', {
			controller  : 'settingsController',
			templateUrl : 'angular/pages/settings.php'
		})

		// route for the about page
		.when('/image', {
			controller  : 'imageController',
			templateUrl : 'angular/pages/image.php'
		})

		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});