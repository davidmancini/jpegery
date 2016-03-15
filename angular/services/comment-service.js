app.service('commentService', function($http){
	this.COMMENT_ENDPOINT = 'php/api/comment/';
	function getUrl() {
		return(COMMENT_ENDPOINT);
	}
	function getUrlForId(commentId) {
		return(getUrl() + commentId);
	}
	this.comment = function(commentData) {
		return ($http.post(this.COMMENT_ENDPOINT, commentData)
				.then(function(reply){
					return(reply.data);
				})
		);
	};
	this.all = function() {
		return($http.get(getUrl()))
			.then(function(reply){
				return(reply.data);
			})
	};
});