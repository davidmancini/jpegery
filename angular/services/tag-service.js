app.constant("TAG_ENDPOINT", "php/api/tag/");
app.service("tagService", function($http, TAG_ENDPOINT) {

	function getUrl() {
		return (TAG_ENDPOINT);
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
		return ($http.get(getUrl() + "?tag=" + tagName));
	};

	//post
	this.create = function(tag) {
		return ($http.post(getUrl(), tag));
	};

});

