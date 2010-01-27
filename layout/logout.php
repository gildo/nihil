<?php

    include('../layout/header.php');

    if (is_logged ())
    {
        setcookie('biscotto',$password,time() -2000);
    	header ("Location: index.php");
    }

    include('../layout/footer.php');
