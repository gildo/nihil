<?php

    include("config.php");
    include("sources/core.php");

    $hey = mysql_connect($host,$username,$password);
    mysql_select_db($database, $hey);

    mysql_query("
        CREATE TABLE `users` (
        	`username` TEXT NOT NULL,
        	`password` TEXT NOT NULL,
            `id` INT (11) NOT NULL AUTO_INCREMENT,
        	`group` TEXT NOT NULL,
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
    
    print "<from action = '' method = 'POST'>";
    print "<p>username admin: <input type = 'text' name = 'username'></p>";
    print "<p>password admin: <input type = 'password' name = 'password'></p>";
    print "<p>repeat password: <input type = 'password' name = 'repeat'></p>";
    print "<p>email admin: <input type = 'text' name = 'email'></p>";
    print "</form>";
    
    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['repeat']) && eregi("^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$_POST['email']){
    	$username = htmlentities($_POST['username']);
    	$password = htmlentities($_POST['password']);
    	$repeat   = htmlentities($_POST['repeat']);
    	$email    = $_POST['email'];
    	$power    = 'admin';
    	
    	if($password == $repeat){
    		register($username,$password,$email,$power);
		}else{
			print "Passwords do not match";
		}
	}
	
    mysql_close($hey);

?>
