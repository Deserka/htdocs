<?php
class indexController extends Controller{
	function __construct() {
		$this -> index = new indexModel;
    }
/*
	function sitemap() {
		$view = new View();
		$view->set('content', $this -> index->sitemap());
		header('Location: /sitemaps.xml');
		exit;
	}	
*/
	function er404() {
		header("HTTP/1.0 404 Not Found");
		$er404 = new View();
		//$view->set('content', $this -> index->er404());
		//$er404 -> set('all', $this -> index->all());
		$er404 -> meta_tags = $er404 -> render2('meta_tags');
		$er404 -> main_part = $er404  -> render2('error404');
		$er404 -> render('layouts/layout');   
		exit;   		
	}
 
	function search() {
		$view = new View();
		$view->set('content', $this -> index->search($_GET));
		$view -> set('all', $this -> index->all());
		$view -> main_part = $view -> render2('search');
		$view -> render('layouts/layout');	
		exit;
	}








// all down from here to delete

/*
 * ###################################################################################### HOMEPAGE #################################################################################################
 * */
 /**
	 * SHOW HOMEPAGE
	 */
function homepage() 
{
		$view = new View();
		$view->set('content', $this -> index->homepage());
            $checkStatus = $view -> get('content');
            if($checkStatus['status'] === 'error404')
            {
                header("HTTP/1.0 404 Not Found");
                $er404 = new View();
                $er404 -> set('all', $this -> index->all());
                $er404 -> main_part = $view -> render2('error404');
                $er404 -> render('layouts/layout'); 
                exit;           
            }        
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('main_content');
		$view -> meta_tags = $view -> render2('meta_tags');
		$view -> render('layouts/layout');		
}

/*
 * ###################################################################################### PAGES #################################################################################################
 * */
 /**
	 * SHOW ONE PAGE
	 */
 function page()
{
        $o = preg_match('/^\/s-([a-zA-Z0-9_]+)+-([\d]+)$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $url = $neededVariables[1];
        $id = $neededVariables[2];

		$view = new View();
		$view->set('content', $this -> index->page($url, $id)); // CONTENT OF PAGE TO SHOW 
			$checkStatus = $view -> get('content');
			if($checkStatus['status'] === 'error404')
			{
				header("HTTP/1.0 404 Not Found");
				$er404 = new View();
				$er404 -> set('all', $this -> index->all());
				$er404 -> main_part = $view -> render2('error404');
				$er404 -> render('layouts/layout');	
				exit;			
			}
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('page_content');
		$view -> meta_tags = $view -> render2('meta_tags');
		$view -> render('layouts/layout');
	
}
	
/*
 * ###################################################################################### ARTICLES #################################################################################################
 * */
 /**
	 * SHOW ALL ARTICLES
	 */
function articles()	
{
		$view = new View;
		$view->set('articles', $this -> index ->articles()); 
		$view->set('all', $this -> index->all());
		$view -> render('articles');		
}

 /**
	 * SHOW ONE ARTICLE
	 */   
function article()
{	
		$view = new View();
		$view->set('content', $this -> index->article($_GET));
		$view -> main_part = $view -> render2('article_content');
		$view->set('all', $this -> index->all());
		$view -> meta_tags = $view -> render2('meta_tags');
		$view -> render('layouts/layout');	
}	
 
 /*
 * ###################################################################################### CATEGORIES #################################################################################################
 * */
 /**
	 * SHOW ONE CATEGORIE WITH 10 ARTICLES
	 */
	 
function categorie_divided()
{
		
		$view = new View();
		$view->set('content', $this -> index->categorie_divided($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('categorie_content');
		$view -> meta_tags = $view -> render2('categorie_meta_tags');
		$view -> render('layouts/layout');	


}	 

function subcategorie_divided()
{
		
		$view = new View();
		$view->set('content', $this -> index->subcategorie_divided($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('subcategorie_content');
		$view -> meta_tags = $view -> render2('subcategorie_meta_tags');
		$view -> render('layouts/layout');	


}	 

 /*
 * ###################################################################################### TAGS #################################################################################################
 * */
 /**
	 * SHOW ARTICLES BY ONE TAG
	 */
	 
function tag_one()
{
		
		$view = new View();
		$view->set('content', $this -> index->tag_one($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('tag_one_content');
		$view -> meta_tags = $view -> render2('tag_one_meta_tags');
		$view -> render('layouts/layout');	


}	 
 /*
 * ###################################################################################### NEWS #################################################################################################
 * */
 /**
	 * SHOW 10 NEWS
	 */
	 
function news_divided()
{
		
		$view = new View();
		$view->set('content', $this -> index->news_divided($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('news_divided_content');
		$view -> meta_tags = $view -> render2('news_divided_meta_tags');
		$view -> render('layouts/layout');	
}

function news_one()
{	
		$view = new View();
		$view->set('content', $this -> index->news_one($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('news_one_content');
		$view -> meta_tags = $view -> render2('news_one_meta_tags');
		$view -> render('layouts/layout');	
}		 
	 
  /*
 * ###################################################################################### COMMENTS #################################################################################################
 * */
 
   /**
	 * LOAD COMMENTS
	 */	
	 
function load_comments()
{	
		$this -> index -> load_comments($_POST);
}	

  /**
	 * ADD COMMENT
	 */	
	 
function add_comment()
{

		$this -> index -> add_comment($_POST);
}	 

function checkSessionLogin()
{
    $this -> index -> checkSessionLogin();
}

function captchaComments()
{
    $this -> index -> captchaComments();
}
	 
	 
	 
	 
 /*
 * ###################################################################################### GALLERIES #################################################################################################
 * */
 /**
	 * SHOW ONE GALLERY WITH 10 IMAGES
	 */
	 
function gallery_divided()
{
		
		$view = new View();
		$view->set('content', $this -> index->gallery_divided($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('gallery_divided_content');
		$view -> meta_tags = $view -> render2('gallery_meta_tags');
		$view -> render('layouts/layout');	


}	

function gallery_one_image()
{
		
		$view = new View();
		$view->set('content', $this -> index->gallery_one_image($_GET));
		$view->set('all', $this -> index->all());
		$view -> main_part = $view -> render2('gallery_one_image');
		$view -> meta_tags = $view -> render2('gallery_one_image_meta_tags');
		$view -> render('layouts/layout');	


}	

function download_wallpaper()
{
		
$filename = 'http://www.gramywlola.eu/public/images/uploads/mems/my%20family.jpg';//wybieramy plik do ściągnięcia
header('Content-Type:application/force-download');//ustawiamy mu uniwersalny typ mime (można bawić się w nadawanie mu application/msword, image/gif, itd...
header('Content-Disposition: attachment; filename="'.basename($filename).'";');//tutaj podajemy nazwę pliku - domyślnie ustawiłem, aby plik nazywał się tak jak oryginał
//header('Content-Length:'.@filesize($filename));//dodajemy wielkość pliku
@readfile($filename)or die('File not found.');//czytamy plik  

}	







	 

}
?>