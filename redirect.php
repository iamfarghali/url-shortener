<?php
require_once "classes/Shortener.php";
$sh = new Shortener;
if ( isset($_GET['code']) ) {
	$url = $sh->getURL($_GET['code']);
	header("Location:$url");
	die;
}
header("Location:index.php");