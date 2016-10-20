<?php
	function _CREATED_MODEL_NAME_Insert(/**_IDS_**/) {
	    include('lang/'.$_SESSION['cms_lang'].'.php'); 
	    $view = new View ;
	    $view->set('content', $this->_CREATED_MODEL_NAME_model->_CREATED_MODEL_NAME_Insert(/**_IDS_**/));
	        $checkStatus = $view->get('content');
	        if ($checkStatus['status'] === 'error') {
	                $back = new View ;
	                $back->set ('content', $checkStatus);
	                $back->main_part = $view->render2('cms/_CREATED_MODEL_NAME_Add');
	                $back->render('cms/layouts/layout');
	                exit;
	        } elseif ( $checkStatus['status'] === 'added' ) {
	            $_SESSION['pass'] = $lang['Added.'];
	            header('Location: _URL_BASIC_');       
	            exit;         
	        } elseif( $checkStatus['status'] === 'saved' ) {
	            $_SESSION['pass'] = $lang['Changes saved.'];
	            header('Location: _URL_BASIC2_');
	            exit;
	        }
	    exit;
	}