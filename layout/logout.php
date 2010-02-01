<?php

    include('../layout/header.php');

    if($hey->is_logged() == TRUE)
    {
        setcookie('biscotto',$password,time() - 2000,'/');
        header ("Location: index.php");
    }

    include('../layout/footer.php');
