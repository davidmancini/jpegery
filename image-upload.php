<?php
require_once (__DIR__) . "/php/classes/autoload.php";
require_once (__DIR__) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use \Edu\Cnm\Jpegery\Profile;
use \Edu\Cnm\Jpegery\Image;



$reply = new stdClass();
$reply->status = 200;

$requestContent = file_get_contents("php://input");
$requestObject = json_encode($_FILES);

$image = new Image (null, $_SESSION["profile"]->getProfileId(), "temporaryType", "temporaryName", "", null);
$image->insert($this->getPDO());
$image->imageUpload();

$reply->data = $requestObject;

$reply->message = "This worked. Or didn't and you somehow screwed it up so much you got a false positive. Either way, good job.";

//Echo the json, encode the $reply.
header("Content-type: application/json");
echo json_encode($reply);