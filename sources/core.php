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

    function is_admin($username,$password){

        $password = md5(sha1($password));
        $query    = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' AND level = 'admin'";
        $res      = mysql_query($query) or die ("SQL error:".mysql_error());
        $rows     = mysql_num_rows($res);

        if($res != 1)
        {
            print "Wrong username or password";
            return false;
        }

        else
        {
            print "Login lates with success, hi admin";
            setcookie('biscotto',$password,time()+2000,'/');
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
            print "<a href='index.php?id=".$ris['id']."'><b>".$ris['name']."</b></a>";
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
    
    function new_page($name,$content,$author)
    {
    	$query = "INSERT INTO pages (name,content,author,id) VALUES ('$name','$content','$author','')";
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
    	


?>
