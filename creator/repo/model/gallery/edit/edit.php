<?php function _CREATED_MODEL_NAME_GalleryEdit() {
       $idek = $_POST['idek'];
            $query=$this->pdo->prepare( 'SELECT 
            								_CREATED_TABLE_PREFIX__img_title, 
            								_CREATED_TABLE_PREFIX__img_content, 
            								_CREATED_TABLE_PREFIX__img_meta_title, 
            								_CREATED_TABLE_PREFIX__img_alt, 
            								_CREATED_TABLE_PREFIX__img_file_name, 
            								_CREATED_TABLE_PREFIX__img_url_cmsthumb                              
                                          FROM _CREATED_TABLE_NAME__gallery
                                          WHERE _CREATED_TABLE_PREFIX__img_id = :idek
                                            ');
			$query->bindValue(':idek', $idek, PDO::PARAM_STR);
            $query->execute();  
            $result = $query->fetchAll();   
        $content = [
            'id'            => $idek,
            'title'        => $result[0]['_CREATED_TABLE_PREFIX__img_title'],
            'content'     => $result[0]['_CREATED_TABLE_PREFIX__img_content'],
            'meta_title'   => $result[0]['_CREATED_TABLE_PREFIX__img_meta_title'],
            'alt'           => $result[0]['_CREATED_TABLE_PREFIX__img_alt'],
            'file_name'    => $result[0]['_CREATED_TABLE_PREFIX__img_file_name'],   
            'cmsthumb'      => $result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'],        
        ];
            echo json_encode($content);
}