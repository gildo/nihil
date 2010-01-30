<?php

    //login ->

    function login($username,$password){

        $password = md5(sha1($password));
        $query    = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'";
        $res      = mysql_query($query) or die ("SQL error:".mysql_error());
        $rows     = mysql_num_rows($res);
        $ris      = mysql_fetch_array($res);
        $level    = $ris['level'];

        if($rows != 1)
        {
            print "Wrong username or password\n";
        }

        else
        {
            if($level != 'admin')
            {
                   print "Login lates with success";
                   setcookie('biscotto',$password,time()+2000,'/');
            }
            else
            {
                   print "Login lates with success,hi admin";
                   setcookie('biscotto',$password,time()+2000,'/');
            }
        }
    }

    //is_admin ->

    function is_admin(){

		$biscotto = $_COOKIE['biscotto'];
        $query    = "SELECT * FROM users WHERE password = '{$biscotto}' AND level = 'admin'";
        $res      = mysql_query($query) or die ("SQL error:".mysql_error());
        $rows     = mysql_num_rows($res);

        if($rows != 1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //register ->

    function register($username,$password,$email,$level){
        $password = md5(sha1($password));
        $control  = "SELECT * FROM users WHERE password = '{$password}'";
        $res      = mysql_query($control) or die ("SQL error:".mysql_error());
        $rows     = mysql_num_rows($res);

        if($rows != 1)
        {
            $query    = "INSERT INTO users (username,password,email,level) VALUES('$username','$password','$email','$level');";

            $res      = mysql_query($query) or die ("SQL error:".mysql_error());

            if ($res)
            {
                print "User registration = TRUE :), yep";
            }

            else
            {
                print "Trouble registering";
            }
        }

        else
        {
            print "Username or password that is' present";
        }
    }

    //is_login ->

    function is_logged ()
    {
        if (isset ($_COOKIE ['biscotto']))
        {
            return true;
        }

        else
        {
            return false;
        }
    }

    //write_menu ->

    function write_menu()
    {
        $query = "SELECT * FROM pages";
        $res   = mysql_query($query) or die ("SQL error:".mysql_error());


        while($ris = mysql_fetch_array($res,MYSQL_ASSOC))
        {
            print "<td class='menu1'><a href='".$ris['id']."'><b>".$ris['name']."</b></a></td>";
        }
    }

    //write_pages ->

    function write_pages($id)
    {
        if($id == NULL)
        {
            //home by blog :3
            pagination();
        }
        else
        {
            $query = "SELECT * FROM pages WHERE  id = '{$id}'";
            $res   = mysql_query($query) or die ("SQL error:".mysql_error());

            while($ris = mysql_fetch_array($res,MYSQL_ASSOC))
            {
            print $ris['content'];
            }
        }
    }

    //new_page ->

    function new_page($name,$content)
    {
    	$query = "INSERT INTO pages (name,content) VALUES ('$name','$content')";
    	$res   = mysql_query($query) or die ("SQL error:".mysql_error());
    	if($res)
    	{
    		print "This page inserted with success :D\n";
		}
		else
		{
			print "This page is not included :(\n";
		}
	}

	//post ->

    function post($author,$name,$content,$hour,$date)
    {
        $query = "INSERT INTO articles(author,name,content,hour,date,id) VALUES ('$author','$name','$content','$hour','$date','')";
        $res   = mysql_query ($query) or die ("Errore nell'esecuzione della query: ".mysql_error());

    	if($res)
    	{
    		print "Post inserted with success :D\n";
		}
		else
		{
			print "NOOO!!!, error :( :(\n";
		}
    }

    //write_post ->

	function write_post($id)
	{
		$query = "SELECT * FROM articles WHERE id = '{$id}'";
		$res   = mysql_query($query) or die ("SQL error:".mysql_error());

		while($ris = mysql_fetch_array($res,MYSQL_ASSOC))
		{
			print "<div class='articles'>";
			print "<center><h3><b>".$ris['name']."</b></h3></center><br>";
			print $ris['content']."<br>";
			print "<p align='right'>Posted by <i>".$ris['author']."</i> :: ".$ris['date']." at ".$ris['hour']."</p>";
			print "</div>";

		}
	}

	//pagination ->

	function pagination()
	{
		$query = "SELECT * FROM articles";
		$res   = mysql_query($query) or die ("SQL error:".mysql_error());
		$num   = mysql_num_rows($res);

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
		$res   = mysql_query ($print) or die ("SQL error:".mysql_error());

		while($ris = mysql_fetch_array($res,MYSQL_ASSOC))
		{
			$article = "";
			$size    = strlen($ris['content']);

			if($size > 200)
			{
				$size = 200;
			}

			for($i = 0;$i < $size; $i++)
			{
				$article .= $ris['content'][$i];
			}

			print "<div class='article'>";
			print "<center><a href='post-".$ris['id']."'>".$ris['name']."</a></center>";
			if(is_admin() == TRUE)
			{
			    print "<a href='layout/admin.php?mode=edit&edit=".$ris['id']."'>[edit]</a> ";
			    print "<a href='layout/admin.php?mode=delte&delete=".$ris['id']."'>[x]</a>";
			    print "<br>";
            }
			print $article."  ...continue";
			print "</div>";


		}
        $stat = (int) $_GET['page'];
        print "<table>";
        print "     <tr>";
        if($stat >= 2)
        {
            $stat --;
            print " <td><a href='page-".$stat."'><= </a></td>";
        }

		for($c = 1; $c <= $pages; $c++)
		{

            print " <td class = 'pages'><a href='page-".$c."'>".$c."</a></td>";

		}
        if(end_posts($stat) == TRUE)
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
	    $res   = mysql_query($query) or die ("SQL error:".mysql_error());
	    $num   = mysql_num_rows($res);
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
        $query = "DELETE * FROM articles WHERE id = '{$id}'";
        $res   = mysql_query($query) or die ("SQL error:".mysql_error());
        if($res)
        {
            print "Rule deleted with success\n";
        }
        else
        {
            print "Article not eliminated :(\n";
        }
    }
    
    //edit ->
    
    function edit($id)
    {
        $query = "SELECT * FROM articles WHERE id = '{$id}'";
        $res   = mysql_query($query) or die ("SQL error:".mysql_error());
        while($ris = mysql_fetch_array($res,MYSQL_ASSOC))
        {
            print "<from action = 'admin.php?mode=edit&edit={$id}' method = 'POST'>";
            print "<input type = 'text' name = 'name' value = '".$ris['name']."'><br>";
            print "<textarea name = 'content' >".$ris['content']."</textarea><br>";
            print "<input type = 'text' name = 'date' value = '".$ris['date']."'> <input type = 'text' name = 'hour' value = '".$ris['hour']."'><br>";
            print "<input type = 'submit' value = 'edit'> <input type = 'reset' value = 'reset'>";
            print "</from>";
        }
        
        if(!empty($_POST['name']) || !empty($_POST['content']) || !empty($_POST['date']) || !empty($_POST['hour']))
        {
            
            $name    = htmlentities($_POST['name']);
            $content = htmlentities($_POST['content']);
            $date    = htmlentities($_POST['date']);
            $hour    = htmlentities($_POST['hour']);
            
            $edit   = "UPDATE * FROM articles SET name = '{$name}',content = '{$content}',date = '{$date}',hour = '{$hour}' WHERE id = '{$id}'";
            $result = mysql_query($query) or die ("SQL error:".mysql_error());
            if($result)
            {
                print "Edited articole :)\n";
            }
            else
            {
                print "Articole not edited :(\n";
                header("Refresh: 4; URL=index.php/post-{$id}");
            }
            
        }
    }
                      

?>
