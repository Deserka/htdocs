<?php
class cms_cmsController extends Controller{
	
	function __construct() {  	
			$this -> cms = new cms_cmsModel;	
	    }  
	function login() {
		$view = new View ;
		// If they didn;t try to login yet..
		if (!isset($_POST['login']) && !isset($_POST['password'])) {
			$view -> content = $view -> render2('cms/login_content');
			$view -> render('cms/layouts/empty');
			exit;
		}
		$view->set('login', $this -> cms -> login($_POST));
		$checker = $view -> get('login');
		if ($checker[0] === 0) {
			$_SESSION['loginError'] = $checker[1];
			header('Location: /cms');
			exit;
			$view = new View ;
			$view -> set ('back', $checker[1]);
			$view -> content = $view -> render2('cms/login_content');
			$view -> render('cms/layouts/empty');
			exit;
		} elseif ($checker[0] === 1) {
			session_start();
			$_SESSION['id'] = $checker[1];
			$_SESSION['login'] = $checker[2];
			$_SESSION['cms_lang'] = $checker[3];
			header("Location: /cms");
			exit;
		}
	}
	
	function logout() {
		session_unset(); 
		session_destroy(); 
		header("Location: /cms");
		exit;
	}

	function cms_lang_change() {
		$this -> cms -> cms_lang_change($_POST);	
	}	

	function editing_lang_change() {
	    $this -> cms -> editing_lang_change();
	}

	function index() {
		$view = new View ;
		$view -> main_part = $view -> render2('cms/index_content');
		$view -> render('cms/layouts/layout');	
	}	

	function sitemap() {
		$view = new View ;
	    $view->set('content', $this -> cms -> sitemap());
	    $view -> main_part = $view -> render2('cms/sitemap');
	    $view -> render('cms/layouts/layout');    
	}

	function generateSitemap() {
	    $this -> cms -> generateSitemap();
	}
	
	function er404() {
		header("HTTP/1.0 404 Not Found");
	    $er404 = new View();
	    $er404 -> main_part = $er404  -> render2('cms/error404');
	    $er404 -> render('cms/layouts/layout');    
	    exit;           
	}

}