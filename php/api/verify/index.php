
<?php
/**
 * Profile verification api
 *
 * @author Michael Kemm
 *
 */


//auto loads classes
require_once(dirname(dirname(dirname((__DIR__)))) . "/php/classes/autoload.php");
//security w/ NG in mind
require_once(dirname(dirname(dirname((__DIR__)))) . "/lib/xsrf.php");
//a security file that's on the server created by Dylan
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use \Edu\Cnm\Jpegery\Profile;



//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	$profileVerify = filter_input(INPUT_GET, "profileVerify", FILTER_SANITIZE_STRING);
	$profile = Profile::getProfileByProfileVerify($pdo, $profileVerify);
	// make sure the verification isn't empty
	if(empty($profile) === true || ($profile) === null) {
		throw (new InvalidArgumentException("Activation code has been activated or does not exist", 404));
	} else {
		$profileVerify->setProfileVerify();
		$profile->update($pdo);
		$reply->data = "Congratulations, your account has been activated!";
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->data = $exception->getMessage();
}

header("Content-type: application/json");

echo json_encode($reply);