<?php require_once("loader.php"); ?>


    <div id="head">
        <div id="menu">
        <div class="menu"><a href="index.php">#home</a></div>
     	<?php 
     	if(!isUserLoggedIn()) { 
     	    print('<div class="menu"><a href="login.php">#login</a> </div>
     	           <div class="menu"> <a href="forgot-password.php">#forgot_passwd</div></a>
     	           <div class="menu"> <a href="register.php">#register</a> </div>'); 
     	    }
     	    if(isUserLoggedIn()) {
            	print('<div class="menu"> <a href="account.php">#account</a> </div>
            	       <div class="menu"> <a href="logout.php">#log_out</a> </div>'); }
     	?>
     </div>

</div>
</body>
</html>
<?php include("footer.php"); ?>
