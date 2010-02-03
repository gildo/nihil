<?php

    /**
    * a very stupid class
    */

    class MySQL {

        var $link;
        var $recent_link = null;
        var $sql = '';
    	var $error = '';
    	var $errno = '';
    	var $show_errors = true;

    	function connect($host, $user, $pass, $db)
    	{
    		$this->link = @mysql_connect($host, $user, $pass);

    		if ($this->link)
    		{
    			if (@mysql_select_db($db, $this->link))
    			{
    				$this->recent_link =& $this->link;
    				return $this->link;
    			}
    		}

    		// If we couldn't connect or select the db...
    		$this->raise_error("Could not select and/or connect to database: $db");
    	}

    	function query($sql)
    	{
            $this->sql = mysql_query($sql) or die(nl2br($sql).mysql_error());
            global $queries;
            $queries++;
            return $this->sql;
    	}

    	function fetch_array($result)
    	{
    		return mysql_fetch_array($result);
    	}

    	function num_rows($result)
    	{
    		return @mysql_num_rows($result);
    	}

    	function affected_rows()
    	{
    		return @mysql_affected_rows($this->recent_link);
    	}

    	function prepare($value, $do_like = false)
    	{
    		$value = $_REQUEST[$value];
    		$value = stripslashes($value);

    		if ($do_like)
    		{
    			$value = str_replace(array('%', '_'), array('\%', '\_'), $value);
    		}

    		if (function_exists('mysql_real_escape_string'))
    		{
    			return mysql_real_escape_string($value);
    		}
    		else
    		{
    			return mysql_escape_string($value);
    		}
    	}

    	function close()
    	{
    		$this->sql = '';
    		return @mysql_close($this->link);
    	}

    	function raise_error($error_message = '')
    	{
    		if ($this->recent_link)
    		{
    			$this->error = $this->error($this->recent_link);
    			$this->errno = $this->errno($this->recent_link);
    		}

    		if ($error_message == '')
    		{
    			$this->sql = "Error in SQL query:\n\n" . rtrim($this->sql) . ';';
    			$error_message =& $this->sql;
    		}
    		else
    		{
    			$error_message = $error_message . ($this->sql != '' ? "\n\nSQL:" . rtrim($this->sql) . ';' : '');
    		}

    		$message = "<textarea rows=\"10\" cols=\"80\">MySQL Error:\n\n\n
    		$error_message\n\nError: {$this->error}\nError #: {$this->errno}\n
    		Filename: " . $this->_get_error_path() . "\n</textarea>";

    		if (!$this->show_errors)
    		{
    			$message = "<!--\n\n$message\n\n-->";
    		}
    		die("There seems to have been a slight problem with our database.<br /><br />\n$message");
    	}

    	function error()
    	{
    		$this->error = (is_null($this->recent_link)) ? '' : mysql_error($this->recent_link);
    		return $this->error;
    	}


    	function errno()
    	{
    		$this->errno = (is_null($this->recent_link)) ? 0 : mysql_errno($this->recent_link);
    		return $this->errno;
    	}

    	function _get_error_path()
    	{
    		if ($_SERVER['REQUEST_URI'])
    		{
    			$errorpath = $_SERVER['REQUEST_URI'];
    		}
    		else
    		{
    			if ($_SERVER['PATH_INFO'])
    			{
    				$errorpath = $_SERVER['PATH_INFO'];
    			}
    			else
    			{
    				$errorpath = $_SERVER['PHP_SELF'];
    			}

    			if ($_SERVER['QUERY_STRING'])
    			{
    				$errorpath .= '?' . $_SERVER['QUERY_STRING'];
    			}
    		}

    		if (($pos = strpos($errorpath, '?')) !== false)
    		{
    			$errorpath = urldecode(substr($errorpath, 0, $pos)) . substr($errorpath, $pos);
    		}
    		else
    		{
    			$errorpath = urldecode($errorpath);
    		}
    		return $_SERVER['HTTP_HOST'] . $errorpath;
    	}

    	function show_errors()
    	{
    		$this->show_errors = true;
    	}

    	function hide_errors()
    	{
    		$this->show_errors = false;
    	}

    	function free_result($result)
    	{
    		return @mysql_free_result($result);
    	}

    }

?>
