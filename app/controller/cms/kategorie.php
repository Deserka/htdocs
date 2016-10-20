<?php
class cms_kategorieController extends Controller {
	function __construct() {   
	        $this->kategoriemodel = new cms_kategorieModel;
	    }
	function kategorieList() {    
	    $view = new View ;
	    $view->set('content', $this->kategoriemodel->kategorie());
	    $view->main_part = $view->render2('cms/kategorieList');
	    $view->render('cms/layouts/layout');  
	}
	function kategorieAdd(){
	    $view = new View ;
	    $view -> set('content', $this ->kategoriemodel->kategorieAdd());
	    $view -> main_part = $view -> render2('cms/kategorieAdd');
	    $view -> render('cms/layouts/layout');
	}
	function kategorieInsert() {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->kategoriemodel->kategorieInsert());
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/kategorieAdd');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: /cms/produkty/kategorie/list');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: /cms/produkty/kategorie/list');
	            exit;
	        }
	    exit;
	}
	function kategorieEdit($id) {
	    $view = new View ;
	    $view->set('content', $this->kategoriemodel->kategorieEdit($id));
	    $view->main_part = $view->render2('cms/kategorieAdd');
	    $view->render('cms/layouts/layout');
	}
	function kategorieDelete($id) {
	        include('lang/'.$_SESSION['cms_lang'].'.php'); 
	        $this -> kategoriemodel -> kategorieDelete($id);
	            $_SESSION['pass'] = 'Usunięto';
	            header('Location: /cms/produkty/kategorie/list');
	            exit; 
	}
	function kategorieQueue()
	{
	    $this->kategoriemodel->kategorieQueue();
	    exit;
	}
}