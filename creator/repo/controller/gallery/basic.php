<?php
function _CREATED_MODEL_NAME_Gallery(/**_IDS_**/){
    $view = new View ;
    $view->set('content', $this->_CREATED_MODEL_NAME_model->_CREATED_MODEL_NAME_Gallery(/**_IDS_**/));
    $view->main_part = $view->render2('cms/_CREATED_MODEL_NAME_Gallery');
    $view->render('cms/layouts/layout');
}