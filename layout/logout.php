<?php

    include('../layout/header.php');

    if($hey->is_logged() == TRUE)
    {
        session_destroy();
        header("Location: index.php");
    }

    include('../layout/footer.php');
