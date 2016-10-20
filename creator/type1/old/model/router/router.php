<?php if(1==1){}
   elseif ($_SERVER['REQUEST_URI'] === '/cms/_CREATEDURL_') {
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_Edit();
        exit;
    } elseif ($_SERVER['REQUEST_URI'] === '/cms/_CREATEDURL_/zapisz') {
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_Insert(); 
        exit;
    }