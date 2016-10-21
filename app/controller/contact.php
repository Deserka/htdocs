<?php
class contactController extends Controller {
	function __construct() {
		$this->contact = new contactModel;
		$this -> all = new allModel;
    }
	function contact() {
		$view = new View();
		$view->set('content', $this -> contact ->contact());
	    $checkStatus = $view -> get('content');
	    	if (isset($checkStatus['status']) && $checkStatus['status'] === 'error404') {
	            return;
			}     
			$view->set('all', $this -> all -> all());
			$view -> main_part = $view -> render2('contact');
			$view -> meta_tags = $view -> render2('meta_tags');
			$view -> render('layouts/layout');
			exit;
	}
}