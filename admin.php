<?php
/*
	Developed by: Fyskij
*/
	include("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header('Location: login.php'); die; }
	$group = $loggedInUser->groupID();

    if ($group['Group_ID'] != 1 )
        { die; }
	//Construct a db instance
	$db = new $sql_db();
	if(!$db->sql_connect($db_host, $db_user, $db_pass, $db_name, $db_port, false, false)) die("Unable to connect to the database");
    $db_issue = false;
    if(!isset($_GET['step'])) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Contact Details</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>
<form name="change_group" action="admin.php?step=1" method="POST">
<b>Add group</b><br />
id:          <input type="text" name="id" /><br />
group name:  <input type="text" name="group" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
<?php
}
elseif($_GET['step'] == 1) {
$d = "
INSERT INTO `".$db_table_prefix."Groups` (`Group_ID`, `Group_Name`) VALUES
		('".addslashes($_POST['id'])."', '".addslashes($_POST["group"])."');
		";
		
	if($db->sql_query($d))
	{
		echo "<p>".$db_table_prefix."Group inserted .....</p>";
	}
	else
	{
		echo "<p>Error constructing ".$db_table_prefix."Groups table.</p><br /><br /> DBMS said: ";
		
		echo print_r($db->_sql_error());
		$db_issue = true;
	}
			if(!$db_issue)
	echo "yeah";
		}
include("models/clean_up.php");
?>
