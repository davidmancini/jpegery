app.service('LoginService', function($http) {
	this.LOGIN_ENDPOINT = "php/api/login/index.php";

	this.login = function(loginData) {
		console.log(loginData);
		return ($http.post(this.LOGIN_ENDPOINT, loginData)
				.then(function(reply){
					console.log(reply.data);
					return(reply.data);
				})
		);
	};
});