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
	$profileAdmin = filter_input(INPUT_GET, "profileAdmin", FILTER_VALIDATE_BOOLEAN);
	$profileCreateDate = filter_input(INPUT_GET, "profileCreateDate", FILTER_SANITIZE_STRING);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_EMAIL);
	$profileHandle = filter_input(INPUT_GET, "profileHandle", FILTER_SANITIZE_STRING);
	$profileHash = filter_input(INPUT_GET, "profileHash", FILTER_SANITIZE_STRING);
	$profileImageId = filter_input(INPUT_GET, "profileImageId", FILTER_VALIDATE_INT);
	$profileNameF = filter_input(INPUT_GET, "profileNameF", FILTER_SANITIZE_STRING);
	$profileNameL = filter_input(INPUT_GET, "profileNameL", FILTER_SANITIZE_STRING);
	$profilePhone = filter_input(INPUT_GET, "profilePhone", FILTER_SANITIZE_STRING);
	$profileSalt = filter_input(INPUT_GET, "profileSalt", FILTER_SANITIZE_EMAIL);
	$profileVerify = filter_input(INPUT_GET, "profileVerify", FILTER_SANITIZE_STRING);
	$current = filter_input(INPUT_GET, "current", FILTER_SANITIZE_STRING);

	//handle REST calls
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie("/");
		//get the volunteer based on the given field
		if(empty($id) === false) {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
				$reply->data = $profile;
			}
		} else if(empty($profileEmail) === false) {
			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
				$reply->data = $profile;

			} else if(empty($profileHandle) === false) {
				$profile = Profile::getProfileByProfileHandle($pdo, $profileHandle);
				if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
					$reply->data = $profile;
				}
			} else if(empty($profileNameF) === false) {
				$profile = Profile::getProfileByProfileNameF($pdo, $profileNameF);
				if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
					$reply->data = $profile;
				}
			} else if(empty($profileNameL) === false) {
				$profile = Profile::getProfileByProfileNameL($pdo, $profileNameL);
				if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
					$reply->data = $profile;
				}
				$reply->data = $volunteer;
			} else if(empty($profilePhone) === false) {
				$profile = Profile::getProfileByProfilePhone($pdo, $profilePhone);
				if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
					$reply->data = $profile;

				} else if(empty($profileVerify) === false) {
					$profile = Profile::getProfileByProfileVerify($pdo, $profileVerify);
					if($profile !== null && $profile->getProfileId() === $_SESSION["profile"]->getProfileId()) {
						$reply->data = $profile;
					}
				} else if(empty($current) === false) {
					$profile = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getProfileId());
					$reply->data = $profile;
				} else {
					$reply->data = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getOrgId())->toArray();
				}
			}


		}


		// make sure all fields are present, in order to prevent database issues
		if(empty($requestObject->profileEmail) === true) {
			throw(new InvalidArgumentException ("email is a required field", 406));
		}
		if(empty($requestObject->profileNameF) === true) {
			throw(new InvalidArgumentException ("first name is a required field", 406));
		}
		if(empty($requestObject->profileNameL) === true) {
			throw(new InvalidArgumentException ("last name is a required field", 406));
		}
		if(empty($requestObject->profilePhone) === true) {
			throw(new InvalidArgumentException ("phone number is a required field", 406));
		}

		// put, post or delete
		if($method === "PUT") {
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw(new RuntimeException("profile does not exist", 404));
			}
			//make sure the user is only attempting to edit their own profile
			//if not throw an exception
			$security = Profile::getProfileByProfileId($pdo, $_SESSION["profile"]->getProfileId());
			if(($security->getProfileId() === false) && ($_SESSION["profile"]->getProfileId() !== $profile->getProfileId())) {
				$_SESSION["profile"]->setProfileId(false);
				throw(new RunTimeException("You can only modify your own profile", 403));
			}
			$volunteer->setVolEmail($requestObject->volEmail);
			$volunteer->setVolFirstName($requestObject->volFirstName);
			$volunteer->setVolLastName($requestObject->volLastName);
			$volunteer->setVolPhone($requestObject->volPhone);
			//if there's a password, hash it, and set it
			if($requestObject->volPassword !== null) {
				$hash = hash_pbkdf2("sha512", $requestObject->volPassword, $volunteer->getVolSalt(), 262144, 128);
				$volunteer->setVolHash($hash);
			}
			$volunteer->update($pdo);
			//kill the temporary admin access, if they're not supposed to have it
			//check to see if the password is not null; this means it's a regular volunteer changing their password and not an admin
			//prevents admins from being logged out for editing their regular volunteers
			if(($volunteer->getVolIsAdmin() === false) && ($requestObject->volPassword !== null)) {
				$_SESSION["volunteer"]->setVolIsAdmin(false);
			}
			$reply->message = "Volunteer updated OK";
		} elseif($method === "POST") {
			//if they shouldn't have admin access to this method, kill the temp access and boot them
			//check by retrieving their original volunteer from the DB and checking
			$security = Volunteer::getVolunteerByVolId($pdo, $_SESSION["volunteer"]->getVolId());
			if($security->getVolIsAdmin() === false) {
				$_SESSION["volunteer"]->setVolIsAdmin(false);
				throw(new RunTimeException("Access Denied", 403));
			}
			$password = bin2hex(openssl_random_pseudo_bytes(32));
			$salt = bin2hex(openssl_random_pseudo_bytes(32));
			$hash = hash_pbkdf2("sha512", $password, $salt, 262144, 128);
			$emailActivation = bin2hex(openssl_random_pseudo_bytes(8));
			//create new volunteer
			$volunteer = new Volunteer($id, $_SESSION["volunteer"]->getOrgId(), $requestObject->volEmail, $emailActivation,
				$requestObject->volFirstName, $hash, false, $requestObject->volLastName, $requestObject->volPhone, $salt);
			$volunteer->insert($pdo);
			$reply->message = "Volunteer created OK";
			//compose and send the email for confirmation and setting a new password
			// create Swift message
			$swiftMessage = Swift_Message::newInstance();
			// attach the sender to the message
			// this takes the form of an associative array where the Email is the key for the real name
			$swiftMessage->setFrom(["breadbasketapp@gmail.com" => "Bread Basket"]);
			/**
			 * attach the recipients to the message
			 * notice this an array that can include or omit the the recipient's real name
			 * use the recipients' real name where possible; this reduces the probability of the Email being marked as spam
			 **/
			$recipients = [$requestObject->volEmail];
			$swiftMessage->setTo($recipients);
			// attach the subject line to the message
			$swiftMessage->setSubject("Please confirm your Bread Basket account");
			/**
			 * attach the actual message to the message
			 * here, we set two versions of the message: the HTML formatted message and a special filter_var()ed
			 * version of the message that generates a plain text version of the HTML content
			 * notice one tactic used is to display the entire $confirmLink to plain text; this lets users
			 * who aren't viewing HTML content in Emails still access your links
			 **/
			// building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
			$basePath = $_SERVER["SCRIPT_NAME"];
			for($i = 0; $i < 3; $i++) {
				$lastSlash = strrpos($basePath, "/");
				$basePath = substr($basePath, 0, $lastSlash);
			}
			$urlglue = $basePath . "/controllers/email-confirmation?emailActivation=" . $volunteer->getVolEmailActivation();
			$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;
			$message = <<< EOF
<h1>You've been registered for the Bread Basket program!</h1>
<p>Visit the following URL to set a new password and complete the registration process: </p>
<a href="$confirmLink">$confirmLink</a></p>
EOF;
			$swiftMessage->setBody($message, "text/html");
			$swiftMessage->addPart(html_entity_decode(filter_var($message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES)), "text/plain");
			/**
			 * send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM
			 * this default may or may not be available on all web hosts; consult their documentation/support for details
			 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling
			 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
			 **/
			$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
			$mailer = Swift_Mailer::newInstance($smtp);
			$numSent = $mailer->send($swiftMessage, $failedRecipients);
			/**
			 * the send method returns the number of recipients that accepted the Email
			 * so, if the number attempted is not the number accepted, this is an Exception
			 **/
			if($numSent !== count($recipients)) {
				// the $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
				throw(new RuntimeException("unable to send email", 404));
			}
		}
	} elseif($method === "DELETE") {
		verifyXsrf();
		//if they shouldn't have admin access to this method, kill the temp access and boot them
		//check by retrieving their original volunteer from the DB and checking
		$security = Volunteer::getVolunteerByVolId($pdo, $_SESSION["volunteer"]->getVolId());
		if($security->getVolIsAdmin() === false) {
			$_SESSION["volunteer"]->setVolIsAdmin(false);
			throw(new RunTimeException("Access Denied", 403));
		}
		$volunteer = Volunteer::getVolunteerByVolId($pdo, $id);
		if($volunteer === null) {
			throw(new RangeException("Volunteer does not exist", 404));
		}
		$volunteer->delete($pdo);
		$deletedObject = new stdClass();
		$deletedObject->volunteerId = $id;
		$reply->message = "Volunteer deleted OK";
	}
} else {
	//if not an admin, and attempting a method other than get, throw an exception
	if((empty($method) === false) && ($method !== "GET")) {
		throw(new RuntimeException("Only administrators are allowed to modify entries", 401));
	}
}
	//send exception back to the caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);
