<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use \Edu\Cnm\Jpegery\Comment;

/**
 * Controller/API for the Comment class
 *
 * @author Jacob Findley <jfindley2@cnm.edu>
 */

//Verify the XSRF challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Create an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//Grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	if(empty($_SESSION["profile"]) === true) {
		setXsrfCookie("/");
		throw(new \RuntimeException("Please log in or sign up", 401));
	}
	//Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//Sanitize the inputs
	//Note: Could this be unnecessary? What with type-hinting and all? Investigate further.
	$commentId = filter_input(INPUT_GET, "commentId", FILTER_VALIDATE_INT);
	//Make sure the id matches what the relevant method requires
	if(($method === "DELETE" || $method === "PUT") && (empty($commentId) === true || $commentId < 0)) {
		throw(new \InvalidArgumentException("Improper ID", 405));
	}

	//Sanitize and trim the other fields.
	$commentImageId = filter_input(INPUT_GET, "commentImageId", FILTER_VALIDATE_INT);
	$commentProfileId = filter_input(INPUT_GET, "commentProfileId", FILTER_VALIDATE_INT);
	$commentDate = filter_input(INPUT_GET, "commentDate", FILTER_SANITIZE_STRING);
	$commentText = filter_input(INPUT_GET, "commentText", FILTER_SANITIZE_STRING);

	if($method === "GET") {
		//Set an XSRF cookie on 'get' requests
		setXsrfCookie("/");

		//Get the listing based on the current field
		if(empty($commentId) === false) {
			$reply->data = Comment::getCommentByCommentId($pdo, $commentId);
		} elseif (empty($commentImageId) === false) {
			$reply->data = Comment::getCommentByImageId($pdo, $commentImageId)->toArray();
		} elseif (empty($commentProfileId) === false) {
			$reply->data = Comment::getCommentByProfileId($pdo, $commentProfileId)->toArray();
		} elseif (empty($commentText) === false) {
			$reply->data = Comment::getCommentByCommentContent($pdo, $commentText)->toArray();
		}

	}
	//Verify that the object is not empty
	if(empty($_SESSION["profile"]) === false) {
		if($method === "PUT" || $method === "POST") {
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//Ensure that all fields are present.
			if(empty ($requestObject->commentImageId) === true) {
				throw(new \InvalidArgumentException("Comment Image must exist", 405));
			}
			if(empty ($requestObject->commentProfileId) === true) {
				throw(new \InvalidArgumentException("Comment Profile must exist", 405));
			}

			if(empty($requestObject->commentText) === true) {
				throw(new \InvalidArgumentException("Comment text can not be empty", 405));
			}
			if (empty($requestObject->commentDate) === true) {
				$requestObject->commentDate = null;
			}

			//Attempt PUT
			if($method === "PUT") {
				$comment = Comment::getCommentByCommentId($pdo, $commentId);
				if ($comment === null) {
					throw(new \RuntimeException("Comment does not exist", 404));
				}
				if($_SESSION["profile"]->getProfileId() !== $comment->getCommentProfileId()) {
					throw(new \RuntimeException("Only the author of the comment can edit it."));
				}
				$comment->setCommentText($requestObject->commentText);
				$comment->setCommentDate($requestObject->commentDate);

				//Update the Comment table
				$comment->update($pdo);

				$reply->message = "Comment updated";
			} elseif($method === "POST") {
				//TODO: Figure out what's going on here. Should I do the $_SESSION["image"]->getImageId() thing?
				$comment = new Comment(null,  $requestObject->commentImageId, $requestObject->commentProfileId, $requestObject->commentDate, $requestObject->commentText);
				$comment->insert($pdo);
				$reply->message = "Comment created";
			}
		} elseif ($method === "DELETE") {
			$comment = Comment::getCommentByCommentId($pdo, $commentId);
			if($comment === null) {
				throw(new \RuntimeException("Comment does not exist", 404));
			}
			if($_SESSION["profile"]->getProfileId() !== $comment->getCommentProfileId()) {
				throw(new \RuntimeException("Only the author of the comment can delete it."));
			}
			$comment->delete($pdo);
			$deletedObject = new stdClass();
			$deletedObject->commentId = $commentId;
			$reply->message = "Listing deleted";
		}
	} elseif ((empty($method) === false) && ($method !== "GET")) {
		//If a non-admin attempted to access anything other than GET, throw an error at them
		throw(new \RuntimeException("Only administrators are allowed to modify entries", 401));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);