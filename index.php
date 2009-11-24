<?php require_once("loader.php"); ?>



<div id="regbox">


   
</div>

	 <div style="text-align:center; padding-top:15px;">
     	<a href="index.php">Home</a> | 
     	<?php 
     	if(!isUserLoggedIn()) { 
     	    print('<a href="login.php">Login</a> | <a href="forgot-password.php">Forgot Password</a> | <a href="register.php">Register</a>'); 
     	    }
     	    if(isUserLoggedIn()) {
            	print('<a href="account.php">Account</a> | <a href="logout.php">Log Out</a>'); }
     	?>
     </div>

</div>
</body>
</html>
<?php include("footer.php"); ?>
