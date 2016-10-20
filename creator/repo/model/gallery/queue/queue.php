<?php function _CREATED_MODEL_NAME_GalleryQueue() {
    $x = 1;
    foreach($_POST['idek'] as $id) {
    	$ins=$this->pdo->prepare('UPDATE _CREATED_TABLE_NAME__gallery
                                    SET 
                                    CREATED_TABLE_PREFIX__img_queue = :queue                                        
                                     WHERE
                                    CREATED_TABLE_PREFIX__img_id = :idek');
       $ins->bindValue(':queue', $x, PDO::PARAM_STR);
       $ins->bindValue(':idek', $id, PDO::PARAM_STR);
       $ins->execute(); 
       $x++;
    }
}