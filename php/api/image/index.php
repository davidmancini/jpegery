<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "../lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * Controller/API for Image Class
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

	//TODO: Verify "profile" is correct here.
	//If Profile session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["profile"]) === true ) {
		setXsrfCookie("/");
		throw (new RuntimeException("Please log in or sign up.", 401));
	}

	//Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//Sanitize inputs
	$imageId = filter_input(INPUT_GET, "imageId", FILTER_VALIDATE_INT);

	//Make sure ID is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $imageId < 0)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}

	//Sanitize and trim other fields
	//profileId, imageType, imageFileName, imageText, imageDate
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);
	$imageFileName = filter_input(INPUT_GET, "imageFileName", FILTER_SANITIZE_STRING);
	$imageText = filter_input(INPUT_GET, "imageText", FILTER_SANITIZE_STRING);
	$profileId = filter_input(INPUT_GET, "imageDate", FILTER_SANITIZE_STRING);









}