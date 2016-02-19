<?php
require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(__DIR__)) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "/vendor/autoload.php");

/**
 * api for profile class
 * @author Michael Kemm
 */

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;


try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
	//if the profile session is empty, the user is not logged in, throw an exception
	if(empty($_SESSION["profile"]) === true) {
		setXsrfCookie("/");
		throw(new RuntimeException("Please log-in or sign up", 401));
	}
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize inputs
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	//sanitize and trim other fields
	$profileId = filter_input(INPUT_GET, "profileId", FILTER_VALIDATE_INT);
	$profileAdmin = filter_input(INPUT_GET, "admin", FILTER_VALIDATE_BOOLEAN);
	//$profileCreateDate = filter_input(INPUT_GET, "profileCreateDate", json_last_error);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_EMAIL);
	$profilePhone = filter_input(INPUT_GET, "profilePhone", FILTER_SANITIZE_STRING);
	$emailActivation = filter_input(INPUT_GET, "emailActivation", FILTER_SANITIZE_STRING);
	$current = filter_input(INPUT_GET, "current", FILTER_SANITIZE_STRING);
	//handle REST calls, while only allowing administrators to access database-modifying methods
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");
		//get the volunteer based on the given field
		if(empty($id) === false) {
			$volunteer = Volunteer::getVolunteerByVolId($pdo, $id);
			if($volunteer !== null && $volunteer->getOrgId() === $_SESSION["volunteer"]->getOrgId()) {
				$reply->data = $volunteer;
			}
		} else if(empty($email) === false) {
			$volunteer = Volunteer::getVolunteerByVolEmail($pdo, $email);
			if($volunteer !== null && $volunteer->getOrgId() === $_SESSION["volunteer"]->getOrgId()) {
				$reply->data = $volunteer;
			}
		} else if(empty($admin) === false) {
			$volunteer = Volunteer::getVolunteerByVolIsAdmin($pdo, $admin);
			if($volunteer !== null && $volunteer->getOrgId() === $_SESSION["volunteer"]->getOrgId()) {
				$reply->data = $volunteer;
			}
		} else if(empty($phone) === false) {
			$volunteer = Volunteer::getVolunteerByVolPhone($pdo, $phone);
			if($volunteer !== null && $volunteer->getOrgId() === $_SESSION["volunteer"]->getOrgId()) {
			}
			$reply->data = $volunteer;
		} else if(empty($emailActivation) === false) {
			$volunteer = Volunteer::getVolunteerByVolEmailActivation($pdo, $emailActivation);
			if($volunteer !== null && $volunteer->getOrgId() === $_SESSION["volunteer"]->getOrgId()) {
				$reply->data = $volunteer;
			}
		} else if(empty($current) === false) {
			$volunteer = Volunteer::getVolunteerByVolId($pdo, $_SESSION["volunteer"]->getVolId());
			$reply->data = $volunteer;
		} else {
			$reply->data = Volunteer::getVolunteerByOrgId($pdo, $_SESSION["volunteer"]->getOrgId())->toArray();
		}
	}


}
