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
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
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
            if(is_admin() == TRUE)
            {
                print("
                <td class = 'menu1'><a href='admin?mode=post'><b>new post</b></a></td>
                <td class = 'menu1'><a href='admin?mode=new_page'><b>new page</b></a></td>
                <td class = 'menu1'><a href='admin?mode=edit_username'><b>edit user</b></a></td>
                <td class = 'menu1'><a href='admin?mode=edit_password'><b>edit password</b></a></td>
                ");
            }
        ?>

                    </tr>
            </table>


        </div>

        <div class="main">
        
        <?php
          
                if(file_exists("../install.php"))
                {
                    print "<span style = 'color: #FF0000;'><b>[WARNING:</span><a href = 'delete_install.php'> delete install.php</a><span style = 'color: #FF0000;'> ]</span></b>";
                    
                }
                
        ?>
        <!-- ALTRA MERDA DA AGGIUNGERE QUI. (MAGARI CI METTIAMO I POSTS) -->
