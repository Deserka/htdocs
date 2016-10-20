<?php
	function MODEL_NAMEOne($id=NULL, $url=NULL) {
		$view = new View();
		$view->set('content', $this -> MODEL_NAME ->MODEL_NAMEOne($id, $url));
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('MODEL_NAMEOne');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}