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

//Open session
	$requestContent = file_get_contents("php://input");
	$requestObject = json_encode($requestContent);

	$image = new Image (null, $_SESSION["profile"]->getProfileId(), "temporaryType", "temporaryName", $requestObject->text, null);
	$image->imageUpload();
//Connect to encrypted mySQL
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	$image->insert($pdo);

	$reply->data = $requestObject;

	$reply->message = "This worked. Or didn't and you somehow screwed it up so much you got a false positive. Either way, good job.";
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->data = $exception->getMessage();
}
//Echo the json, encode the $reply.
header("Content-type: application/json");
echo json_encode($reply);