<?php class a{
function _CREATED_MODEL_NAME_Delete(/**_IDS_**/) {
/**images_part1**/
/**gallery_part1**/
                $ins= $this-> pdo-> prepare( 'DELETE FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();
}
}/*delete*/