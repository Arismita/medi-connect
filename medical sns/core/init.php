<?php 
	include 'database/connection.php';
	include 'php_classes/user.php';
	include 'php_classes/posts.php';
	include 'php_classes/follow.php';
	include 'php_classes/message.php';

	global $pdo;

	session_start();

	$getFromU = new User($pdo);
	$getFromP = new Posts($pdo);
	$getFromF = new Follow($pdo);
	$getFromM = new Message($pdo);

	define("BASE_URL","http://localhost/medical%20sns/")

?>