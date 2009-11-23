<?php
/*
	Copyright UserCake
	http://usercake.com
	
	Developed by: Adam Davis
*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	if(isUserLoggedIn()) { header('Location: account.php'); die; }
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
		$username = $_POST["username"];
		$password = $_POST["password"];
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($username) == "")
		{
			$errors[] = "Username is required.";
		}
		if(trim($password) == "")
		{
			$errors[] = "Password is required";
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//A security note here, never tell the user which credential was incorrect
			if(!usernameExists($username))
			{
				$errors[] = "Username or password is invalid";
			}
			else
			{
				$userdetails = fetchUserDetails($username);
			
				//See if the user's account is activation
				if($userdetails['Active']==0)
				{
					$errors[] = "Your account is not active. Check your emails / spam folder to find your account activation instructions.";
				}
				else
				{
					//Hash the password and use the salt from the database to compare the password.
					$entered_pass = generateHash($password,$userdetails['Password']);

					if($entered_pass != $userdetails['Password'])
					{
						//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
						$errors[] = "Username or password is invalid";
					}
					else
					{
						//Passwords match! we're good to go'
						
						//Construct a new logged in user object
						//Transfer some db data to the session
						$loggedInUser = new loggedInUser();
						$loggedInUser->email = $userdetails['Email'];
						$loggedInUser->user_id = $userdetails['User_ID'];
						$loggedInUser->hash_pw = $userdetails['Password'];
						$loggedInUser->display_username = $userdetails['Username'];
						$loggedInUser->clean_username = $userdetails['Username_Clean'];
						
						//Update last sign in
						$loggedInUser->updateLastSignIn();
		
						$_SESSION['userCakeUser'] = $loggedInUser;
						
						//Redirect to user account page
						header('Location: account.php');
						die;
					}
				}
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>
<?php
if($_POST && count($errors) > 0)
{
	$list="";  
	   foreach($errors as $issue) $list.="<li>".$issue."</li>";
?> 
 
<div id="errors">
    <ol> 
    <?php echo $list; ?>
    </ol>
</div>
 
<?php } ?>

<div id="regbox">
    <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="user">Username:</label> <input type="text" name="username" /><br />
        <label for="pass">Password:</label> <input type="password" name="password" /><br />

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
