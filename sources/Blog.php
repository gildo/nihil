<?php

    include_once(ROOT_PATH.'/../sources/MySQL.php');

    class Blog extends MySQL
    {

        function post($author, $name, $content, $hour, $date)
        {
            $sql = "INSERT INTO articles(author,name,content,hour,date) VALUES ('$author','$name','$content','$hour','$date')";
            $result = $this->query($sql);
            $this->close();

            if($result)
            {
                echo "success";
            }

            else
            {
                $this->raise_error();
                echo "nooooo";
            }

        }

        function post_page($name,$content)
        {
        	$query = "INSERT INTO pages (name,content) VALUES ('$name','$content')";
        	$res   = $this->query($query) or $this->raise_error();
        	if($res)
        	{
        		print "Page inserted with success :D\n";
        		print($query);
    		}
    		else
    		{
    			print "Page not inserted :(\n";
    		}
    	}


    }
