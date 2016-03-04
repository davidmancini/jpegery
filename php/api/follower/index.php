<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use \Edu\Cnm\Jpegery\Follower;
use \Edu\Cnm\Jpegery\Profile;
/**
 * Controller/API for the Comment class
 *
 * @author Michael kemm
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

	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	//if the profile session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["profile"]) === true) {
		setXsrfCookie("/");
		throw(new RuntimeException("Please log-in or sign up", 401));
	}
	//Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//Sanitize inputs
	$followerFollowerId = filter_input(INPUT_GET, "$followerFollowerId", FILTER_VALIDATE_INT);
	//Sanitize inputs
	$followerFollowedId = filter_input(INPUT_GET, "$followerFollowedId", FILTER_VALIDATE_INT);
	//Make sure the id matches what the relevant method requires
	if($method === "DELETE" && ((empty($followerFollowerId) === true || $followerFollowerId < 0) || (empty($followerFollowedId) === true || $followerFollowedId < 0))) {
		throw(new \InvalidArgumentException("Improper ID", 405));
	}
	if($method === "GET") {
		//Set an XSRF cookie on 'get' requests
		setXsrfCookie("/");

		//Get the listing based on the current field
		if((empty($followerFollowerId) === false) && (empty($followerFollowedId) === false)) {
			$reply->data = Follower::getFollowerByFollowerIdAndFollowedId($pdo, $followerFollowerId, $followerFollowedId);
		} elseif(empty($followerFollowerId) === false) {
			$reply->data = Follower::getFollowerByFollowerId($pdo, $followerFollowerId)->toArray();
		} elseif(empty($followerFollowedId) === false) {
			$reply->data = Follower::getFollowerByFollowedId($pdo, $followerFollowedId)->toArray();
		}

		if(empty($_SESSION["profile"]) === false) {
			if($method === "POST") {
				verifyXsrf();
				$requestContent = file_get_contents("php://input");
				$requestObject = json_decode($requestContent);

				$follow = new Follower($requestObject->followerFollowerId, $requestObject->followerFollowedId);
				$follow->insert($pdo);
				$tempName = Profile::getProfilebyProfileId($pdo, $requestObject->followerFollowedId)->getProfileHandle();
				$reply->message = "You are now following " . $tempName;
			} elseif($method === "DELETE") {
				$follower = Follower::getFollowerByFollowerIdAndFollowedId($pdo, $followerFollowerId, $followerFollowedId);
				if($follower === null) {
					throw(new \RuntimeException("relationship does not exist", 404));
				}
				if($_SESSION["profile"]->getProfileId() !== $follower->getFollowerFollowerId()) {
					throw(new \RuntimeException("Only the follower can stop following."));
				}
				$tempName = Profile::getProfilebyProfileId($pdo, $follower->getFollowerFollowedId())->getProfileHandle();
				$follower->delete($pdo);
				$deletedObject = new stdClass();
				$deletedObject->followerFollowerId = $followerFollowerId;
				$deletedObject->followerFollowedId = $followerFollowedId;
				$reply->message = "You are no longer following " . $tempName;
			}
		} elseif((empty($method) === false) && ($method !== "GET")) {
			//If a non-admin attempted to access anything other than GET, throw an error at them
			throw(new \RuntimeException("Only administrators are allowed to modify entries", 401));
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