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
		$email = $_POST["email"];

	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(trim($email) == "")
		{
			$errors[] = "Current email is required.";
		}
		else if(!isValidEmail($email))
		{
			$errors[] = "Email address is invalid.";
		}
		else if(emailExists($email))
		{
			$errors[] = "This email address is already taken by another user.";		
		}

		//End data validation
		if(count($errors) == 0)
		{
			if($email == $loggedInUser->email)
			{
				$errors[] = "Nothing to update";
			}
			else
			{
				$loggedInUser->updateEmail($email);
			}
		}
	}
?>
<?php require_once("loader.php"); ?>
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
	<p>You have successfully updated your email.</p>
</div>
<?php } } ?>

<div id="regbox">
	
    <div style="text-align:center; padding-top:15px;">

        <p><a href="account.php">My Account</a></p>

 	</div>
    
    <form name="changePass" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    
        <label for="user">Email:</label> <input type="text" name="email" value="<?php echo $loggedInUser->email; ?>" /><br />

        <input type="submit" value="Update Email" class="submit" />
        
    </form>
   
</div>

</div>
</body>
</html>
<?php include("models/clean_up.php"); ?>
