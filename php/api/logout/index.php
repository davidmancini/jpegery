<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}$_SESSION = [];