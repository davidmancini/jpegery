<?php
require_once (__DIR__) . "/php/classes/autoload.php";
require_once (__DIR__) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use \Edu\Cnm\Jpegery\Profile;
use \Edu\Cnm\Jpegery\Image;


if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$reply = new stdClass();
$reply->status = 200;

try {

	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");

//	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 7708);

////Open session
////	$requestContent = file_get_contents("php://input");
////	$requestObject = json_encode($requestContent);
	$caption = filter_input(INPUT_POST, "caption", FILTER_SANITIZE_STRING);
//	$reply->data = $caption;
//
	$image = new Image (null, $_SESSION["profile"]->getProfileId(), "temporaryType", "temporaryName", $caption, null);
	$image->imageUpload();
//Connect to encrypted mySQL
	$image->insert($pdo);
	$reply->message = "This worked. Or didn't and you somehow screwed it up so much you got a false positive. Either way, good job.";
//
//	$image->delete($pdo);
//	$profile->delete($pdo);

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->data = $exception->getMessage();
}
//Echo the json, encode the $reply.
header("Content-type: application/html");
echo json_encode($reply);