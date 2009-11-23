<?php

include("models/config.php");

If(isUserLoggedIn())
    { echo "Logged In"; }

else
    if(isGroupMember($id))
        { echo "Log In"; }
?>
