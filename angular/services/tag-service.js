app.constant("TAG_ENDPOINT", "php/api/tag/");
app.service("tagService", function($http, TAG_ENDPOINT) {
	function getUrl() {
		return (TAG_ENDPOINT);
	}

	function getUrlForId(tagId) {
		return (getUrl() + tagId);
	}

	this.all = function() {
		return ($http.get(getUrl()));
	};

	this.fetch = function(tagId) {
		return ($http.get(getUrlForId(tagId)));
	};


	this.create = function(tag) {
		return ($http.post(getUrl(), tag));
	};

});

