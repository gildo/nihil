<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/
	require_once("models/config.php");
	
	//Prevent the user visiting the lost password page if he/she is already logged in
	if(isUserLoggedIn()) { header('Location: account.php'); die; }
?>
<?php
	/* 
		Below is a very simple example of how to process a lost password request
		We'll deal with a request in two stages, confirmation or deny then proccess
		
		This file handles 3 tasks.
		
		1. Construct new request.
		2. Confirm request. - Generate new password, update the db then email the user
		3. Deny request. - Close the request
	*/
	
$errors = array();
$success_message = "";
	
//User has confirmed they want their password changed
//----------------------------------------------------------------------------------------------
if($_GET["confirm"])
{

	
	$token = $_GET["confirm"];
	
	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = "Invalid token";
	}
	else
	{
		$rand_pass = getUniqueCode(15);
		$secure_pass = generateHash($rand_pass);
		
		$userdetails = fetchUserDetails(NULL,$token);
		
		$mail = new userCakeMail();		
						
		//Setup our custom hooks
		$hooks = array(
				"searchStrs" => array("#GENERATED-PASS#","#USERNAME#"),
				"subjectStrs" => array($rand_pass,$userdetails["Username"])
		);
					
		if(!$mail->newTemplateMsg("your-lost-password.txt",$hooks))
		{
			$errors[] = "Error building email template.";
		}
		else
		{	
			if(!$mail->sendMail($userdetails["Email"],"Your new password"))
			{
					$errors[] = "Fatal error attempting mail, contact your server administrator";
			}
			else
			{
					if(!updatePasswordFromToken($secure_pass,$token))
					{
						$errors[] = "Fatal SQL error attempting to update user.";
					}
					else
					{	
						//Might be wise if this had a time delay to prevent a flood of requests.
						flagLostPasswordRequest($userdetails['Username_Clean'],0);
						
						$success_message  = "We have emailed you a new lost password.";
					}
			}
		}
			
	}
}

//----------------------------------------------------------------------------------------------

//User has denied this request
//----------------------------------------------------------------------------------------------
if($_GET["deny"])
{
	$token = $_GET["deny"];
	
	if($token == "" || !validateActivationToken($token,TRUE))
	{
		$errors[] = "Invalid token";
	}
	else
	{
	
		$userdetails = fetchUserDetails(NULL,$token);
		
		flagLostPasswordRequest($userdetails['Username_Clean'],0);
		
		$success_message = "Lost password request cancelled.";
	}
}




//----------------------------------------------------------------------------------------------


//Forms posted
//----------------------------------------------------------------------------------------------
if($_POST)
{
		$email = $_POST["email"];
		$username = $_POST["username"];
		
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($email) == "")
		{
			$errors[] = "Username is required.";
		}
		//Check to ensure email is in the correct format / in the db
		else if(!isValidEmail($email) || !emailExists($email))
		{
			$errors[] = "Invalid email address.";
		}
		
		if(trim($username) == "")
		{
			$errors[] = "Email is required.";
		}
		else if(!usernameExists($username))
		{
			$errors[] = "Invalid username";
		}
		
		
		if(count($errors) == 0)
		{
		
			//Check that the username / email are associated to the same account
			if(!emailUsernameLinked($email,$username))
			{
				$errors[] = "Username / Email have no association.";
			}
			else
			{
				//Check if the user has any outstanding lost password requests
				$userdetails = fetchUserDetails($username);
				
				if($userdetails['LostPasswordRequest'] == 1)
				{
					$errors[] = "There is already a outstanding lost password request on this account.";
				}
				else
				{
					//Email the user asking to confirm this change password request
					//We can use the template builder here
					
					//We use the activation token again for the url key it gets regenerated everytime it's used.
					
					$mail = new userCakeMail();
					
					$confirm_url = "<a href='".$websiteUrl."forgot-password.php?confirm=".$userdetails["ActivationToken"]."'>Confirm</a>";
					$deny_url = "<a href='".$websiteUrl."forgot-password.php?deny=".$userdetails["ActivationToken"]."'>Deny</a>";
					
					//Setup our custom hooks
					$hooks = array(
						"searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
						"subjectStrs" => array($confirm_url,$deny_url,$userdetails["Username"])
					);
					
					if(!$mail->newTemplateMsg("lost-password-request.txt",$hooks))
					{
						$errors[] = "Error building email template.";
					}
					else
					{
						if(!$mail->sendMail($userdetails["Email"],"Lost password request"))
						{
							$errors[] = "Fatal error attempting mail, contact your server administrator";
						}
						else
						{
							//Update the DB to show this account has an outstanding request
							flagLostPasswordRequest($username,1);
							
							$success_message = "We have emailed you a lost password request. Consult your email for further instructions";
						}
					}
				}
			}
		}
}	
//----------------------------------------------------------------------------------------------	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forgot Password</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>
<?php
if($_POST || $_GET["confirm"] || $_GET["deny"])
{
	if(count($errors) > 0) {
	$list="";  
	   foreach($errors as $issue) $list.="<li>".$issue."</li>";
?> 
 
<div id="errors">
    <ol> 
    <?php echo $list; ?>
    </ol>
</div>

<?php }  else {  ?> 
<div id="success">

   <p><?php echo $success_message; ?></p>
   
</div>
<?php } } ?>

<div id="regbox">
    <form name="newLostPass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="user">Username:</label> <input type="text" name="username" /><br />
        <label for="pass">Email:</label> <input type="text" name="email" /><br />

        <input type="submit" value="Login" class="submit" />
        
    </form>
</div>

	 <div style="text-align:center; padding-top:15px;">
     	<a href="index.php">Home</a> | <a href="login.php">Login</a> | <a href="forgot-password.php">Forgot Password</a> | <a href="register.php">Register</a>
     </div>
</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>

