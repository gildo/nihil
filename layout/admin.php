<?php

    include('../layout/header.php');

    if(!is_logged()) { die("DIE!"); }

    $mode = $_GET['mode'];

    if(isset($mode))
    {

        switch ($mode)
        {
    	    case "post":

                print "<form action = 'admin.php' method = 'POST' name='posta'>";
                print "Author: <input type = 'text' name = 'author'><br>";
                print "Name: <input type = 'text' name = 'name'><br>";
            	print "<textarea name = 'content' rows = '10' cols = '75'></textarea><br>";
            	print "<input type = 'submit' value = 'post'>";
            	print "</form>";

            	if (!empty ($_REQUEST ['author']) && !empty ($_REQUEST ['name']) && !empty ($_REQUEST ['content']))
                {
                	$author  =  $_POST['author'];
                    $content =  $_POST['content'];
                    $name    =  $_POST['name'];
                    $date    =  date ("d:m:y");
                    $hour    =  date ("H:i:s");
                }

                if(isset($_POST['content']))
                {
                    post($author,$name,$content,$hour,$date);
                }

            	break;

        default:
		    die ();
		    break;

        }

    }

    include('../layout/footer.php');

?>
