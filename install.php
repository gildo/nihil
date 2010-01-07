<?php
     // Check if config.php has been created
 
    if (!file_exists('conf.php')) {
        die("<p>The file 'config.php' not exists.</p></body></html>"); }
    
    include("conf.php");
    include("lib/MySQL.php");
 
    //Check if the db tables exists
    $mysql = new MySQL();
    
    $mysql->connect();
    
    $mysql->query("
    CREATE TABLE `users` (
    	`admin` TEXT NOT NULL,
    	`password` TEXT NOT NULL
    ); ");
        
    $mysql->query("
         CREATE TABLE `sources` (
    	`name` TEXT NOT NULL,
    	`description` TEXT NOT NULL,
    	`language` TEXT NOT NULL,
    	`source` TEXT NOT NULL,
    	`id` INT (11) NOT NULL AUTO_INCREMENT,
     	PRIMARY KEY (`id`)
        ); ");

    $mysql->query("
        create table blog (
        author text,
	    post text,
	    hour varchar (11),
	    date date,
	    name text,
	    `id` INT (11) NOT NULL AUTO_INCREMENT,
	    PRIMARY KEY (`id`)
        ); ");

    $mysql = "";
        echo "Installation successful<br />";

?>
