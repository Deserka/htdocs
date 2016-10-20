<?php
function _CREATED_MODEL_NAME_GalleryUpdate(/**_IDS_**/) {
    include('lang/'.$_SESSION['cms_lang'].'.php'); 
    $this->_CREATED_MODEL_NAME_model->_CREATED_MODEL_NAME_GalleryUpdate(/**_IDS_**/);
            $_SESSION['pass'] = $lang['Changes saved.'];
            header("Location: _CREATED_GALLERY_URL_");
            exit;
}