<html>
<head>
<title>UserCake - Database Setup</title>
<style type="text/css">
<!--
html, body {
	margin-top:15px;
	background: #e7e7e7;
	font:14px Verdana, Arial, Helvetica, sans-serif;
	color:#4d4948;
	text-align:center;
}
-->
</style>
</head>
<body>
<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/

//  Primitive installer
	
	include("../models/settings.php");
	
	//Dbal Support - Thanks phpBB ; )
	include('../models/classes/db/'.$dbtype.'.php');
	
	//Construct a db instance
	$db = new $sql_db();
	if(!$db->sql_connect($db_host, $db_user, $db_pass, $db_name, $db_port, false, false)) die("Unable to connect to the database");

	$db_issue = false;


	$groups_sql = "
		CREATE TABLE IF NOT EXISTS `".$db_table_prefix."Groups` (
  		`Group_ID` int(11) NOT NULL auto_increment,
  		`Group_Name` varchar(225) NOT NULL,
         PRIMARY KEY  (`Group_ID`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;
	";
	
	$group_entry = "
		INSERT INTO `".$db_table_prefix."Groups` (`Group_ID`, `Group_Name`) VALUES
		(1, 'God');
	";
	
	$users_sql = "
		 CREATE TABLE IF NOT EXISTS `".$db_table_prefix."Users` (
  		`User_ID` int(11) NOT NULL auto_increment,
  		`Username` varchar(150) NOT NULL,
  		`Username_Clean` varchar(150) NOT NULL,
    	`Password` varchar(225) NOT NULL,
  		`Email` varchar(150) NOT NULL,
  		`ActivationToken` varchar(225) NOT NULL,
        `LostPasswordRequest` int(1) NOT NULL default '0',
        `Active` int(1) NOT NULL,
        `Group_ID` int(11) NOT NULL,
        `SignUpDate` int(11) NOT NULL,
         `LastSignIn` int(11) NOT NULL,
         PRIMARY KEY  (`User_ID`)
		) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	";
	
	
	if($db->sql_query($groups_sql))
	{
		echo "<p>".$db_table_prefix."Groups table created.....</p>";
	}
	else
	{
		echo "<p>Error constructing ".$db_table_prefix."Groups table.</p><br /><br /> DBMS said: ";
		
		echo print_r($db->_sql_error());
		$db_issue = true;
	}
	
	if($db->sql_query($group_entry))
	{
		echo "<p>Inserted God group into ".$db_table_prefix."Groups table.....</p>";
	}
	else
	{
		echo "<p>Error constructing Groups table.</p><br /><br /> DBMS said: ";
		
		echo print_r($db->_sql_error());
		$db_issue = true;
	}
	
	if($db->sql_query($users_sql))
	{
		echo "<p>".$db_table_prefix."Users table created.....</p>";
	}
	else
	{
		echo "<p>Error constructing user table.</p><br /><br /> DBMS said: ";
		
		echo print_r($db->_sql_error());
		$db_issue = true;
	}
	
	
	if(!$db_issue)
	echo "<p><strong>Database setup complete, please delete the install folder.</strong></p>";
	

	include("../models/clean_up.php");
?>
</body>
</html>
