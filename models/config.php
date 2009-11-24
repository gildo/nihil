<?php
	include("settings.php");
	
	//Dbal Support - Thanks phpBB ; )
	include('models/classes/db/'.$dbtype.'.php');
	
	//Construct a db instance
	$db = new $sql_db();
	if(!$db->sql_connect($db_host, $db_user, $db_pass, $db_name, $db_port, false, false)) die("Unable to connect to the database");

	//Include classes
	include('models/classes/class_newuser.php');
	include('models/classes/class_newmail.php');
	include('models/classes/class_loggedinuser.php');
	
	//Include Functions
	include('models/functions/user-funcs.php');
	include('models/functions/general-funcs.php');


	session_start();
	
	//Global User Object Var
	//loggedInUser can be used globally if constructed
	if(isset($_SESSION['userCakeUser']) && is_object($_SESSION['userCakeUser'])) $loggedInUser = $_SESSION['userCakeUser']; else $loggedInUser = NULL;	
?>
