<?php
class aktualnosciController extends Controller {
	function __construct() {
		$this->aktualnosci = new aktualnosciModel;
		$this -> all = new allModel;
    }
	function aktualnosciList($pageNumber=NULL) {
		$view = new View();
		$view->set('content', $this -> aktualnosci ->aktualnosciList($pageNumber));
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('aktualnosciList');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}
	function aktualnosciOne($id=NULL, $url=NULL) {
		$view = new View();
		$view->set('content', $this -> aktualnosci ->aktualnosciOne($id, $url));
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('aktualnosciOne');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}
}