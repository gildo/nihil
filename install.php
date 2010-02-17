<?php

    error_reporting( 0 );

    if (!file_exists('config.php')) {
        die("<p>The file 'config.php' not exists.</p></body></html>"); }

    include("config.php");
    include('sources/Auth.php');
    include('sources/core.php');
    $db = new MySQL();
    $db->connect($host,$username,$password,$database);
    $hey = new Auth();
    print("HELO, go to install.php?mode=install\n");

    $mode = $_GET['mode'];
    switch($mode)
    {
        case 'register':

    	print "<form action = 'install.php?mode=register' method = 'POST'>";
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
                $password = md5(sha1($password));
        		$hey->register($username,$password,$email,$level);
    		}

    		else
    		{
    			print "Passwords do not match";
    		}
    	}

        $db->close();
        break;

        case 'install':
            $db->query("
        CREATE TABLE `users` (
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            `username` TEXT NOT NULL,
            `password` TEXT NOT NULL,
            `level` TEXT NOT NULL,
            `email` TEXT NOT NULL,
        	    PRIMARY KEY (`id`)
        );
    ");

    $db->query("
        CREATE TABLE `pages` (
            `name` TEXT NOT NULL,
            `content` TEXT NOT NULL,
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            	PRIMARY KEY (`id`)
        );
    ");

    $db->query("
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

    $db->query("
        CREATE TABLE `comments` (
            `comment` TEXT NOT NULL,
            `author` TEXT NOT NULL,
            `date` TEXT NOT NULL,
            `hour` TEXT NOT NULL,
            `post_id` INT (11) NOT NULL,
            `id` INT (11) NOT NULL AUTO_INCREMENT,
            	PRIMARY KEY (`id`)
        );
    ");

    print("installed, go to install.php?mode=register\n");

    break;

    }
?>
