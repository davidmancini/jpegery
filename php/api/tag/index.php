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
$tagId = filter_input(INPUT_GET, "tagId", FILTER_VALIDATE_INT);
$tagName = filter_input(INPUT_GET, "tagName", FILTER_SANITIZE_STRING);

//handle REST calls for GET methods
if($method === "GET") {
	//set XSFR cookie
	setXsrfCookie("/");
	//get tag based on the given field
//	if(empty($id) === false) {
//		$tag = Tag::getTagById($pdo, $id);
//		if($tag !== null && $tag->getTagId() === $_SESSION["tag"]->getTagId()) {
//			$reply->data = $tag;
//		}
//	} else if(empty($tagName) === false) {
//		$tag = Tag::getTagByName($pdo, $id);
//		if($tag !== null && $tag->getTagName() === $_SESSION["tag"]->getTagName()) {
//			$reply->data = $tag;
//		}
//	} else if(empty($allTags) === false) {
//		$tag = Tag::getAllTags($pdo, $id);
//		if($tag !== null && $tag->getAllTags() === $_SESSION["tag"]->getAllTags()) {
//			$reply->data = $tag;
//		}
//
//	}

	if(empty($id) === false) {
		$reply->data = Tag::getTagById($pdo, $tagId);
	} else if(empty($city) === false) {
		$reply->data = Tag::getTagByName($pdo, $tagName)->toArray();
	} else if(empty($name) === false) {
		$reply->data = Tag::getAllTags($pdo, $tags)->toArray();

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
		if(empty($requestObject->tagId) === true) {
			throw(new InvalidArgumentException("Tag must have an ID", 405));
		}
		if(empty($requestObject->tagName) === true) {
			throw(new InvalidArgumentException("Tag must have a Name", 405));
		}

		if($method === "POST") {
			$tag = new Tag(null, $requestObject->tagName);
			$tag->insert($pdo);
			$reply->imageId = $tag->getTagId();
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