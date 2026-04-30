<?php
session_cache_limiter('nocache');
session_start();
include("scripts/settings.php");
logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
if(!isset($_GET['q'])){
	return;
}

$fees = calc_fees($_GET['class'],$_GET['sub1'],$_GET['sub2'],$_GET['sub3'],$_GET['gender'], $_GET['category']);

echo $fees;


?>