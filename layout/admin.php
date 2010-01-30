<?php

    include('../layout/header.php');
    
    $edit   = $_GET['edit'];
    $delete = $_GET['delete']; 

    if(is_logged() == TRUE)
    {

        if(is_admin() == TRUE)
        {

            $mode = $_GET['mode'];

            switch ($mode)
            {
                case "post":

                print "<form action = 'admin?mode=post' method = 'POST'>";
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


                case "new_page":

                print "<form action = 'admin?mode=new_page' method = 'POST'>";
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

                    new_page($name,$content);

                }
                else
                {
                    print "Fill in all fields";
                }

                break;
                
                case 'edit':
                
                //on work
                
                break;
                
                case 'delete':
                
                delete_articles($delete);
                
                break;
                /* default case */
                default:

                die ();
                break;

                /* end */

            }
        }
        else
        {
            print "Not have permission to view these pages :@";
            header("Refresh: 4; URL=index.php");
        }

    }
    else
    {
        print "Not logged";
        header("Refresh: 4; URL=login");
    }

    include('../layout/footer.php');

?>
