app.service('commentService', function($http){
	this.COMMENT_ENDPOINT = 'php/api/comment/';

	this.comment = function(commentData) {
		return ($http.post(this.COMMENT_ENDPOINT, commentData)
				.then(function(reply){
					return(reply.data);
				})
		);
	}
});