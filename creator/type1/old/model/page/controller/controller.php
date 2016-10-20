<?php

class _PAGE_MODEL_NAME_Controller extends Controller{
	function __construct()
    {
		$this -> _PAGE_MODEL_NAME_ = new _PAGE_MODEL_NAME_Model;
		$this -> all = new allModel;
    }

	function _PAGE_MODEL_NAME_Search() 
	{
					$view = new View();
					$view->set('content', $this -> index->search($_GET));
					$view -> set('all', $this -> all -> all());
					$view -> main_part = $view -> render2('search');
					$view -> render('layouts/layout');	
					exit;		  	
	}
	 	
	function _PAGE_MODEL_NAME_() 
	{
			$view = new View();
			$view->set('content', $this -> _PAGE_MODEL_NAME_ ->_PAGE_MODEL_NAME_());
	            $checkStatus = $view -> get('content');
	            if($checkStatus['status'] === 'error404')
	            {
	                header("HTTP/1.0 404 Not Found");
	                $er404 = new View();
	                $er404 -> set('all', $this -> all -> all());
	                $er404 -> main_part = $view -> render2('error404');
	                $er404 -> render('layouts/layout'); 
	                exit;           
	            }        
			$view->set('all', $this -> all -> all());
/*_HOMEPAGE_ALL_MODEL_*/
			$view -> main_part = $view -> render2('_PAGE_MODEL_NAME_');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');		
	}

}