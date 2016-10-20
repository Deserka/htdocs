<?php function _CREATED_MODEL_NAME_GalleryDelete(/**_IDS_**/) {
	$query=$this->pdo->prepare('SELECT  _CREATED_TABLE_PREFIX__img_url_cmsthumb as cmsthumb, 
        									/**thumbs_part1**/
        									_CREATED_TABLE_PREFIX__img_url as url
        							FROM _CREATED_TABLE_NAME__gallery WHERE _CREATED_TABLE_PREFIX__img_id = :id ');
        $query->bindValue(':id', $imageId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb']);
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['url'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['url']);
        }
		/**thumbs_part2**/             
                $ins=$this->pdo->prepare('DELETE FROM _CREATED_TABLE_NAME__gallery WHERE _CREATED_TABLE_PREFIX__img_id = :id ');      
                $ins->bindValue(':id', $imageId, PDO::PARAM_STR);
                $ins->execute(); 
         $return = [
            'status' => 'deleted',
         ];
         return $return;
}