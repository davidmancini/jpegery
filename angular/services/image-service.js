app.service('imageService', function($http) {
	this.IMAGE_ENDPOINT = 'php/api/image/';

	function getUrl() {
		return (this.IMAGE_ENDPOINT);
	}

	function getUrlForId(imageId) {
		return (getUrl() + imageId);
	}

	this.all = function() {
		return ($http.get('php/api/image'));
	};
	this.fetchByImageId = function(imageId) {
		return ($http.get('php/api/image' + "?id=" + imageId));
	};
	this.fetchByProfileId = function(profileId) {
		return ($http.get('php/api/image/' + "?imageProfileId=" + profileId));
	};
});