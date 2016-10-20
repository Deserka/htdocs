<?php
class cms_aktualnosciController extends Controller {
	function __construct() {   
	        $this->aktualnoscimodel = new cms_aktualnosciModel;
	    }
	function aktualnosciList() {    
	    $view = new View ;
	    $view->set('content', $this->aktualnoscimodel->aktualnosci());
	    $view->main_part = $view->render2('cms/aktualnosciList');
	    $view->render('cms/layouts/layout');  
	}
	function aktualnosciAdd(){
	    $view = new View ;
	    $view -> set('content', $this ->aktualnoscimodel->aktualnosciAdd());
	    $view -> main_part = $view -> render2('cms/aktualnosciAdd');
	    $view -> render('cms/layouts/layout');
	}
	function aktualnosciInsert() {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->aktualnoscimodel->aktualnosciInsert());
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/aktualnosciAdd');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: /cms/aktualnosci/list');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: /cms/aktualnosci/list');
	            exit;
	        }
	    exit;
	}
	function aktualnosciEdit($id) {
	    $view = new View ;
	    $view->set('content', $this->aktualnoscimodel->aktualnosciEdit($id));
	    $view->main_part = $view->render2('cms/aktualnosciAdd');
	    $view->render('cms/layouts/layout');
	}
	function aktualnosciDelete($id) {
	        include('lang/'.$_SESSION['cms_lang'].'.php'); 
	        $this -> aktualnoscimodel -> aktualnosciDelete($id);
	            $_SESSION['pass'] = 'Usunięto';
	            header('Location: /cms/aktualnosci/list');
	            exit; 
	}
	function aktualnosciQueue()
	{
	    $this->aktualnoscimodel->aktualnosciQueue();
	    exit;
	}
function aktualnosciGallery($id){
    $view = new View ;
    $view->set('content', $this->aktualnoscimodel->aktualnosciGallery($id));
    $view->main_part = $view->render2('cms/aktualnosciGallery');
    $view->render('cms/layouts/layout');
}
function aktualnosciGalleryInsert($id) {
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->aktualnoscimodel->aktualnosciGalleryInsert($id));
        $checkStatus = $view->get('content');
        // If error show again adding
        if ($checkStatus['status'] === 'error') {
                $back = new View ;
                $back->set ('content', $checkStatus);
                $back->main_part = $view->render2('cms/aktualnosciGallery');
                $back->render('cms/layouts/layout');
                exit;
        } elseif ($checkStatus['status'] === 'added') {
            $_SESSION['pass'] = $lang['Image added.'];
            header("Location: /cms/aktualnosci/".$id."/gallery");   
            exit;
        }
}
function aktualnosciGalleryDelete($id, $imageId) {       
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->aktualnoscimodel->aktualnosciGalleryDelete($id, $imageId));
        $checkStatus = $view->get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted') {
            $_SESSION['pass'] = $lang['controller1'];
            header("Location: /cms/aktualnosci/".$id."/gallery");
            exit;
        }           
}
function aktualnosciGalleryEdit() {
    $this->aktualnoscimodel->aktualnosciGalleryEdit();
    exit;
}
function aktualnosciGalleryUpdate($id) {
    include('lang/'.$_SESSION['cms_lang'].'.php'); 
    $this->aktualnoscimodel->aktualnosciGalleryUpdate($id);
            $_SESSION['pass'] = $lang['Changes saved.'];
            header("Location: /cms/aktualnosci/".$id."/gallery");
            exit;
}
function aktualnosciGalleryQueue() {
    $this->aktualnoscimodel->aktualnosciGalleryQueue();
    exit;
}
}