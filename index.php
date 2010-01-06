<?php

    //error_reporting(0);
    require('layout/header.php');


    $mode = $_GET ['mode'];
    switch ($mode)
    {


        case "login":
            if (admin_exists ()) {
                if (!is_logged ()) {
                    
                    /* login form */
                    print "<form action = 'index.php?mode=login' method = 'POST'>";
                    print "Name: <input type = 'text' name = 'user'><br>";
                    print "Password: <input type = 'password' name = 'pass'><br>";
                    print "<input type = 'submit' value = 'login'>";
                    print "</form>";
                    
                    
                    if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['pass']))
                    {
                        $name = clearRequest ('user');
                        $pass = clearRequest ('pass');
                        
                        if (login ($name, $pass))
                        {
                            setcookie ("_user", $name, time () + 3600);
                            setcookie ("_pass", $pass, time () + 3600);
                            header ("Location: index.php");
                        }
                        
                        else
                        {
                            die ("Username or password wrong");
                        }    
                    }
                }
                    else
                    {
                        header ("Location: index.php");
                    }
            }
        
            else
            {
                header ("Location: index.php");
            }
        
        break;    


       	case "logout":
    		if (admin_exists ())
    		{
    		    
    		    if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
    			{
    			    setcookie ("_user" , "" , time () - 1);
    			    setcookie ("_pass" , "" , time () - 1);
    			    header ("Location: index.php");
    			}
    			
    			else
    			{
    			    header ("Location: index.php");
    		    }
    		}
    		
    		else
    		{
    			header ("Location: index.php");
    		}

        break;


    
        case "show":
            if (isset ($_GET ['id']))
            {
                $id = intval ($_GET ['id']);
        		$query = "SELECT * FROM `blog` WHERE `id` = '{$id}'";
                $ris = mysql_fetch_array ($mysql->query($query) , MYSQL_ASSOC);
        		print ( $ris ['post'] . "<br>");
        		print "posted by ". $ris ['author']. " at ". $ris ['hour']. " of ".  $ris ['date']  ;
           }
           break;
      
    } //switch end!

?>


        


<?php

    $query = "SELECT * FROM `blog`";
    $ris = $mysql->query($query) or die ("Error!");
    
    while ($res = mysql_fetch_array ($ris , MYSQL_ASSOC))
    {
    	if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']),mysql_real_escape_string ($_COOKIE ['_pass'])))
    	
    	        print("
        	        <div id='{$res ['id']}' class='post'>
                    <div class='header'>
                    <span class='title'> <tr>\n<td> <a href = 'post-{$res ['id']}'>#{$res ['name']}</a>
                    </tr> posted by '{$res ['author']}' at '{$res ['hour']}' of {$res ['date']} <td>
                    <a href = 'admin.php?mode=delete_post&id={$res ['id']}'>rm</a>
                    <td><a href = 'admin.php?mode=edit_post&id={$res ['id']}'>edit</a></td>
                    </span> <div style='float: right;'></div>
                    </div>
                ");

    	else
    	{
                print("
                    <div id='{$res ['id']}' class='post'>
                    <div class='header'>
                    <span class='title'> <tr>\n<td> <a href = 'post-{$res ['id']}'>#{$res ['name']}</a>
                    </tr> posted by '{$res ['author']}' at '{$res ['hour']}' of {$res ['date']} </span>
                    <div style='float: right;'></div>
                    </div>
                ");
        }
    }
?>

<div class="content">
</div>

<?php
       require_once('layout/footer.php');
?>
