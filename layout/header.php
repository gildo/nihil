<?php

    define('ROOT_PATH', dirname(__FILE__));
    include(ROOT_PATH.'/../config.php');
    include(ROOT_PATH.'/../sources/MySQL.php');
    include(ROOT_PATH.'/../sources/Auth.php');
    include(ROOT_PATH.'/../sources/core.php');
    include(ROOT_PATH.'/../templates/'.$template.'/main.php');

    $hey = new Auth();
    $hey->connect($host,$username,$password,$database);
    session_start();
    /* start theme */

	if($hey->is_logged() == FALSE)
	{
    	print('<td class = "menu1"><a href="login"><b>login</b></a></td> ');
	}

	write_menu();

    if($hey->is_admin() == TRUE)
    {
        print("
            <div class='menu'>
                <td class = 'menu1'><a href='admin?mode=post'><b>new post</b></a></td>
                <td class = 'menu1'><a href='admin?mode=new_page'><b>new page</b></a></td>
                <td class = 'menu1'><a href='logout'><b>logout</b></a></td>
            </div>
        ");
    }

?>

            </tr>
    </table>

    <div class="main">
    <!--END -->
