<?php

    include('../layout/header.php');

    if (is_logged ())
    {
    	setcookie ("biscotto" , "" , time () - 100000000);
    	header ("Location: index.php");
    }

    include('../layout/footer.php');
