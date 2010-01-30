<?php

    define('ROOT_PATH', dirname(__FILE__));
    include(ROOT_PATH.'/../config.php');
    include(ROOT_PATH.'/../sources/core.php');
    $connect = mysql_connect($host,$username,$password) or die ("SQL error:".mysql_error());
    mysql_select_db($database) or die ("SQL error:".mysql_error());

    /* start theme */

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
	    <link rel="stylesheet" type="text/css" href="layout/style.css">
        <font size="20px"><?php echo $title; ?></font><br>
        <br><br>
        <!-- qui dobbiamo mettere le pagine presenti nella tabella pages -->
        <div class="menu">
            <table>
                <tr>
                    <td class = "menu1"><a href="index.php"><b>home</b></a></td> 
        <?php

        	if(!is_logged())
        	{
            	print('<td class = "menu1"><a href="login"><b>login</b></a></td> ');
        	}
        	else
        	{
            	print('<td class = "menu1"><a href="logout"><b>logout</b></a></td> ');
			}
			write_menu();

        ?>

                    </tr>
            </table>


        </div>

        <div class="main">
        <!-- ALTRA MERDA DA AGGIUNGERE QUI. (MAGARI CI METTIAMO I POSTS) -->
