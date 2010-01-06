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
    $mysql->connect();
    


    $server = $_SERVER ['SERVER_NAME'];
     
    $username = mysql_real_escape_string ($_COOKIE ['_user']);
    $password = mysql_real_escape_string ($_COOKIE ['_pass']);

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

?>
            </div>
        </div>
    </div>
