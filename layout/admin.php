<?php

    include('../layout/header.php');

    if(is_logged() == TRUE)
    {

        if(is_admin() == TRUE)
        {
        	
            $mode = $_GET['mode'];

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

                    post($author,$name,$content,$hour,$date);

                }
                else
                {
                    print "Fill in all fields";
                }

            break;

                default:

                die ();

            break;

            }
        }
        else
        {
            print "Not have permission to view these pages :@";
            header("Location: 3;URL=/index.php");
        }

    }
    else
    {
        print "Not logged";
        header("Location: 3;URL=login.php");
    }

    include('../layout/footer.php');

?>
