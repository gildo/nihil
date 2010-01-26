<?php

    include('config.php');
    include('sources/core.php');
    
    $connect = mysql_connect($host,$username,$password) or die ("SQL error:".mysql_error());
    mysql_select_db($database) or die ("SQL error:".mysql_error());

?>
