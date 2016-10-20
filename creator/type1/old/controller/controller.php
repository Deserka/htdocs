<?php 
class cms__CREATEDMODELNAME_Controller extends Controller{    
	function __construct() {   
	        $this->_CREATEDMODELNAME_model = new cms__CREATEDMODELNAME_Model;    
	    }
	function _CREATEDMODELNAME_Insert() {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->_CREATEDMODELNAME_model->_CREATEDMODELNAME_Insert());
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/_CREATEDMODELNAME_Add');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: _CREATEDURL_');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: _CREATEDURL_');   
	            exit;           
	        }
	    exit;
	}
	
	function _CREATEDMODELNAME_Edit() {
	    $view = new View ;
	    $view->set('content', $this->_CREATEDMODELNAME_model->_CREATEDMODELNAME_Edit());
	    $view->main_part = $view->render2('cms/_CREATEDMODELNAME_Add');
	    $view->render('cms/layouts/layout');
	}

	function _CREATEDMODELNAME_Queue()
	{
	    $this->_CREATEDMODELNAME_model->_CREATEDMODELNAME_Queue();
	    exit;
	}
}/*delete*/