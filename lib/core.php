<?php

    function admin_exists ()
    {
    	$query = "SELECT `admin` FROM `users`";
    	if (mysql_num_rows ( $mysql->query ($query)) == 1)
    		return true;
    	return false;
    }
     
    function clearRequest ($request)
    {
    	if (isset ($_REQUEST [$request]))
    	{
    		$var = mysql_real_escape_string (htmlentities ($_REQUEST [$request]));
    		return $var;
    	}
    }
     
    function is_logged ()
    {
    	if (isset ($_COOKIE ['_user']) && isset ($_COOKIE ['_pass']))
    		return true;
    	return false;
    }
     
    function login ($name, $pass)
    {
    	$query = "SELECT * FROM `users` WHERE `admin` = '{$name}'";
    	$data = mysql_fetch_array ($mysql->query ($query) , MYSQL_ASSOC);
    	if ($data ['admin'] == $name && $data ['password'] == $pass);
    		return true;
    	return false;
    }
     
    function exists ($id)
    {
    	$query = "SELECT * FROM `sources` WHERE `id` = '{$id}'";
    	if (mysql_num_rows ($mysql->query ($query)) > 0)
    		return true;
    	return false;
    }
