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
            print "<a href='index.php?id=".$ris['id']."'><b>".$ris['name']."</b></a> ";
        }
    }

    //write_pages ->

    function write_pages($id)
    {
        if($id == NULL)
        {
            //si potrebbe anche usare una query,che printerebbe l'id 1 (cioe' quello dell'home page)
            print "Hi,this is a home page :3";
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
			print "<center>".$ris['name']."</center><br>";
			print $ris['content'];
			print "<p align='right'>Posted by ".$ris['author']." :: ".$ris['date']." at ".$ris['hour']."</p>";
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
			$size    = strlen($ris['content']) / 4;

			if($size > 800)
			{
				$size = 800;
			}

			for($i = 0;$i < $size; $i++)
			{
				$article .= $ris['content'][$i];
			}

			print "<div class='article'>";
			print "<center><a href='?blog=view&view=".$ris['id']."'>".$ris['name']."</a></center>";
			print $article.". . .";
			print "</div>";


		}

		for($c = 1; $c <= $pages; $c++)
		{
			print "<div class = 'page'><a href = 'index.php?blog=page&page=".$c."'>.".$c."</a></div>";

		}
	}

?>
