<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/
	include("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is not logged in
	if(!isUserLoggedIn()) { header('Location: login.php'); die; }
?>

<?php
	/* 
		Below is a very simple example of how to process a login request.
		Some simple validation (ideally more is needed).
	*/

//Forms posted
if($_POST)
{
		$errors = array();
		$password = $_POST["password"];
		$password_new = $_POST["passwordc"];
		$password_confirm = $_POST["passwordcheck"];
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($password) == "")
		{
			$errors[] = "Current password is required.";
		}
		if(trim($password_new) == "")
		{
			$errors[] = "New password is required.";
		}
		else if(minMaxRange(8,50,$password_new))
		{	
			$errors[] = "New password must be no fewer than 8 characters or greater than 50.";
		}
		else if($password_new != $password_confirm)
		{
			$errors[] = "Password's entered do not match!";
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//Confirm the hash's match before updating a users password
			$entered_pass = generateHash($password,$loggedInUser->hash_pw);
			
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
		
			if($entered_pass != $loggedInUser->hash_pw)
			{
				//No match
				$errors[] = "Current password doesn't match the one we have one record.";
			}
			else if($entered_pass_new == $loggedInUser->hash_pw)
			{
				//Don't update, this fool is trying to update with the same password ¬¬
				$errors[] = "Nothing to update.";
			}
			else
			{
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Password</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>
<?php
if($_POST)
{
	if(count($errors) > 0){
	$list="";  
	   foreach($errors as $issue) $list.="<li>".$issue."</li>";
?> 
 
<div id="errors">
    <ol> 
    <?php echo $list; ?>
    </ol>
</div>
 
<?php } else { ?>
<div id="success">
	<p>You have successfully updated your password.</p>
</div>
<?php } } ?>

<div id="regbox">
	
    <div style="text-align:center; padding-top:15px;">

        <p><a href="account.php">My Account</a></p>

 	</div>
    
    <form name="changePass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="user">Password:</label> <input type="password" name="password" /><br />
        <label for="pass">New Pass:</label> <input type="password" name="passwordc" /><br />
	    <label for="confirmpass">New Pass (again):</label> <input type="password" name="passwordcheck" /><br />

        <input type="submit" value="Update Password" class="submit" />
        
    </form>
    
   
    
</div>

</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>

