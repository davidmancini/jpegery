<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use \Edu\Cnm\Jpegery\Profile;

/**
 * login api
 *
 * @author Michael Kemm
 */

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//Create an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
// verify user login options
//	$pdo //Connect to mysql encrypted;

	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);
//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");

	try {
		$profile = Profile::getProfileByProfileEmail($pdo, $requestObject->emailHandlePhone);
	} catch(Exception $exception) {
		$profile = null;
	}
	if($profile === null) {
		$profile = Profile::getProfileByProfileHandle($pdo, $requestObject->emailHandlePhone);
	}
	if($profile === null) {
		$profile = Profile::getProfileByProfilePhone($pdo, $requestObject->emailHandlePhone);
	}

// if login options cannot be verified throw exception
	if($profile === null) {
		throw(new\RuntimeException("User name or password is incorrect"));
	}
	$hash = hash_pbkdf2("sha512", $requestObject->password, $profile->getProfileSalt(), 262144);
// if login credentials are valid; start session
	if((empty($profile) === false) && ($hash === $profile->getProfileHash())) {
		//Put the profile in the session.
		$reply->message = "Welcome to jpegery!";
		$_SESSION["profile"] = $profile;
	} else {
		throw(new\RuntimeException("User name or password is incorrect"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTrace();
}
//Echo the json, encode the $reply.
echo json_encode($reply);