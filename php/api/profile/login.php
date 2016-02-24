<?php

// verify user login options
$profile = null;
$profile = getProfileByProfileEmail($profileEmail);
if($profile === null) {
	$profile = getProfileByProfileHandle($profileHandle);
}
if($profile === null) {
	$profile = getProfileByProfilePhone($profilePhone);
}
// if login options cannot be verified throw exception
if($profile === null) {
	throw(new\IDTENTException("User name or password is incorrect"));
}
$password = bin2hex(openssl_random_pseudo_bytes(32));
$salt = bin2hex(openssl_random_pseudo_bytes(32));
$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
// if login credentials are valid; start session
if(isset($profile) === true && $hash->getProfileByProfileHash()) {
	session_start();
	session_regenerate_id(true);
} else {
	session_abort();
}
