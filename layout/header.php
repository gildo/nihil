<?php

    define('ROOT_PATH', dirname(__FILE__));
    include(ROOT_PATH.'/../config.php');
    include(ROOT_PATH.'/../sources/core.php');
    $connect = mysql_connect($host,$username,$password) or die ("SQL error:".mysql_error());
    mysql_select_db($database) or die ("SQL error:".mysql_error());

?>
