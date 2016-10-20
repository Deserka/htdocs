<?php
/* <!-- type2 part 1 */
if (empty( $inputs['id'])) {
	$ins = $this ->pdo ->prepare( 'UPDATE _CREATED_TABLE_NAME_
									SET 
                                   _CREATED_TABLE_PREFIX__queue = _CREATED_TABLE_PREFIX__queue + 1
                                 ');
	$ins->execute();
    $ins = $this -> pdo -> prepare(' INSERT INTO 
                                            _CREATED_TABLE_NAME_ 
                                            (_CREATED_TABLE_PREFIX__url, _CREATED_TABLE_PREFIX__title, _CREATED_TABLE_PREFIX__created_date, _CREATED_TABLE_PREFIX__created_by, 
                                            _CREATED_TABLE_PREFIX__lang, _CREATED_TABLE_PREFIX__queue, _CREATED_TABLE_PREFIX__hide
/**own_columns_part3**/
/**meta_tags_part3**/
/**images_part6**/
/**gallery_part3**/
/**type3_part3**/
											) 
                                            VALUES 
                                            ( :_CREATED_TABLE_PREFIX__url, :_CREATED_TABLE_PREFIX__title, NOW(), :_CREATED_TABLE_PREFIX__created_by, :_CREATED_TABLE_PREFIX__lang, :_CREATED_TABLE_PREFIX__queue, :_CREATED_TABLE_PREFIX__hide  
/**own_columns_part4**/
/**meta_tags_part4**/
/**images_part7**/
/**gallery_part4**/
/**type3_part4**/
                                            ) 											
                                     ');   
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__queue', 0, PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__created_by', $_SESSION['login'], PDO::PARAM_STR);
/**own_columns_part5**/
/**meta_tags_part5**/
/**images_part8**/
/**gallery_part5**/
/**type3_part5**/
                $ins->execute(); 
/*tags1_part4*/
        $return = [
            'status' => 'added',
        ];
        return $return;
} else {
/* --> end type2 part 1 */