<?php

require_once dirname(dirname(__DIR__)) . "/classes/autoload.php";
require_once dirname(dirname(dirname(__DIR__))) . "/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use \Edu\Cnm\Jpegery\Profile;

/**
 * verification api
 * @author Michael Kemm
 */

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

try {

	if ($profileVerify === $profile->getProfileVerify()) {


	}
}