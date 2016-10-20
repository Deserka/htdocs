<?php
class cms__CREATED_MODEL_NAME_Model extends Model{
	
public function _CREATED_MODEL_NAME_() {
	$query= $this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__id as id, _CREATED_TABLE_PREFIX__title as title, _CREATED_TABLE_PREFIX__url as url
								FROM _CREATED_TABLE_NAME_ 
		                        WHERE _CREATED_TABLE_PREFIX__lang = :lang 
		                        ORDER BY _CREATED_TABLE_PREFIX__queue ASC ,  _CREATED_TABLE_PREFIX__id DESC');
	$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
	$query->execute();	
	$result = $query->fetchAll();
        
    $content = 
    [
       'list' => $result,                    
    ];
    return $content;
}
 
public function _CREATED_MODEL_NAME_Edit() {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__lang = :lang ');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
/**tags1_part1**/
        $inputs = 
        [
            /** ALL **/
            'id'                => $result[0]['_CREATED_TABLE_PREFIX__id'],
            'title'             => $result[0]['_CREATED_TABLE_PREFIX__title'],
            'hide'              => $result[0]['_CREATED_TABLE_PREFIX__hide'],
            'lang'              => $result[0]['_CREATED_TABLE_PREFIX__lang'],
/**own_columns_part1**/
/**meta_tags_part1**/         
/**tags1_part2**/
/**image_part1**/
/**gallery_part1**/           			            
        ];
        
        $content = 
        [
            'inputs' => $inputs,
                        
        ];           
    
            return $content;
}


public function _CREATED_MODEL_NAME_Insert()
{
    include('config/configuration.php');

	    $inputs = $_POST;	
		$errors = [];	
		
/**image_part2**/
/**
 * INPUTS VALIDATION -------------------------------------------------------------------------       
**/      

    // Validate title - required
    if( empty( $_POST['title'] ) )
    {
        $errors[] = 'Wpisz tytuł';
    }  

/**
 * CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
**/ 
    if(!empty( $errors ))
    {
        $return = 
        [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs,         
            
        ];
        return $return;
    }  
    

/**image_part3**/

        // Url - Create URL based on title
        $url = mb_strtolower( $inputs['title'], 'UTF-8' );
            
/**validatearray**/
        $url = str_replace( $notAllowedCharacters, $substitutes, $url );   

/**tags1_part3**/
    

        
                $ins= $this->pdo->prepare('UPDATE _CREATED_TABLE_NAME_
                                            SET 
                                            											
                                            _CREATED_TABLE_PREFIX__url = :_CREATED_TABLE_PREFIX__url, _CREATED_TABLE_PREFIX__title = :_CREATED_TABLE_PREFIX__title, 
                                            _CREATED_TABLE_PREFIX__lang = :_CREATED_TABLE_PREFIX__lang, _CREATED_TABLE_PREFIX__hide = :_CREATED_TABLE_PREFIX__hide,
                                            _CREATED_TABLE_PREFIX__last_modified_date = NOW(), _CREATED_TABLE_PREFIX__last_modified_by = :_CREATED_TABLE_PREFIX__last_modified_by                                         
/**own_columns_part5**/
/**meta_tags_part5**/
/**image_part7**/
/**gallery_part5**/
                                            WHERE
                                            _CREATED_TABLE_PREFIX__lang = :_CREATED_TABLE_PREFIX__lang

                                            ');      
                        
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':_CREATED_TABLE_PREFIX__last_modified_by', $_SESSION['login'], PDO::PARAM_STR);					
/**own_columns_part4**/	
/**meta_tags_part4**/
/**image_part6**/
/**gallery_part4**/
                $ins->execute();      

/**tags1_part5**/

        $return = 
        [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;                  
    
}


function toolsDelete( $id )
{

/**gallery_part6**/
/**image_part8**/

                $ins= $this-> pdo-> prepare( 'DELETE FROM narzedzia WHERE narzedzie_id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();       
				 
    
}


function _CREATED_MODEL_NAME_Queue()
{
    $x = 1;
    foreach( $_POST['idek'] as $id)
    {
                $ins= $this->pdo->prepare('UPDATE _CREATED_TABLE_NAME_
                                            SET 
                                            _CREATED_TABLE_PREFIX__queue = :queue                                        
                                            WHERE
                                            _CREATED_TABLE_PREFIX__id = :idek');      
                        
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);                      
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                        
                $ins->execute();     
                
         $x++;    
    }    
}}/**delete**/
/**whole_gallery_model**/