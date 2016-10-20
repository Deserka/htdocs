<?php

class cms_cmshomepageController extends Controller{
    
function __construct()
    {   
        $this -> cmshomepage = new cms_cmshomepageModel;  
    }
     
 

/*
 * ###################################################################################### PAGES #################################################################################################
 * */   
// Open template with all pages
function homepage(){   
    $view = new View ;
    $view -> main_part = $view -> render2('cms/homepageList');
    $view -> render('cms/layouts/layout');
}

function homepageEdit(){   
    $view = new View ;
    $view->set('content', $this -> cmshomepage -> homepageEdit());
    $view -> main_part = $view -> render2('cms/homepageAdd');
    $view -> render('cms/layouts/layout');
}

// Insert data to database - new page
function homepageInsert(){
    $view = new View ;
    $view -> set('content', $this -> cmshomepage -> homepageInsert());
        $checkStatus = $view -> get('content');
        // If error show again adding
        if($checkStatus['status'] === 'error')
        {
                $back = new View ;
                $back -> set ('content', $checkStatus);
                $back -> main_part = $view -> render2('cms/homepageAdd');
                $back -> render('cms/layouts/layout');
                exit;
        }
        elseif($checkStatus['status'] === 'saved')
        {
            $_SESSION['pass'] = "Zmiany zostały zapisane.";
            header('Location: /cms-strona-glowna');   
            exit;           
        }
    exit;
}

function pageEdit(){
        $o = preg_match('/^\/cms-strony-edytuj-([0-9]+)$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];

    $view = new View ;
    $view->set('content', $this -> cmspages->pageEdit($id));
    $view -> main_part = $view -> render2('cms/pages_pageAdd');
    $view -> render('cms/layouts/layout');
}

function pageDelete()
{
        $o = preg_match('/^\/cms-strony-usun-([0-9]+)$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];
        
        $this -> cmspages -> pageDelete($id);
        
            $_SESSION['pass'] = "Strona została usunięta.";
            header('Location: /cms-strony');   
            exit;   

}

function pageEditGallery(){
        $o = preg_match('/^\/cms-strony-edytuj-([0-9]+)-galeria$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];

    $view = new View ;
    $view->set('content', $this -> cmspages->pageEditGallery($id));
    $view -> main_part = $view -> render2('cms/pages_pageEditGallery');
    $view -> render('cms/layouts/layout');
}

function pageEditGalleryInsertImage(){
    $view = new View ;
    $view -> set('content', $this -> cmspages->pageEditGalleryInsertImage());
        $checkStatus = $view -> get('content');
        // If error show again adding
        if($checkStatus['status'] === 'error')
        {
                $back = new View ;
                $back -> set ('content', $checkStatus);
                $back -> main_part = $view -> render2('cms/pages_pageEditGallery');
                $back -> render('cms/layouts/layout');
                exit;
        }
        elseif($checkStatus['status'] === 'added')
        {
            $_SESSION['pass'] = "Zdjęcie zostało dodane.";
            header('Location: /cms-strony-edytuj-'.$checkStatus['id'].'-galeria');   
            exit;       
        }

}

function pageEditGalleryDeleteImage()
{
        $o = preg_match('/^\/cms-strony-edytuj-([0-9]+)-galeria-usun-([0-9]+)$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $gal_id = $neededVariables[1]; 
        $id = $neededVariables[2];   
         

    $view = new View ;
    $view -> set('content', $this -> cmspages->pageEditGalleryDeleteImage($id));
        $checkStatus = $view -> get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted')
        {
            $_SESSION['pass'] = "Zdjęcie zostało usunięte.";
            header('Location: /cms-strony-edytuj-'.$gal_id.'-galeria');   
            exit;  
        }           
}


function pageEditGalleryEditImage()
{
    $this -> cmspages -> pageEditGalleryEditImage();
    exit;
}

function pageEditGalleryEditImageUpdate()
{
 
    $this -> cmspages -> pageEditGalleryEditImageUpdate();
    
            $_SESSION['pass'] = "Zmiany zostały zapisane.";
            header('Location: /cms-strony-edytuj-'.$_POST['page-id'].'-galeria');   
            exit;      
}


function pageEditGalleryEditImagesQueue()
{
    $this -> cmspages -> pageEditGalleryEditImagesQueue();
    exit;
}


function pageEditQueue()
{
    $this -> cmspages -> pageEditQueue();
    exit;
}









}

?>