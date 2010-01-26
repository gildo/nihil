<?php

$date   = array('host'     => 'localhost',
                'username' => 'username',
                'password' => 'password',
                'database' => 'my_database'
               );

$connect = mysql_connect($date['host'],$date['username'],$date['password']) or die ("SQL error:".mysql_error());
mysql_select_db($date['database']) or die ("SQL error:".mysql_error());


?>
