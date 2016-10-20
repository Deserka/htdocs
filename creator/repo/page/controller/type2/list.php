<?php
	function MODEL_NAMEList($pageNumber=NULL) {
		$view = new View();
		$view->set('content', $this -> MODEL_NAME ->MODEL_NAMEList($pageNumber));
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('MODEL_NAMEList');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}