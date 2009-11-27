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
		Activate a users account
	*/

//Get token param
if($_GET["token"])
{
		$errors = array();
		$token = $_GET["token"];
		
		if($token =="")
		{
			$errors[] = "Invalid token";
		}
		else if(!validateActivationToken($token)) //Check for a valid token. Must exist and active must be = 0
		{
			$errors[] = "Token does not exist / Account is already activated";
		}
		else
		{
			//Activate the users account
			if(!setUserActive($token))
			{
				$errors[] = "Fatel SQL error attempting to update user.";
			}
		}
}
?>
<?php require_once("loader.php"); ?>
<?php
if($_GET)
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
 
<?php } else { 
?> 
<div id="success">

   <p>You account has now been activated, you may now <a href="login.php">login</a>.</p>
   
</div>
<?php } } ?>

	 

	 <div style="text-align:center; padding-top:15px;">
     	<a href="index.php">Home</a> | <a href="login.php">Login</a> | <a href="forgot-password.php">Forgot Password</a> | <a href="register.php">Register</a>
     </div>

</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>
