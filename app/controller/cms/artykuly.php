<?php
class cms_artykulyController extends Controller {
	function __construct() {   
	        $this->artykulymodel = new cms_artykulyModel;
	    }
	function artykulyList() {    
	    $view = new View ;
	    $view->set('content', $this->artykulymodel->artykuly());
	    $view->main_part = $view->render2('cms/artykulyList');
	    $view->render('cms/layouts/layout');  
	}
	function artykulyAdd(){
	    $view = new View ;
	    $view -> set('content', $this ->artykulymodel->artykulyAdd());
	    $view -> main_part = $view -> render2('cms/artykulyAdd');
	    $view -> render('cms/layouts/layout');
	}
	function artykulyInsert() {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->artykulymodel->artykulyInsert());
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/artykulyAdd');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: /cms/artykuly/kategorie/".$parent_id."/artykuly');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: /cms/artykuly/kategorie/".$parent_id."/artykuly');
	            exit;
	        }
	    exit;
	}
	function artykulyEdit($parent_id, $id) {
	    $view = new View ;
	    $view->set('content', $this->artykulymodel->artykulyEdit($parent_id, $id));
	    $view->main_part = $view->render2('cms/artykulyAdd');
	    $view->render('cms/layouts/layout');
	}
	function artykulyDelete($parent_id, $id) {
	        include('lang/'.$_SESSION['cms_lang'].'.php'); 
	        $this -> artykulymodel -> artykulyDelete($parent_id, $id);
	            $_SESSION['pass'] = 'Usunięto';
	            header('Location: /cms/artykuly/kategorie/".$parent_id."/artykuly/list');
	            exit; 
	}
	function artykulyQueue()
	{
	    $this->artykulymodel->artykulyQueue();
	    exit;
	}
function artykulyGallery($parent_id, $id){
    $view = new View ;
    $view->set('content', $this->artykulymodel->artykulyGallery($parent_id, $id));
    $view->main_part = $view->render2('cms/artykulyGallery');
    $view->render('cms/layouts/layout');
}
function artykulyGalleryInsert($parent_id, $id) {
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->artykulymodel->artykulyGalleryInsert($parent_id, $id));
        $checkStatus = $view->get('content');
        // If error show again adding
        if ($checkStatus['status'] === 'error') {
                $back = new View ;
                $back->set ('content', $checkStatus);
                $back->main_part = $view->render2('cms/artykulyGallery');
                $back->render('cms/layouts/layout');
                exit;
        } elseif ($checkStatus['status'] === 'added') {
            $_SESSION['pass'] = $lang['Image added.'];
            header("Location: /cms/artykuly/kategorie/".$parent_id."/artykuly/".$id."/gallery");   
            exit;
        }
}
function artykulyGalleryDelete($parent_id, $id, $imageId) {       
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->artykulymodel->artykulyGalleryDelete($parent_id, $id, $imageId));
        $checkStatus = $view->get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted') {
            $_SESSION['pass'] = $lang['controller1'];
            header("Location: /cms/artykuly/kategorie/".$parent_id."/artykuly/".$id."/gallery");
            exit;
        }           
}
function artykulyGalleryEdit() {
    $this->artykulymodel->artykulyGalleryEdit();
    exit;
}
function artykulyGalleryUpdate($parent_id, $id) {
    include('lang/'.$_SESSION['cms_lang'].'.php'); 
    $this->artykulymodel->artykulyGalleryUpdate($parent_id, $id);
            $_SESSION['pass'] = $lang['Changes saved.'];
            header("Location: /cms/artykuly/kategorie/".$parent_id."/artykuly/".$id."/gallery");
            exit;
}
function artykulyGalleryQueue() {
    $this->artykulymodel->artykulyGalleryQueue();
    exit;
}
}