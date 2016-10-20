<?php
function _CREATED_MODEL_NAME_GalleryInsert(/**_IDS_**/) {
    include('lang/'.$_SESSION['cms_lang'].'.php');
    $view = new View ;
    $view->set('content', $this->_CREATED_MODEL_NAME_model->_CREATED_MODEL_NAME_GalleryInsert(/**_IDS_**/));
        $checkStatus = $view->get('content');
        // If error show again adding
        if ($checkStatus['status'] === 'error') {
                $back = new View ;
                $back->set ('content', $checkStatus);
                $back->main_part = $view->render2('cms/_CREATED_MODEL_NAME_Gallery');
                $back->render('cms/layouts/layout');
                exit;
        } elseif ($checkStatus['status'] === 'added') {
            $_SESSION['pass'] = $lang['Image added.'];
            header("Location: _CREATED_GALLERY_URL_");   
            exit;
        }
}