<?php

   // error_reporting( 0 );


    include('../layout/header.php');
    include('../sources/Blog.php');
    $yep = new Blog();

    $edit   = $_GET['edit'];
    $delete = $_GET['delete'];

    if($hey->is_logged() == TRUE)
    {

        if($hey->is_admin() == TRUE)
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
    				$author = $hey->prepare ('author');
    				$content = $hey->prepare ('content');
    				$name = $hey->prepare ('name');
                    $date = date ("d:m:y");
                    $hour = date ("H:i:s");
                    $yep->post($author,$name,$content,$hour,$date);

                }
                else
                {
                    print "Fill in all fields";
                }

                break;


                case "new_page":

                print "<form action = 'admin?mode=new_page' method = 'POST'>";
                print "Name: <input type = 'text' name = 'name'><br>";
                print "<textarea name = 'content' rows = '10' cols = '75'></textarea><br>";
                print "<input type = 'submit' value = 'post'>";
                print "</form>";

                if (!empty ($_REQUEST ['name']) && !empty ($_REQUEST ['content']))
                {
    				$content = $hey->prepare ('content');
    				$name = $hey->prepare ('name');

                    $yep->post_page($name,$content);

                }
                else
                {
                    print "Fill in all fields";
                }

                break;

                case 'edit':

                edit($edit);

                case 'edit_page':

                edit_page($edit);

                break;

                case 'delete':

                delete_article($delete);

                case 'delete_page':

                delete_page($delete);

                break;

                case 'edit_username':

                edit_username();

                break;

                case 'edit_password':

                edit_password();

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
