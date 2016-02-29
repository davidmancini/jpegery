<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * controller/api for the tag class
 *
 * @author Zach Leyba mtvzach@gmail.com
 */
use \Edu\Cnm\Jpegery\Tag;

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an emptry reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	// if the tag session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["Profile"]) === true) {
		setXsrfCookie('/');
		throw(new RuntimeException("You Must Sign In to Tag a Photo", 401));
	}

	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

//sanatize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

//make sure the ID is valid is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative"));
	}

//sanitize and trim other fields
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);
	$tagId = filter_input(INPUT_GET, "tagId", FILTER_VALIDATE_INT);


//handle REST calls for GET methods
	if($method === "GET") {
		//set XSFR cookie
		setXsrfCookie("/");
		//get tag based on the given field
		if(empty($id) === false) {
			$tag = Tag::getImageTagByImageId($pdo, $id);
			if($tag !== null && $tag->getImageId() === $_SESSION["tag"]->getImageId()) {
				$reply->data = $tag;
			}
		}
	}

	//handle REST calls for PUT methods

//If the user is logged in, allow to POST their own tag.
	if(empty($_SESSION["profile"]) !== false) {

		if($method === "POST") {
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

		}
		//ensure all fields are present
		if(empty($requestObject->imageId) === true) {
			throw(new InvalidArgumentException("Image must have an ID", 405));
		}
		if(empty($requestObject->tagId) === true) {
			throw(new InvalidArgumentException("Tag must have an ID", 405));
		}

		if($method === "POST") {
			$tag = new Tag($requestObject->imageId, $requestObject->tagId);
			$tag->insert($pdo);
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




