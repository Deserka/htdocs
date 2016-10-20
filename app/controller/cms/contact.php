<?php
class cms_contactController extends Controller {
	function __construct() {   
	        $this->contactmodel = new cms_contactModel;
	    }
	function contactInsert(/**_IDS_**/) {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->contactmodel->contactInsert(/**_IDS_**/));
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/contactAdd');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: /cms/kontakt/edit');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: /cms/kontakt/edit');
	            exit;
	        }
	    exit;
	}
	function contactEdit(/**_IDS_**/) {
	    $view = new View ;
	    $view->set('content', $this->contactmodel->contactEdit(/**_IDS_**/));
	    $view->main_part = $view->render2('cms/contactAdd');
	    $view->render('cms/layouts/layout');
	}
	function contactQueue(/**_IDS_**/)
	{
	    $this->contactmodel->contactQueue(/**_IDS_**/);
	    exit;
	}
function contactGallery(/**_IDS_**/){
    $view = new View ;
    $view->set('content', $this->contactmodel->contactGallery(/**_IDS_**/));
    $view->main_part = $view->render2('cms/contactGallery');
    $view->render('cms/layouts/layout');
}
function contactGalleryInsert(/**_IDS_**/) {
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->contactmodel->contactGalleryInsert(/**_IDS_**/));
        $checkStatus = $view->get('content');
        // If error show again adding
        if ($checkStatus['status'] === 'error') {
                $back = new View ;
                $back->set ('content', $checkStatus);
                $back->main_part = $view->render2('cms/contactGallery');
                $back->render('cms/layouts/layout');
                exit;
        } elseif ($checkStatus['status'] === 'added') {
            $_SESSION['pass'] = $lang['Image added.'];
            header("Location: /cms/kontakt/gallery");   
            exit;
        }
}
function contactGalleryDelete($imageId) {       
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->contactmodel->contactGalleryDelete($imageId));
        $checkStatus = $view->get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted') {
            $_SESSION['pass'] = $lang['controller1'];
            header("Location: /cms/kontakt/gallery");
            exit;
        }           
}
function contactGalleryEdit(/**_IDS_**/) {
    $this->contactmodel->contactGalleryEdit(/**_IDS_**/);
    exit;
}
function contactGalleryUpdate(/**_IDS_**/) {
    include('lang/'.$_SESSION['cms_lang'].'.php'); 
    $this->contactmodel->contactGalleryUpdate(/**_IDS_**/);
            $_SESSION['pass'] = $lang['Changes saved.'];
            header("Location: /cms/kontakt/gallery");
            exit;
}
function contactGalleryQueue() {
    $this->contactmodel->contactGalleryQueue();
    exit;
}
}