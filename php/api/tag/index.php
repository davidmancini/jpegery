<?php
/**
 * controller/api for the tag class
 *
 * @author Zach Leyba mtvzach@gmail.com
 */

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an emptry reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("etc/apache2/capstone-mysql/jpegerey.ini");
	// if the tag session is empty, the user is not logged in, throw an exception
	if(empty(_$SESSION["Tag"]) === true) {
		setXsrfCookie('/');
		throw new (new RuntimeException("You Must Sign In to Tag a Photo", 401));
	}

}