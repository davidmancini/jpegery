<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Jpegery\Vote;

/**
 * Controller/API for the Vote Class
 *
 * @author David Mancini <hello@davidmancini.xyz>
 **/

//Verify XSRF Challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//Grab MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");

	//Exception if the vote is null, or if the user is not logged in.
	if(empty($_SESSION["Profile"]) === true) {
		throw(new RuntimeException("You must be logged in to vote on an image.", 401));
	}

	//Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//Sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//Make sure ID is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}

	//Sanitize and trim fields
	//voteProfileId, voteImageId, voteValue
	$voteProfileId = filter_input(INPUT_GET, "voteProfileId", FILTER_VALIDATE_INT);
	$voteImageId = filter_input(INPUT_GET, "voteImageId", FILTER_VALIDATE_INT);
	$voteValue = filter_input(INPUT_GET, "voteValue", FILTER_VALIDATE_INT);

	//If the user is logged in, allow to POST and DELETE vote.
	if(empty($_SESSION["profile"]) !== false) {

		if($method === "POST" || $method === "DELETE") {
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//Ensure all fields are present
			if(empty($requestObject->voteProfileId) === true) {
				throw(new InvalidArgumentException("voteProfileId must be present", 405));
			}
			if(empty($requestObject->voteImageId) === true) {
				throw(new InvalidArgumentException("voteImageId must be present", 405));
			}
			if(empty($requestObject->voteValue) === true) {
				throw(new InvalidArgumentException("voteValue must be present", 405));
			}

			//Perform actual POST or DELETE
			if($method === "POST") {
				$vote = Vote::getVoteByVoteProfileIdAndVoteImageId($pdo, $id);
				$vote->insert($pdo);
				$reply->message = "Voted successfully.";

			} elseif($method === "DELETE") {
				$vote = Vote::getVoteByVoteProfileIdAndVoteImageId($pdo, $id);
				if($vote === null) {
					throw(new RuntimeException("Vote does not exist", 404));
				}
				$security = $vote->getVoteByVoteProfileIdAndVoteImageId($pdo, $id);
				if($security !== $_SESSION["profile"]->getProfileId()) {
					throw(new RuntimeException("You cannot delete a vote that isn't yours.", 403);
				}
				$vote->delete($pdo);
				$deletedObject = new stdClass();
				$deletedObject->(voteProfileId, $voteImageId) = $id;
				$reply->message = "Vote Successfully Deleted.";
			}
		}
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