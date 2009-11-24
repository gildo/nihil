<?php
/*
	Developed by: Fyskij
	Version 0.1
	License: GPLv3
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

                <?php include("header.php"); ?>
                <div style="text-align:center; padding-top:15px;">
<form name="change_group" action="add-groups.php?step=1" method="POST">
<b>Add group</b><br />
id => <br>          <input type="text" name="id" /><br />
group name =><br>  <input type="text" name="group" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
    </div>
</div>
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
	    print('Run Back! <a href="account.php"> My Account </a>'); 
}

include("models/clean_up.php");
?>
