<?php if(1==1){}
	elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_Gallery($id);
        exit;
    } elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria\/zapisz$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria\/zapisz$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_GalleryInsert($id);
        exit;
    } elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria\/edytuj$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria\/edytuj$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_GalleryEdit($id);
        exit;
    } elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria\/aktualizuj$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria\/aktualizuj$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_GalleryUpdate($id);
        exit;
    } elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria\/[0-9]+\/usun$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria\/([0-9]+)\/usun$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];    
		$image_id = $neededVariables[2];         	
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_GalleryDelete($id, $image_id);
        exit;
    } elseif (preg_match('/^\/cms\/_CREATEDURL_\/[0-9]+\/galeria\/aktualizuj-kolejnosc$/', $_SERVER['REQUEST_URI'])) {
		$o = preg_match('/^\/cms\/_CREATEDURL_\/([0-9]+)\/galeria\/aktualizuj-kolejnosc$/', $_SERVER['REQUEST_URI'], $neededVariables);
        $id = $neededVariables[1];     	
        $ob = new cms__CREATEDMODELNAME_Controller;
        $ob->_CREATEDMODELNAME_GalleryQueue();
        exit;
    }