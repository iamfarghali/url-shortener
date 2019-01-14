<?php

// start session
session_start();
// require necessary files
require_once "classes/Shortener.php";

$sh = new Shortener;

if (isset($_POST['url'])) {
	$url = $_POST['url'];
	$sh->url = $url;
	if ( $code = $sh->getCode() ) {
		$_SESSION['success'] = "Generated! Your Short URL is: <a href=redirect.php?code=".$code.">".$sh->prepareURL($code)."</a>";
	} else {
		// error message
		$_SESSION['error'] = "Something is wrong, Plase try later :)";
	}
	header('Location:index.php');
}