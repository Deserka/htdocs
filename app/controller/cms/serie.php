<?php
class cms_serieController extends Controller {
	function __construct() {   
	        $this->seriemodel = new cms_serieModel;
	    }
	function serieList($parent_id) {    
	    $view = new View ;
	    $view->set('content', $this->seriemodel->serie($parent_id));
	    $view->main_part = $view->render2('cms/serieList');
	    $view->render('cms/layouts/layout');  
	}
	function serieAdd($parent_id){
	    $view = new View ;
	    $view -> set('content', $this ->seriemodel->serieAdd($parent_id));
	    $view -> main_part = $view -> render2('cms/serieAdd');
	    $view -> render('cms/layouts/layout');
	}
	function serieInsert($parent_id) {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->seriemodel->serieInsert($parent_id));
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/serieAdd');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: /cms/produkty/kategorie/'.$parent_id.'/serie');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: /cms/produkty/kategorie/'.$parent_id.'/serie');
	            exit;
	        }
	    exit;
	}
	function serieEdit($parent_id, $id) {
	    $view = new View ;
	    $view->set('content', $this->seriemodel->serieEdit($parent_id, $id));
	    $view->main_part = $view->render2('cms/serieAdd');
	    $view->render('cms/layouts/layout');
	}
	function serieDelete($parent_id, $id) {
	        include('lang/'.$_SESSION['cms_lang'].'.php'); 
	        $this -> seriemodel -> serieDelete($parent_id, $id);
	            $_SESSION['pass'] = 'Usunięto';
	            header('Location: /cms/produkty/kategorie/'.$parent_id.'/serie/list');
	            exit; 
	}
	function serieQueue($parent_id)
	{
	    $this->seriemodel->serieQueue($parent_id);
	    exit;
	}
function serieGallery($parent_id, $id){
    $view = new View ;
    $view->set('content', $this->seriemodel->serieGallery($parent_id, $id));
    $view->main_part = $view->render2('cms/serieGallery');
    $view->render('cms/layouts/layout');
}
function serieGalleryInsert($parent_id, $id) {
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->seriemodel->serieGalleryInsert($parent_id, $id));
        $checkStatus = $view->get('content');
        // If error show again adding
        if ($checkStatus['status'] === 'error') {
                $back = new View ;
                $back->set ('content', $checkStatus);
                $back->main_part = $view->render2('cms/serieGallery');
                $back->render('cms/layouts/layout');
                exit;
        } elseif ($checkStatus['status'] === 'added') {
            $_SESSION['pass'] = $lang['Image added.'];
            header("Location: /cms/produkty/kategorie/".$parent_id."/serie/".$id."/gallery");   
            exit;
        }
}
function serieGalleryDelete($parent_id, $id, $imageId) {       
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->seriemodel->serieGalleryDelete($parent_id, $id, $imageId));
        $checkStatus = $view->get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted') {
            $_SESSION['pass'] = $lang['controller1'];
            header("Location: /cms/produkty/kategorie/".$parent_id."/serie/".$id."/gallery");
            exit;
        }           
}
function serieGalleryEdit() {
    $this->seriemodel->serieGalleryEdit();
    exit;
}
function serieGalleryUpdate($parent_id, $id) {
    include('lang/'.$_SESSION['cms_lang'].'.php'); 
    $this->seriemodel->serieGalleryUpdate($parent_id, $id);
            $_SESSION['pass'] = $lang['Changes saved.'];
            header("Location: /cms/produkty/kategorie/".$parent_id."/serie/".$id."/gallery");
            exit;
}
function serieGalleryQueue() {
    $this->seriemodel->serieGalleryQueue();
    exit;
}
}