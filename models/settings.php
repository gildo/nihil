<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/

	//General Settings
	//--------------------------------------------------------------------------
	
	//Comment, delete or set to NULL this var
    $UNCONFIGURED = TRUE;
	
	//Database Information
	$dbtype = "mysql"; 
	$db_host = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "min";
	$db_port = "";
	$db_table_prefix = "min_";
	
	//Generic website variables
	$websiteName = "";
	$websiteUrl = "";

	//Do you wish usercake to send out emails for confirmation of registration?
	//We recommend this be set to true to prevent spam bots.
	//False = instant activation
	$emailActivation = false;
	
	//Tagged onto our outgoing emails
	$emailAddress = "noreply@iloveusercake.com";
	
	//Date format used on email's date hook
	$emailDate = date("l \\t\h\e jS");
	
	//Directory where txt files are stored for the email templates.
	$mail_templates_dir = "/var/www/localhost/htdocs/models/mail-templates/";
	
	$default_hooks = array("#WEBSITENAME#","#WEBSITEURL#","#DATE#");
	
	
	//Display more explicit error messages?
	$debug_mode = true;
	
	
	//---------------------------------------------------------------------------
?>
