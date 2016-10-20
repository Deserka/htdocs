<?php function _CREATED_MODEL_NAME_Gallery(/**_IDS_**/) {
        $query=$this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__img_id as id, _CREATED_TABLE_PREFIX__img_title as title, _CREATED_TABLE_PREFIX__img_url_cmsthumb as cmsthumb, _CREATED_TABLE_PREFIX__img_url as url  
                                    FROM _CREATED_TABLE_NAME__gallery
                                    /**type2_part1**/
                                    /**type3_child1_part1**/
                                    ORDER BY _CREATED_TABLE_PREFIX__img_queue ASC ,  _CREATED_TABLE_PREFIX__img_id DESC
                                        ');
		/**type2_part2**/
		/**type3_child1_part2**/
        $query->execute();
        $result = $query->fetchAll();
        $images = $result;
/**type2_part3**/
/**type3_child1_part3**/
/**type3_child1_part4**/
    $return = [
        'images' => $images,
/**type2_part4**/
/**type3_child1_part5**/
/**type3_child1_part6**/
    ];
    return $return;
}