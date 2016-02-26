<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use \Edu\Cnm\Jpegery\Profile;

/**
 * login api
 * @author Michael Kemm
 */

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
try {
// verify user login options
//	$pdo //Connect to mysql encrypted;

	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	$profile = Profile::getProfileByProfileEmail($pdo, $requestObject->emailHandlePhone);
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
		//Put a flowery congratulation message saying that they've logged in.
	} else {
		//Throw an exception, saying that something is wrong.
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
//Echo the json, encode the $reply.