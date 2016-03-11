app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	// route for the home page
		.when('/', {
			controller  : 'MainController',
			templateUrl : 'angular/pages/home.php'
		})

		// route for the user page
		.when('/user', {
			controller  : 'UserController',
			templateUrl : 'angular/pages/user.php'
		})

		// route for the image upload page
		.when('/upload', {
			controller  : 'UploadController',
			templateUrl : 'angular/pages/upload.php'
		})

		// route for the settings page
		.when('/settings', {
			controller  : 'SettingsController',
			templateUrl : 'angular/pages/settings.php'
		})

		// route for the image page
		.when('/image', {
			controller  : 'ImageController',
			templateUrl : 'angular/pages/image.php'
		})

		// route for the login page
		.when('/login', {
			controller  : 'LoginController',
			templateUrl : 'angular/pages/login.php'
		})

		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});