<?php

#    error_reporting( 0 );

    include('layout/header.php');

    if(isset($_GET['id']))
    {
        $id   = $_GET['id'];
    }
    if(isset($_GET['blog']))
    {
        $blog = $_GET['blog'];
    }
    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    }
    if(isset($_GET['view']))
    {
        $view = $_GET['view'];
    }

    if($blog == NULL && $page == NULL && $view == NULL)
    {
        write_pages($id);
    }

    else
    {
        if(isset($blog))
        {
            switch($blog)
            {
                case 'page':

                pagination();

                break;

                case 'view':

                write_post($view);

                break;

            }
        }
    }

    include('layout/footer.php');
?>
</div>
