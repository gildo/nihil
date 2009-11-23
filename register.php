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
		Below is a very simple example of how to process a new user.
		 Some simple validation (ideally more is needed).
		
		The first goal is to check for empty / null data, to reduce workload here
		we let the user class perform it's own internal checks, just in case they are missed.
	*/

//Forms posted
if($_POST)
{
		$errors = array();
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirm_pass = $_POST["passwordc"];
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(minMaxRange(5,25,$username))
		{
			$errors[] = "Username must be no fewer than 5 characters or greater than 25.";
		}
		if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
		{
			$errors[] = "Password must be no fewer than 8 characters or greater than 50.";
		}
		else if($password != $confirm_pass)
		{
			$errors[] = "Passwords must match.";
		}
		if(!isValidEmail($email))
		{
			$errors[] = "Invalid email specified.";
		}
		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				//User class will sanitize the data dont worry'
				$user = new User($username,$password,$email);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = "Username ".$username." is already in use.";
					if($user->email_taken) 	  $errors[] = "Email ".$email." is already in use.";		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userCakeAddUser())
					{
						if($user->mail_failure) $errors[] = "Fatal error attempting mail, contact your server administrator";
						if($user->sql_failure)  $errors[] = "Fatal SQL error attempting to insert user.";
					}
				}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
<link href="cakestyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="wrapper">
<div id="logo"></div>


<?php
if($_POST)
{
	  if(count($errors) > 0)
	  {
		$list="";  
	    foreach($errors as $issue) $list.="<li>".$issue."</li>";
?> 
 
<div id="errors">
    <ol> 
    <?php echo $list; ?>
    </ol>
</div>
 
<?php } else { 
	$message = "You have successfully registered. You can now login <a href=\"login.php\">here</a>.";

	//Is email activation enabled?
	if($emailActivation)
		$message = "You have successfully registered. You will soon receive an activation email. You must activate your account before logging in.";
?> 
<div id="success">

   <p><?php echo $message ?></p>
   
</div>
<?php } } ?>

<!-- 

	Please note this file is simple it's used to show the basics
    of constructing a new user through UserCake. Added security like
    the use of a Capatcha should be considered before moving to a production environment

-->

<div id="regbox">
    <form name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="user">Username:</label> <input type="text" name="username" /><br />
        <label for="pass">Password:</label> <input type="password" name="password" /><br />
        <label for="passc">Confirm:</label> <input type="password" name="passwordc" /><br />
        <label for="email">Email:</label><input type="text" name="email" /><br />
        
        <input type="submit" value="Register" class="submit" />
        
    </form>
</div>


	 <div style="text-align:center; padding-top:15px;">
     	<a href="index.php">Home</a> | <a href="login.php">Login</a> | <a href="forgot-password.php">Forgot Password</a> | <a href="register.php">Register</a>
     </div>

</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>

