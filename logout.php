<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/
	include("models/config.php");
	
	//Log the user out
	if(isUserLoggedIn()) $loggedInUser->userLogOut();

	include("models/clean_up.php");

	if($websiteUrl!="") header('Location:'.$websiteUrl); else header('Location: /');
	die;
?>


