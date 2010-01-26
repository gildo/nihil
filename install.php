<?php

    include("config.php");

    $hey = mysql_connect($host,$user,$pass);
    mysql_select_db($db, $hey);

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

    mysql_close($hey);

?>
