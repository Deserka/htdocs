<?php
	function _CREATED_MODEL_NAME_Delete(/**_IDS_**/) {
	        include('lang/'.$_SESSION['cms_lang'].'.php'); 
	        $this -> _CREATED_MODEL_NAME_model -> _CREATED_MODEL_NAME_Delete(/**_IDS_**/);
	            $_SESSION['pass'] = 'Usunięto';
	            header('Location: _URL_AD_BASIC_');
	            exit; 
	}