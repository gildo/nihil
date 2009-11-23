<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header('Location: login.php'); die; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome <?php echo $loggedInUser->display_username; ?></title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>


<!--

	This is an simple my account page. You can easily get access to
    user properties via $loggedInUser variable which is globally accessible.

-->


    <div id="regbox">
        
        <div style="text-align:center; padding-top:15px;">
        
        	Welcome to your account page <strong><?php echo $loggedInUser->display_username; ?></strong></p>
            
           
           	<p><a href="logout.php">Logout</a></p>
            <p><a href="change-password.php">Change password</a></p>
            <p><a href="update-contact-details.php">Update contact details</a></p>
  <?php
  $group = $loggedInUser->groupID();
  if ($group['Group_ID'] == 1 )  {
      print('<p><a href="add_groups.php">Add Groups</a></p>') ;
  }
  ?>
            <p>I am a <strong><?php  $group = $loggedInUser->groupID(); echo $group['Group_Name']; ?></strong></p>
          
            
            <p>You joined on <?php echo date("l \\t\h\e jS Y",$loggedInUser->signupTimeStamp()); ?> </p>
            
        </div>
        
    </div>


</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>
