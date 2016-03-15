app.service('imageService', function($http){
	this.IMAGE_ENDPOINT = 'php/api/image/';

	function getUrl() {
		return(IMAGE_ENDPOINT);
	}
	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}
	this.all = function() {
		return($http.get(getUrl()))
			.then(function(reply){
				return(reply.data);
			})
	};
});