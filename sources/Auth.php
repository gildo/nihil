<?php

        define('ROOT_PATH', dirname(__FILE__));
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
            session_start();

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
                esit;
            }

            else
            {
                if($this->level != 'admin')
                {
                    print "Login lates with success";

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                }
                else
                {
                   print "Login lates with success,hi admin";

                   $_SESSION['username'] = $username;
                   $_SESSION['password'] = $password;
                   $_SESSION['level']    = $this->level;
                }
            }
        }

        function is_admin()
        {
            if(isset($_SESSION['level']))
            {
                if($_SESSION['level'] == 'admin')
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }

        function register($username,$password,$email,$level)
        {

            $this->control  = "SELECT * FROM users WHERE password = '{$this->password}'";
            $this->res      = $this->query($this->control) or die ("SQL error:".mysql_error());
            $this->rows     = $this->num_rows($this->res);

            if($this->rows != 1)
            {
                $this->query    = "INSERT INTO users (username,password,email,level) VALUES('$username','$password','$email','$level');";


                $this->res      = $this->query($this->query) or die ("SQL error:".mysql_error());

                if ($this->res)
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
            if (isset ($_SESSION['username']) && $_SESSION['password'])
            {
                return true;
            }

            else
            {
                return false;
            }
        }
    }
