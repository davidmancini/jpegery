app.constant("LOGIN_ENDPOINT", 'php/api/image/');

app.service('imageService', function($http, LOGIN_ENDPOINT){
	function getUrl() {
		return(LOGIN_ENDPOINT);
	}
	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}
	this.all = function() {
		return($http.get(getUrl()));
	};
});