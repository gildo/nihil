<?php
	
	error_reporting( 0 );
	
    include('layout/header.php');
    include('layout/footer.php');
    
    
    $id   = $_GET['id'];
    $page = $_GET['page'];
    $view = $_GET['view'];
    $blog = $_GET['blog'];
    
    if($blog == NULL && $page == NULL && $view == NULL)
    {
    	write_page($id);
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

?>
