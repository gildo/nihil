<?php
    
    error_reporting(3);
    require_once('layout/header.php');
    
	if (!admin_exists ())
    	{
			print "<form action = 'admin.php?mode=register_admin' method = 'POST'>";
			print "Name: <input type = 'text' name = 'user'><br>";
			print "Password: <input type = 'password' name = 'pass'><br>";
			print "Retype password: <input type = 'password' name = 'pass2'><br>";
			print "<input type = 'submit' value = 'Register>";
			print "</form>";
			if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['pass']) && !empty ($_REQUEST ['pass2']))
			{
				$name = clearRequest ('user');
				$pass1 = clearRequest ('pass');
				$pass2 = clearRequest ('pass2');
 
				if ($pass1 == $pass2)
				{
					$query = "INSERT INTO `users` (`admin` , `password`) VALUES ('{$name}', '{$pass1}')";
					$mysql->query ($query);
					print "Done<br>";
				}
			}
		}
		
	$mode = $_GET ['mode'];
    switch ($mode)
    {
 
	case "change":
			
			if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				print "<form action = '{$page}?mode=change' method = 'POST'>";
				print "New name: <input type = 'text' name = 'user'><br>";
				print "New password: <input type = 'password' name = 'pass'><br>";
				print "Retype new password: <input type = 'password' name = 'pass2'><br>";
				print "<input type = 'submit' value = 'Change'>";
				print "</form>";
				if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['pass']) && !empty ($_REQUEST ['pass2']))
				{
					$name = clearRequest ('user');
					$pass1 = clearRequest ('pass');
					$pass2 = clearRequest ('pass2');
					$old = $_COOKIE ['_user'];
 
					if ($pass1 == $pass2)
					{
						$query = "UPDATE `users` SET `admin` = '{$name}', `password` = '{$pass1}' WHERE `admin` = '{$old}'";
						$mysql->query ($query);
						print "Done<br>";
					}
				}
			}
			else
				header ("Location: index.php");
		}
		else
			header ("Location: index.php");
			break;
    
    case "post_blog":
    
    		if (admin_exists ())
		    {
			
    			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
    			{
                    print "<form action = 'admin.php?mode=post_blog' method = 'POST'>";
                    print "Author: <input type = 'text' name = 'author'><br>";
                    print "Name: <input type = 'text' name = 'name'><br>";
    				print "<textarea name = 'post' rows = '55' cols = '95'></textarea><br>";
    				print "<input type = 'submit' value = 'post'>";
    				print "</form>";	
       				if (!empty ($_REQUEST ['author']) && !empty ($_REQUEST ['post']) )
    				{
        				$author = clearRequest ('author');
        				$post = clearRequest ('post');
        				$name = clearRequest ('name');
                        $date = date ("d:m:y");
                        $hour = date ("H:i:s");
                        $query = "insert into blog(author,name,post,hour,date) values('$author','$name','$post','$hour','$date')";
                        $mysql->query ($query) or die ("Errore nell'esecuzione della query");

                    }
                }
            }
                                break;
    case "post":
		if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				print "<form action = 'admin.php?mode=post' method = 'POST'>";
				print "Name: <input type = 'text' name = 'user'><br>";
				print "Script: <input type = 'text' name = 'descr'><br>";
				print "Language: <input type = 'text' name = 'lan'><br>";
				print "<textarea name = 'source' rows = '55' cols = '95'></textarea><br>";
				print "<input type = 'submit' value = 'Post'>";
				print "</form>";	
				if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['descr']) && !empty ($_REQUEST ['lan']) && !empty ($_REQUEST ['source']))
				{
					$name = clearRequest ('user');
					$descr = clearRequest ('descr');
					$lan = clearRequest ('lan');
					$source = clearRequest ('source');
 
					$query = "INSERT INTO `sources` (`name` , `description` , `language` , `source`) VALUES ('{$name}', '{$descr}', '{$lan}', '{$source}')";
					$mysql->query ($query);
					print "Done<br>";
				}
			}
			else
				header ("Location: {$page}");
		}
		else
			header ("Location: {$page}");
		break;
 
		case "edit":
		if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				if (!isset ($_GET ['id']))
					header ("Location: index.php");
				$id = intval ($_GET ['id']);
				if (!exists ($id))
					header ("Location: index.php");
				$query = "SELECT * FROM `sources` WHERE `id` = '{$id}'";
				$rows = mysql_fetch_array ($mysql->query ($query) , MYSQL_ASSOC);
				print "<form action = 'admin.php?mode=edit&id={$id}' method = 'POST'>";
				print "Name: <input type = 'text' name = 'user' value = '{$rows ['name']}'><br>";
				print "Script: <input type = 'text' name = 'descr' value = '{$rows ['description']}'><br>";
				print "Language: <input type = 'text' name = 'lan' value = '{$rows ['language']}'><br>";
				print "<textarea name = 'source' rows = '55' cols = '95'>{$rows ['source']}</textarea><br>";
				print "<input type = 'submit' value = 'Post'>";
				print "</form>";
 
				if (!empty ($_REQUEST ['user']) && !empty ($_REQUEST ['descr']) && !empty ($_REQUEST ['lan']) && !empty ($_REQUEST ['source']))
				{
					$name = clearRequest ('user');
					$descr = clearRequest ('descr');
					$lan = clearRequest ('lan');
					$source = clearRequest ('source');
 
					$query = "UPDATE `sources` SET `name` = '{$name}', `description` = '{$descr}', `language` = '{$lan}', `source` = '{$source}' WHERE `id` = '{$id}'";
					$mysql->query ($query);
					print "Done<br>";
				}
			}
			else
				header ("Location: index.php");
		}
		else
			header ("Location: index.php");
		break;
 
	case "delete":
		if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				if (!isset ($_GET ['id']))
					header ("Location: index.php");
				$id = intval ($_GET ['id']);
				$query = "DELETE FROM `sources` WHERE id = '{$id}'";
				$mysql->query ($query);
				print "Done<br>";
			}
			else
				header ("Location: index.php");
		}
		else
			header ("Location: index.php");
		break;


	case "delete_post":
		if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				if (!isset ($_GET ['id']))
					header ("Location: index.php");
				$id = intval ($_GET ['id']);
				$query = "DELETE FROM `blog` WHERE id = '{$id}'";
				$mysql->query ($query);
				print "Done<br>";
			}
			else
				header ("Location: index.php");
		}
		else
			header ("Location: index.php");
		break;
 

		case "edit_post":
		if (admin_exists ())
		{
			if (is_logged () && login (mysql_real_escape_string ($_COOKIE ['_user']), mysql_real_escape_string ($_COOKIE ['_pass'])))
			{
				if (!isset ($_GET ['id']))
					header ("Location: index.php");
				$id = intval ($_GET ['id']);
				$query = "SELECT * FROM `blog` WHERE `id` = '{$id}'";
				$rows = mysql_fetch_array ($mysql->query ($query) , MYSQL_ASSOC);
				print "<form action = 'admin.php?mode=edit_post&id={$id}' method = 'POST'>";
                print "Author: <input type = 'text' name = 'author' value = '{$rows ['author']}' ><br>";
                print "Name: <input type = 'text' name = 'name' value = '{$rows ['name']}' ><br>";
				print "<textarea name = 'post' rows = '55' cols = '95'>{$rows ['post']}</textarea><br>";
				print "<input type = 'submit' value = 'Post'>";
				print "</form>";
 
				if (!empty ($_REQUEST ['author']) && !empty ($_REQUEST ['name']) && !empty ($_REQUEST ['post']))
				{
					$name = clearRequest ('name');
					$author = clearRequest ('author');
					$post = clearRequest ('post');
					$query = "UPDATE `blog` SET `name` = '{$name}', `author` = '{$author}', `post` = '{$post}' WHERE `id` = '{$id}'";
					$mysql->query ($query);
					print "Done<br>";
			    }
			}
			else
				header ("Location: index.php");
		}
		else
			header ("Location: index.php");
		break;

 
	default:
		die ();
		break;
		

			
    }
