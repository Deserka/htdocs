<?php
	function _CREATED_MODEL_NAME_() {
		$view = new View();
		$view->set('content', $this -> _CREATED_MODEL_NAME_ ->_CREATED_MODEL_NAME_());
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('_CREATED_MODEL_NAME_');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}