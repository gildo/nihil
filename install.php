<?php

    if (!file_exists('config.php')) {
        die("<p>The file 'config.php' not exists.</p></body></html>"); }

    include("config.php");
    include("sources/core.php");

    $hey = mysql_connect($host,$username,$password);
    mysql_select_db($database, $hey);

    mysql_query("
        CREATE TABLE `users` (
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `level` TEXT NOT NULL,
            `email` TEXT NOT NULL,
        	    PRIMARY KEY (`id`)
        );
    ");

    mysql_query("
        CREATE TABLE `pages` (
            `name` TEXT NOT NULL,
            `content` TEXT NOT NULL,
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            	PRIMARY KEY (`id`)
        );
    ");

    mysql_query("
        CREATE TABLE `articles` (
            `name` TEXT NOT NULL,
            `author` TEXT NOT NULL,
            `content` TEXT NOT NULL,
            `date` TEXT NOT NULL,
            `hour` TEXT NOT NULL,
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            	PRIMARY KEY (`id`)
        );
    ");

	print "<form action = 'install.php' method = 'POST'>";
	print "username: <input type = 'text' name = 'username'><br>";
	print "password: <input type = 'password' name = 'password'><br>";
	print "retype password: <input type = 'password' name = 'repeat'><br>";
    print "<p>email admin: <input type = 'text' name = 'email'></p>";
	print "<input type = 'submit' value = 'register'>";
    print "</form>";


    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repeat']) && eregi("^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$_POST['email']) )
    {
    	$username = htmlentities($_POST['username']);
    	$password = htmlentities($_POST['password']);
    	$repeat   = htmlentities($_POST['repeat']);
    	$email    = $_POST['email'];
    	$level    = 'admin';

    	if($password == $repeat)
    	{
    		register($username,$password,$email,$level);
		}

		else
		{
			print "Passwords do not match";
		}
	}

    mysql_close($hey);

?>
