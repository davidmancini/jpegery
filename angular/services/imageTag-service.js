app.constant("IMAGETAG_ENDPOINT", "php/api/imageTag/");
app.service("imageTagService", function($http, IMAGETAG_ENDPOINT) {

	function getUrl() {
		return (IMAGETAG_ENDPOINT);
	}

	function getUrlForId(tagId) {
		return (getUrl() + tagId);
	}

	// get all tags
	this.all = function() {
		return ($http.get(getUrl()));
	};

	//get by tag id
	this.fetch = function(tagId) {
		return ($http.get(getUrlForId(tagId)));
	};

	//get by tagName
	this.fetchListing = function(tagName) {
		return ($http.get(getUrl() + "?imageTag=" + tagName));
	};

	//post
	this.create = function(tag) {
		return ($http.post(getUrl(), imageTag));
	};

});
