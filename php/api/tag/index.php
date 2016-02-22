<?php
/**
 * controller/api for the tag class
 *
 * @author Zach Leyba mtvzach@gmail.com
 */

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
	$pdo = connectToEncryptedMySQL("etc/apache2/capstone-mysql/jpegerey.ini");
	// if the tag session is empty, the user is not logged in, throw an exception
	if(empty(_$SESSION["Tag"]) === true) {
		setXsrfCookie('/');
		throw new (new RuntimeException("You Must Sign In to Tag a Photo", 401));
	}

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

//handle REST calls, while only allowing admin to access database-modifying methods
if($method === "GET") {
	//set XSFR cookie
	setXsrfCookie("/");
	//get tag based on the given field
	if(empty($id) === false) {
		$tag = Tag::getTagById($pdo, $id);
		if($tag !== null && $tag->getTagId() === $_SESSION["tag"]->getTagId()) {
			$reply->data = $tag;
		}
	} else if(empty($tagName) === false) {
		$tag = Tag::getTagByName($pdo, $id);
		if($tag !== null && $tag->getTagName() === $_SESSION["tag"]->getTagName()) {
			$reply->data = $tag;
		}

	}

}


