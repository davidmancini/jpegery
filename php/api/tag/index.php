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

//determine which HTTP method was used
$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

//sanatize inputs and trim other fields
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

//make sure the ID is valid is valid for methods that require it
if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
	throw(new InvalidArgumentException("ID cannot be empty or negative"));
}


