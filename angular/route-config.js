app.config(function($routeProvider, $locationProvider) {
	$routeProvider
	// route for the home page
		.when('/', {
			controller: 'imageController',
			templateUrl: 'angular/pages/home.php'
		})

		// route for the user page
		.when('/user', {
			controller: 'userController',
			templateUrl: 'angular/pages/user.php'
		})

		// route for the image upload page
		.when('/upload', {
			controller: 'uploadController',
			templateUrl: 'angular/pages/upload.php'
		})

		// route for the settings page
		.when('/settings', {
			controller: 'settingsController',
			templateUrl: 'angular/pages/settings.php'
		})

		// route for the image page
		.when('/image', {
			controller: 'imageController',
			templateUrl: 'angular/pages/image.php'
		})

		// route for the login page
		.when('/login', {
			controller: 'loginController',
			templateUrl: 'angular/pages/login.php'
		})

		// route for the register page
		.when('/register', {
			controller: 'registerController',
			templateUrl: 'angular/pages/register.php'
		})

		// route for the help page
		.when('/help', {
			controller: 'helpController',
			templateUrl: 'angular/pages/help.php'
		})

		// route for the faq page
		.when('/faq', {
			controller: 'faqController',
			templateUrl: 'angular/pages/faq.php'
		})

		// route for the contact us page
		.when('/contact', {
			controller: 'contactController',
			templateUrl: 'angular/pages/contact.php'
		})

		// route for logout event
		.when('/logout', {
			controller: 'logoutController',
			template: 'angular/pages/logout.php' //A template or templateUrl is required by AngularJS, even if your controller always redirects.
		})

		.otherwise({
			redirectTo: "/"
		});

	//use the HTML5 History API
	$locationProvider.html5Mode(true);
});