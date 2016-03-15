app.service('commentService', function($http){
	this.LOGOUT_ENDPOINT = 'php/api/comment/';
	function getUrl() {
		return(LOGOUT_ENDPOINT);
	}
	function getUrlForId(commentId) {
		return(getUrl() + commentId);
	}
	this.comment = function(commentData) {
		return ($http.post(this.LOGOUT_ENDPOINT, commentData)
				.then(function(reply){
					return(reply.data);
				})
		);
	};
	this.all = function() {
		return($http.get('php/api/comment/'));
	};
	this.fetchByImageId = function(imgId) {
		return($http.get('php/api/comment/' + "?commentImageId=" + imgId));
	};
});