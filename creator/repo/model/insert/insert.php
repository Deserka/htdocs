<?php class a{
public function _CREATED_MODEL_NAME_Insert(/**_IDS_**/) {
    include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
	    $inputs = $_POST;
		$errors = [];
/**images_part1**/
/**images_part2**/
// INPUTS VALIDATION -------------------------------------------------------------------------            
    // Validate title - required
    if (empty( $_POST['title'])) {
        $errors[] = 'Wpisz tytuł';
    }  
// CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
    if (!empty( $errors )) {
    	/**type3_part1**/
        $return = [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs,
            /**type3_part2**/
        ];
        return $return;
    }  
/**images_part3**/
        // Url - Create URL based on title
        $url = mb_strtolower( $inputs['title'], 'UTF-8' );        
        $url = str_replace( $notAllowedCharacters, $substitutes, $url );   
/**tags1_part3**/
/**type2_part1**/
                $ins= $this->pdo->prepare('UPDATE _CREATED_TABLE_NAME_
                                            SET 											
                                            _CREATED_TABLE_PREFIX__url = :_CREATED_TABLE_PREFIX__url, _CREATED_TABLE_PREFIX__title = :_CREATED_TABLE_PREFIX__title, 
                                            _CREATED_TABLE_PREFIX__lang = :_CREATED_TABLE_PREFIX__lang, _CREATED_TABLE_PREFIX__hide = :_CREATED_TABLE_PREFIX__hide,
                                            _CREATED_TABLE_PREFIX__last_modified_date = NOW(), _CREATED_TABLE_PREFIX__last_modified_by = :_CREATED_TABLE_PREFIX__last_modified_by                                         
/**own_columns_part1**/
/**meta_tags_part1**/
/**images_part4**/
/**gallery_part1**/
                                            WHERE
                                            _CREATED_TABLE_PREFIX__lang = :_CREATED_TABLE_PREFIX__lang 
/**type2_part2**/
                                            ');
/**type2_part3**/
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
/**own_columns_part2**/	
/**meta_tags_part2**/
/**images_part5**/
/**gallery_part2**/
                $ins->execute();    
/**type2_part4**/
/**tags1_part5**/
        $return =  [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;
}
}/*delete*/