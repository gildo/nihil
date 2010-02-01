<?php

    if(file_exists(../install.php))
    {
        unlink(../install.php);
        
        print "File was removed\n";
    }
    else
    {
        print "The file had already been removed in the past\n";
    }
    
?>
