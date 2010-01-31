<?php

    include_once(ROOT_PATH.'/../sources/MySQL.php');

    class Auth extends MySQL
    {

        var $username;
        var $password;
        var $res;
        var $rows;
        var $level;

        public function login($username,$password)
        {

            $this->sql      = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'";
            $this->res      = $this->query($this->sql);
            $this->rows     = $this->num_rows($this->res);
            $this->ris      = $this->fetch_array($this->res);
            $this->level    = $this->ris['level'];

            if($this->rows != 1)
            {
                print($this->ris);
                $this->raise_error();
                print "Wrong username or password\n";
            }

            else
            {
                if($this->level != 'admin')
                {
                       print "Login lates with success";
                       setcookie('biscotto',$password,time()+2000,'/');
                }
                else
                {
                   print "Login lates with success,hi admin";
                   setcookie('biscotto',$password,time()+2000,'/');
#                   header("Location: index.php");
                }
            }
        }

        function is_admin()
        {

    		$biscotto = $_COOKIE['biscotto'];
            $query    = "SELECT * FROM users WHERE password = '{$biscotto}' AND level = 'admin'";
            $res      = $this->query($query) or die ("SQL error:".mysql_error());
            $rows     = $this->num_rows($res);

            if($rows != 1)
            {
                return false;
            }

            else
            {
                return true;
            }
        }

        function register($username,$password,$email,$level)
        {
            $password = md5(sha1($password));
            $control  = "SELECT * FROM users WHERE password = '{$password}'";
            $res      = $this->query($control) or die ("SQL error:".mysql_error());
            $rows     = $this->num_rows($res);

            if($rows != 1)
            {
                $query    = "INSERT INTO users (username,password,email,level) VALUES('$username','$password','$email','$level');";

                $res      = $this->query($query) or die ("SQL error:".mysql_error());

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
    }
