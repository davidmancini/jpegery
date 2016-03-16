app.constant("PROFILE_ENDPOINT", "php/api/profile/");
app.service("profileService", function($http, PROFILE_ENDPOINT) {
	function getUrl() {
		return(PROFILE_ENDPOINT);
	}

	function getUrlForId(profileId) {
		return(getUrl() + profileId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(profileId) {
		return($http.get(getUrlForId(profileId)));
	};

	this.fetchCurrent = function(current) {
		return($http.get(getUrl() + "?current=" + current));
	};

	this.create = function(profile) {
		return($http.post('php/api/profile/', profile));
	};

	this.update = function(profileId, profile) {
		return($http.put(getUrlForId(profileId), profile));
	};

	this.destroy = function(profileId) {
		return($http.delete(getUrlForId(profileId)));
	};
});