<?php

    error_reporting( 0 );

    include('layout/header.php');



    $id   = $_GET['id'];
    $blog = $_GET['blog'];
    $page = $_GET['page'];
    $view = $_GET['view'];

    if($blog == NULL && $page == NULL && $view == NULL)
    {
        write_pages($id);
    }
    else
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

    include('layout/footer.php');
?>
</div>
