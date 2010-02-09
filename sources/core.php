<?php

    //write_menu ->

    function write_menu()
    {
        $hey = new Auth();
        $query = "SELECT * FROM pages";
        $res   = $hey->query($query) or die ("SQL error:".$hey->error());


        while($ris = $hey->fetch_array($res))
        {
            print "<td class='menu1'><a href='".$ris['id']."'><b>".$ris['name']."</b></a></td>";
        }
    }

    //write_pages ->

    function write_pages($id)
    {
        $hey = new Auth();
        if($id == NULL)
        {
            //home by blog :3
            pagination();
        }
        else
        {
            $query = "SELECT * FROM pages WHERE  id = '{$id}'";
            $res   = $hey->query($query) or die ("SQL error:".$hey->error());

            while($ris = $hey->fetch_array($res))
            {
                   if($hey->is_admin() == TRUE)
                    {
                        print "<a href='admin?mode=edit_page&edit=".$ris['id']."'>[edit]</a> ";
                        print "<a href='admin?mode=delete_page&delete=".$ris['id']."'>[x]</a>";
                        print "<br>";
                    }
            print nl2br($ris['content']);

            }
        }
    }

    //write_post ->

	function write_post($id)
	{
        $hey = new Auth();
		$query = "SELECT * FROM articles WHERE id = '{$id}'";
		$res   = $hey->query($query) or die ("SQL error:".$hey->error());

		while($ris = $hey->fetch_array($res))
		{
			print "<div class='articles'>";
			print "<center><b>".$ris['name']."</b></center><br>";
			print nl2br($ris['content'])."<br>";
			print "<p align='right'>Posted by <i>".$ris['author']."</i> :: ".$ris['date']." at ".$ris['hour']."</p>";
			print "</div>";

		}
	}

	//pagination ->

	function pagination()
	{
        $hey = new Auth();
		$query = "SELECT * FROM articles";
		$res   = $hey->query($query) or die ("SQL error:".$hey->error());
		$num   = $hey->num_rows($res);

		if($num % 5 > 0)
		{
			$pages = (int) ($num / 5) + 1;
		}
		else
		{
			$pages = (int) ($num / 5);
		}

		if (isset ($_GET ['page']))
		{
			$id = intval ($_GET ['page']);
			$from = abs ($id - 1) * 5;
			$to = 5;
		}
		else
		{
			$from = 0;
			$to   = 5;
		}

		$print = "SELECT * FROM articles ORDER BY id DESC LIMIT {$from},{$to}";
		$res   = $hey->query ($print) or $hey->raise_error();

		while($ris = $hey->fetch_array($res))
		{
			print "<div class='article'>";
			print "<center><a href='post-".$ris['id']."'>".$ris['name']."</a></center><br>";
			if($hey->is_admin() == TRUE)
			{
			    print "<a href='admin?mode=edit&edit=".$ris['id']."'>[edit]</a> ";
			    print "<a href='admin?mode=delete&delete=".$ris['id']."'>[x]</a>";
			    print "<br>";
            }
			print nl2br($ris['content']);
            print "</div>";


		}
        if(isset($_GET['page']))
        {
            $stat = (int) $_GET['page'];
        }
        print "<table>";
        print "     <tr>";

        if(isset($stat) && $stat >= 2)
        {
            $stat --;
            print " <td><a href='page-".$stat."'><= </a></td>";
        }

		for($c = 1; $c <= $pages; $c++)
		{

            print " <td class = 'pages'><a href='page-".$c."'>".$c."</a></td>";

		}

        if(isset($stat) && end_posts($stat) == TRUE)
        {
		    $stat ++;
            print "     <td><a href='page-".$stat."'> =></a></td>";
        }
        print "     </tr>";
        print "</table>";

	}

	//end_posts ->

	function end_posts($id)
	{
	    $query = "SELECT * FROM articles WHERE id = '{$id}'";
	    $res   = $hey->query($query) or $hey->raise_error();
	    $num   = $hey->num_rows($res);
	    if($num == 1)
	    {
	        return true;
        }
        else
        {
            return false;
        }
    }

    //delte_article ->

    function delete_article($id)
    {
        $hey = new Auth();
        $query = "DELETE FROM articles WHERE id = '{$id}'";
        $res   = $hey->query($query) or $hey->raise_error();
        if($res)
        {
            header("Location: index.php");
        }
        else
        {
            print "Article not eliminated :(\n";
        }
    }

    //delte_page ->
    function delete_page($id)
    {
        $hey = new Auth();
        $query = "DELETE FROM pages WHERE id = '{$id}'";
        $res   = $hey->query($query) or $hey->raise_error();
        if($res)
        {
            header("Location: index.php");

        }
        else
        {
            print "Error deleting page :(\n";
        }
    }

    //edit ->

    function edit($id)
    {
        $hey = new Auth();
        $query = "SELECT * FROM articles WHERE id = '{$id}'";
        $res   = $hey->query($query) or $hey->raise_error();
        while($ris = $hey->fetch_array($res))
        {
            print "<form action = 'admin.php?mode=edit&edit={$id}' method = 'POST'>";
            print "<input type = 'text' name = 'name' value = '".$ris['name']."'><br>";
            print "<textarea name = 'content' >".$ris['content']."</textarea><br>";
            print "<input type = 'text' name = 'date' value = '".$ris['date']."'> <input type = 'text' name = 'hour' value = '".$ris['hour']."'><br>";
            print "<input type = 'submit' value = 'edit'> <input type = 'reset' value = 'reset'>";
            print "</form>";
        }

        if(!empty($_POST['name']) || !empty($_POST['content']) || !empty($_POST['date']) || !empty($_POST['hour']))
        {

			$content = $hey->prepare ('content');
			$name = $hey->prepare ('name');
            $date = date ("d:m:y");
            $hour = date ("H:i:s");

            $edit   = "UPDATE articles SET name = '{$name}',content = '{$content}',date = '{$date}',hour = '{$hour}' WHERE id = '{$id}'";
            $result = $hey->query($edit) or $hey->raise_error();
            if($result)
            {
                print "Edited articole :)\n";
                header("Refresh: 2; URL=post-{$id}");
            }
            else
            {
                print "Articole not edited :(\n";
                header("Refresh: 2; URL=post-{$id}");
            }

        }
    }

    function edit_page($id)
    {
        $hey = new Auth();
        $query = "SELECT * FROM pages WHERE id = '{$id}'";
        $res   = $hey->query($query) or $hey->raise_error();
        while($ris = $hey->fetch_array($res))
        {
            print "<form action = 'admin.php?mode=edit_page&edit={$id}' method = 'POST'>";
            print "<input type = 'text' name = 'name' value = '".$ris['name']."'><br>";
            print "<textarea name = 'content' >".$ris['content']."</textarea><br>";
            print "<input type = 'submit' value = 'edit'> <input type = 'reset' value = 'reset'>";
            print "</form>";
        }

        if(!empty($_POST['name']) || !empty($_POST['content']))
        {

			$content = $hey->prepare ('content');
			$name    = $hey->prepare ('name');


            $edit   = "UPDATE pages SET name = '{$name}',content = '{$content}' WHERE id = '{$id}'";
            $result = $hey->query($edit) or die ("SQL error:".$hey->error());
            if($result)
            {
                print "page edited :)\n";
                header("Refresh: 2; URL={$id}");
            }
            else
            {
                print "Articole not edited :(\n";
                header("Refresh: 2; URL={$id}");
            }

        }
    }

    //edit_username ->

    function edit_username()
    {
        print "<form method = 'POST' action='admin.php?mode=edit_username'>";
        print "new username: <input type = 'text' name = 'username'><br>";
        print "password: <input type = 'password' name = 'password'><br>";
        print "<input type = 'submit' value = 'edit'> <input type = 'reset' value = 'reset'><br>";
        print "</form>";

        if(!empty($_POST['username']) && !empty($_POST['password']))
        {
            $password = md5(sha1($_POST['password']));
            $username = htmlentities($_POST['username']);

            $query = "SELECT * FROM users WHERE password = '{$password}'";
            $res   = $hey->query($query) or die ("SQL error:".$hey->error());
            $num   = $hey->num_rows($res);
            if($num != 1)
            {
                print "Wrong password\n";
            }
            else
            {
                $update = "UPDATE users SET username = '{$username}' WHERE password = '{$password}'";
                $result = $hey->query($update) or $hey->raise_error();
                if($result)
                {
                    print "Username changed with success";
                }
                else
                {
                    print "Amended to problems in the username";
                }
            }
        }
    }

    //edit_password ->

    function edit_password()
    {
        print "<form method = 'POST' action='admin.php?mode=edit_password'>";
        print "password: <input type = 'text' name = 'password'><br>";
        print "new password: <input type = 'password' name = 'new_password'><br>";
        print "<input type = 'submit' value = 'edit'> <input type = 'reset' value = 'reset'><br>";
        print "</form>";

        if(!empty($_POST['password']) && !empty($_POST['new_password']))
        {
            $password     = md5(sha1($_POST['password']));
            $new_password = md5(sha1($_POST['new_password']));

            $query = "SQLECT * FROM users WHERE password = '{$password}'";
            $res   = $hey->query($query) or $hey->raise_error();
            $num   = $hey->num_rows($res);
            if($num != 1)
            {
                print "Existing user\n";
            }
            else
            {
                $update = "UPDATE users SET password = '{$new_password}' WHERE password = '{$password}'";
                $result = $hey->query($update) or $hey->raise_error();
                if($result)
                {
                    print "Password changed with success\n";
                    setcookie('biscotto',$password,time()-20000,'/');
                    setcookie('biscotto',$new_password,time()+2000,'/');
                    if(is_logged() == TRUE)
                    {
                        print "setcookie ok\n";
                    }
                    else
                    {
                        print "cookie not set\n";
                        header("Refresh: 2; URL=/login");
                    }

                }
                else
                {
                    print "Error, password not changed\n";
                }
            }
        }
    }

?>
