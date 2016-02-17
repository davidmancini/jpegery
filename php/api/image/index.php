<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "../lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\Cnm\Jpegery\Image;

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

	//If Profile session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["profile"]) === true) {
		setXsrfCookie("/");
		throw (new RuntimeException("Please log in or sign up.", 401));
	}

	//Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//Sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//Make sure ID is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}

	//Sanitize and trim other fields
	//profileId, imageType, imageFileName, imageText, imageDate
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$imageType = filter_input(INPUT_GET, "imageType", FILTER_SANITIZE_STRING);
	$imageFileName = filter_input(INPUT_GET, "imageFileName", FILTER_SANITIZE_STRING);
	$imageText = filter_input(INPUT_GET, "imageText", FILTER_SANITIZE_STRING);
	$imageDate = filter_input(INPUT_GET, "imageDate", FILTER_SANITIZE_STRING);

	//Handle REST calls
	if($method === "GET") {
		//Set XSRF cookie
		setXsrfCookie("/");

		//Get Image based on given field
		if(empty($id) === false) {
			$image = Image::getImageByImageId($pdo, $id);
			if($image !== null) {
				$reply->data = $image;
			}
		} else if(empty($profileId) === false) {
			$image = Image::getImageByImageProfileId($pdo, $profileId);
			if($image !== null) {
				$reply->data = $image;
			}
		} else if(empty($imageFileName) === false) {
			$image = Image::getImageByImageFileName($pdo, $imageFileName);
			if($image !== null) {
				$reply->data = $image;
			}
		} else if(empty($imageText) === false) {
			$image = Image::getImageByImageText($pdo, $imageText);
			if($image !== null) {
				$reply->data = $image;
			}
		}
	}

	//If the user is logged in, allow to POST, PUT, and DELETE their own content.
	if(empty($_SESSION["profile"]) === false) {

		if($method === "PUT" || $method === "POST") {
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			//Ensure all fields are present
			if(empty($requestObject->profileId) === true) {
				throw(new InvalidArgumentException("Profile Id cannot be empty", 405));
			}
			if(empty($requestObject->imageType) === true) {
				throw(new InvalidArgumentException("Image Type cannot be empty", 405));
			}
			if(empty($requestObject->imageFileName) === true) {
				throw(new InvalidArgumentException("Image File Name cannot be empty", 405));
			} //Image Text CAN be empty
			if(empty($requestObject->imageDate) === true) {
				throw(new InvalidArgumentException("Image Date cannot be empty", 405));
			}

			//Perform actual POST or PUT
			if($method === "PUT") {
				//TODO: Continue here.
			}


		}
	}









//END MAIN TRY:
}