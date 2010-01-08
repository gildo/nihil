<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo $sitename; ?></title>
        <link href="layout/style.css" rel="stylesheet" type="text/css"></link>
       	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>

<?php

    require('conf.php');
    require('lib/MySQL.php');
    require('lib/core.php');

    // istanza della classe
    $mysql = new MySQL();

    // chiamata alla funzione di connessione
    $mysql->connect($host, $user, $pass, $db);
    
    $server = $_SERVER ['SERVER_NAME'];
    
    if ( isset ( $_COOKIE ['_user'], $_COOKIE ['_pass'] )   )
    {
        $username = $mysql->prepare ($_COOKIE ['_user']);
        $password = $mysql->prepare ($_COOKIE ['_pass']);
    }
?>
<div style="top: 52.5px; left: 126px;" id="container">

    <div id="head">
        <div id="menu">
        <div class="menu"><a href="index.php">#home</a></div>
        <div class="menu"><a href="sources.php">#sources</a></div>
<?php 
            if (!is_logged ()) {
                print "<a href = 'index.php?mode=login'>#log_in</a><br>";
            }
            else print '
         <div class="menu"><a href="">#admin</a>
            <div class="menu">
                <a class="menu_element" href="admin.php?mode=post_blog"><div>#post_blog</div></a>
                <a class="menu_element" href="admin.php?mode=change"><div>#edit_admin</div></a>
                <a class="menu_element" href="admin.php?mode=post"><div>#post_source</div></a>
                <div style="border-top: 1px solid #1f1f1f; width: 100%; height: 1px;"></div>
            </div>
         <a href = "index.php?mode=logout">#log_out</a>';
	if (!admin_exists ())
    	{
			print "<br><form action = 'admin.php?mode=register_admin' method = 'POST'>";
			print "<br> admin register form <br> <br>";
			print "Name: <br> <input type = 'text' name = 'user'><br>";
			print "Password: <br> <input type = 'password' name = 'pass'><br>";
			print "Retype password: <br> <input type = 'password' name = 'pass2'><br>";
			print " <br> <input type = 'submit' value = 'Register'>";
			print "</form>";
			if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['pass']) && !empty ($_REQUEST ['pass2']))
			{
				$name = clearRequest ('user');
				$pass1 = clearRequest ('pass');
				$pass2 = clearRequest ('pass2');
 
				if ($pass1 == $pass2)
				{
					$query = "INSERT INTO `users` (`admin` , `password`) VALUES ('{$name}', '{$pass1}')";
					$mysql->query ($query);
					print "Done<br>";
				}
			}
		}
?>
            </div>
        </div>
    </div>
