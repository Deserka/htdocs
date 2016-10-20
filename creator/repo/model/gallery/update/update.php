<?php function _CREATED_MODEL_NAME_GalleryUpdate(/**_IDS_**/) {
		// Take extension from path
		function extensionFromPath ($path) {
			$extension =  explode ( '.', $path );
			$extension = end( $extension );
			return $extension;
		}
			
		// Create image name 
		function createImageName($array) {
			foreach($array as $name){
				if(!empty($name)){
					return $name;
				}
			}
			return uniqid();
		}	
		// Prepare name - from normal sentence to URL os sth
		function prepareName($name){
			// to lowercase
			$name = mb_strtolower( $name, 'UTF-8' );
			// delete unwanted characters

include('creator/repo/allowed_characters/arrays.php');	
			$name = str_replace( $notAllowedCharacters, $substitutes, $name ); 	
			// Delete more '-' than 1
			$name = preg_replace('/-{2,}/', '-', $name);			
			// Trim '-'
			$name = trim($name, '-');	
			return $name;													
		}		
	
		// Check if file with this name exist - if yes - add number at the end
		function checkFileName ( $path, $name, $extension, $delimer=NULL, $number=NULL ){
			if( file_exists( $path.$name.$delimer.$number.'.'.$extension ) ){				
				if ($number === NULL) {
					$number = 1;
				} else {
					$number = $number + 1;
				}
				if( $delimer === NULL ){
					$delimer = '-';
				}				
				return checkFileName ( $path, $name, $extension, $delimer, $number );
			} else {
				return $name.$delimer.$number;
			}
		}		
            $query=$this->pdo->prepare( 'SELECT 
            								_CREATED_TABLE_PREFIX__img_url,
            								/**thumbs_part1**/
            								_CREATED_TABLE_PREFIX__img_url_cmsthumb
                                        FROM _CREATED_TABLE_NAME__gallery
                                          WHERE _CREATED_TABLE_PREFIX__img_id = :idek  ');  
            $query->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);                                                                                           
            $query->execute();  
            $result = $query->fetchAll();  
			$old_mysql = $result[0]['_CREATED_TABLE_PREFIX__img_url'];
		    // Create name of image
		    $arr = array($_POST['edit-file-name'], $_POST['edit-meta-description'], $_POST['edit-meta-title'], $_POST['edit-title']);
		    $currName = createImageName($arr);		
			$currName = prepareName($currName);
			
            if (!strpos($old_mysql, $currName)) {
            	$extension = extensionFromPath($old_mysql);
				$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/original/', $currName, $extension );	
              
                $original = '/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/original/'.$currName.'.'.$extension;
                $cmsthumb = '/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/cms_thumb/'.$currName.'.'.$extension;
				/**thumbs_part2**/
                    // Original photo
                    if (!empty($result[0]['_CREATED_TABLE_PREFIX__img_url'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url'], $_SERVER['DOCUMENT_ROOT'].$original);
                    }                
                    if (!empty($result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'], $_SERVER['DOCUMENT_ROOT'].$cmsthumb);
                    }
					/**thumbs_part3**/
                    
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url']);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb']);
                    }
					/**thumbs_part4**/
            } else {
                $original = $result[0]['_CREATED_TABLE_PREFIX__img_url'];
                $cmsthumb = $result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'];
				/**thumbs_part5**/
            }
                $ins=$this->pdo->prepare('UPDATE _CREATED_TABLE_NAME__gallery
                                            SET 
                                            	_CREATED_TABLE_PREFIX__img_url = :url,
                                            	_CREATED_TABLE_PREFIX__img_url_cmsthumb = :cmsthumb,
                                            /**thumbs_part10**/
                                           	 	_CREATED_TABLE_PREFIX__img_title = :title, _CREATED_TABLE_PREFIX__img_content = :content, _CREATED_TABLE_PREFIX__img_meta_title = :meta_title, 
                                            	_CREATED_TABLE_PREFIX__img_alt = :alt, _CREATED_TABLE_PREFIX__img_file_name = :file_name                                           
                                            WHERE
                                            	_CREATED_TABLE_PREFIX__img_id = :idek');
                        
                        $ins->bindValue(':title', $_POST['edit-title'], PDO::PARAM_STR);
                        $ins->bindValue(':content', $_POST['edit-description'], PDO::PARAM_STR);
                        $ins->bindValue(':meta_title', $_POST['edit-meta-title'], PDO::PARAM_STR);
                        $ins->bindValue(':alt', $_POST['edit-meta-description'], PDO::PARAM_STR);
                        $ins->bindValue(':file_name', $_POST['edit-file-name'], PDO::PARAM_STR);
                        $ins->bindValue(':url', $original, PDO::PARAM_STR);
                        $ins->bindValue(':cmsthumb', $cmsthumb, PDO::PARAM_STR);
						/**thumbs_part6**/
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                        
                $ins->execute();      
}