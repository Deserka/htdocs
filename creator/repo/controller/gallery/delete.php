<?php
function _CREATED_MODEL_NAME_GalleryDelete(/**_IDS_**/) {       
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->_CREATED_MODEL_NAME_model->_CREATED_MODEL_NAME_GalleryDelete(/**_IDS_**/));
        $checkStatus = $view->get('content');
        // If error show again adding
        if($checkStatus['status'] === 'deleted') {
            $_SESSION['pass'] = $lang['controller1'];
            header("Location: _CREATED_GALLERY_URL_");
            exit;
        }           
}