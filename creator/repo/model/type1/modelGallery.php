<?php class a { public function _CREATED_MODEL_NAME_Gallery() 
{
        $query=$this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__img_id as id, _CREATED_TABLE_PREFIX__img_title as title, _CREATED_TABLE_PREFIX__img_url_cmsthumb as cmsthumb, _CREATED_TABLE_PREFIX__img_url as url  
                                    FROM _CREATED_TABLE_NAME__gallery
                                    ORDER BY _CREATED_TABLE_PREFIX__img_queue ASC ,  _CREATED_TABLE_PREFIX__img_id DESC
                                        ');
        $query->execute();
        $result = $query->fetchAll();
        $images = $result;
            
    $return = 
    [
        'images' => $images
    ];
    
    return $return;
}

public function _CREATED_MODEL_NAME_GalleryInsert()
{
	include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
    $inputs = $_POST;

		// Check if file with this name exist - if yes - add number at the end
		function checkFileName ( $path, $name, $extension, $delimer=NULL, $number=NULL ){
			if( file_exists( $path.$name.$delimer.$number.'.'.$extension ) ){				
				if( $number === NULL ){
					$number = 1;
				}
				else{
					$number = $number + 1;
				}
				if( $delimer === NULL ){
					$delimer = '-';
				}				
				return checkFileName ( $path, $name, $extension, $delimer, $number );
			}
			else {
				return $name.$delimer.$number;
			}
		}		

		// Create image name 
		function createImageName($array){
			
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

    if(!empty($_FILES['image']['name']))
    {
        $allowedExts = array('gif', 'jpeg', 'jpg', 'png');
        $tempImage = explode('.', $_FILES['image']['name']);
        $extension = end($tempImage);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);  
        $imageDimension = getimagesize($_FILES['image']['tmp_name']);
        $imageWidth = $imageDimension[0];
        $imageHeight = $imageDimension[1];   
    }    
    
    if(empty($_FILES['image']['name']))
    {
        $errors[] = 'Wybierz zdjęcie';  
    }
     
        
        elseif ( ($mime !== 'image/gif') && ($mime !== 'image/jpeg') && ($mime !== 'image/pjpeg') && ($mime !== 'image/x-png') && ($mime !== 'image/png'))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif(!in_array(strtolower($extension), $allowedExts))
        {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif($_FILES['image']['size'] > $configuration['_CREATED_CONFIG_NAME__gallery_max_size'] * 1000)
        {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['_CREATED_CONFIG_NAME__gallery_max_size']/1000).'mb - '.($configuration['_CREATED_CONFIG_NAME__gallery_max_size']).'kb)';
        } 
        elseif($imageWidth > $configuration['_CREATED_CONFIG_NAME__gallery_max_width'])
        {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['_CREATED_CONFIG_NAME__gallery_max_width'].'px)';
        }
        elseif($imageHeight > $configuration['_CREATED_CONFIG_NAME__gallery_max_height'])
        {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['_CREATED_CONFIG_NAME__gallery_max_height'].'px)';
        }    
    
        if(!empty($errors))
        {
        $return = 
        [
            'inputs' => $_POST,
            'errors' => $errors,
            'status' => 'error'
        ];       
        return $return;      
        }
            

    // Create name of image
    $arr = array($_POST['image_file_name'], $_POST['image_meta_description'], $_POST['image_meta_title'], $_POST['image_title']);
    $tempImageName = createImageName($arr);
	$tempImageName = prepareName($tempImageName);
	// Check if file with this name exists
	$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/original/', $tempImageName, $extension );		
    
  	$path = '/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/original/'.$currName.'.'.$extension;
    
            // Upload temporary image
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);    


        list($imageWidth, $imageHeight) = getimagesize($_SERVER['DOCUMENT_ROOT'].$path);
                         
/*
 *    ADD THUMB FOR CMS         
*/             
        $requiredWidth = 200;
        $requiredHeight = 150;
        $cmsThumbPath = '/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/cms_thumb/'.$currName.'.'.$extension;
        // If original image is smaller than required - upload original image as main image
        if($imageWidth <= $requiredWidth && $imageHeight <= $requiredHeight) {
            // Upload thumb from original file
            copy($_SERVER['DOCUMENT_ROOT'].$path, $_SERVER['DOCUMENT_ROOT'].$cmsThumbPath);
        } else {
                if( ( $requiredWidth/$imageWidth ) <= ( $requiredHeight / $imageHeight ) ) {
                    $percent = $requiredHeight / $imageHeight;
                } else {
                    $percent = $requiredWidth / $imageWidth;
                }				     
            // Size of new image
            $mainImageWidth = round($imageWidth * $percent);
            $mainImageHeight = round($imageHeight * $percent);    
                              
            // Rezize image
            $tempImageForResize = imagecreatetruecolor($mainImageWidth, $mainImageHeight);    
            $tempImageFromOriginalImage = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$path);
            imagecopyresampled($tempImageForResize, $tempImageFromOriginalImage, 0, 0, 0, 0, $mainImageWidth, $mainImageHeight, $imageWidth, $imageHeight);  
            if($mainImageWidth > $requiredWidth || $mainImageHeight > $requiredHeight)
            {
                // Cut image
                if($mainImageWidth > $mainImageHeight) {
                    $cutX = ($mainImageWidth/2)-($requiredWidth/2);
                    $cutY = 0;                      
                } else {
                    $cutX = 0;
                    $cutY = ($mainImageHeight/2)-($requiredHeight/2); 
                }      
                $totalCut = imagecreatetruecolor($requiredWidth, $requiredHeight);     
                imagecopyresampled($totalCut, $tempImageForResize, 0, 0, $cutX, $cutY, $requiredWidth, $requiredHeight, $requiredWidth, $requiredHeight);  
                imagejpeg($totalCut, $_SERVER['DOCUMENT_ROOT'].$cmsThumbPath , 100);                        
            } else {
                imagejpeg($tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$cmsThumbPath , 100);             
            }                     
        }

/**thumbs_part1**/
                $ins=$this->pdo->prepare('INSERT INTO 
                                            _CREATED_FOLDER_NAME__gallery 
                                            (_CREATED_TABLE_PREFIX__img_parent_id, 
                                            _CREATED_TABLE_PREFIX__img_url, 
                                            /**thumbs_part2**/
                                            _CREATED_TABLE_PREFIX__img_url_cmsthumb, 
                                            _CREATED_TABLE_PREFIX__img_title, _CREATED_TABLE_PREFIX__img_content, _CREATED_TABLE_PREFIX__img_meta_title, _CREATED_TABLE_PREFIX__img_alt,  _CREATED_TABLE_PREFIX__img_file_name, 
                                            _CREATED_TABLE_PREFIX__img_date, _CREATED_TABLE_PREFIX__img_queue) 
                                            VALUES 
                                            (:_CREATED_TABLE_PREFIX__img_parent_id, :_CREATED_TABLE_PREFIX__img_url, 
                                            /**thumbs_part3**/
											:_CREATED_TABLE_PREFIX__img_url_cmsthumb, 
											:_CREATED_TABLE_PREFIX__img_title, :_CREATED_TABLE_PREFIX__img_content, :_CREATED_TABLE_PREFIX__img_meta_title, :_CREATED_TABLE_PREFIX__img_alt, :_CREATED_TABLE_PREFIX__img_file_name, 
											NOW(), :_CREATED_TABLE_PREFIX__img_queue) 
                                            ');      
                                            
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_parent_id', 0, PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_url', $path, PDO::PARAM_STR);
						/**thumbs_part4**/
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_url_cmsthumb', $cmsThumbPath, PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_content', $inputs['image_description'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_meta_title', $inputs['image_meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_alt', $inputs['image_meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':_CREATED_TABLE_PREFIX__img_queue', 0, PDO::PARAM_STR);
                        
                $ins->execute();   

        $return = 
        [
            'status' => 'added',
            'id'     => $id
        ];
        return $return;   
}


function _CREATED_MODEL_NAME_GalleryDelete($imageId)
{
        $query=$this->pdo->prepare('SELECT  _CREATED_TABLE_PREFIX__img_url_cmsthumb as cmsthumb, 
        									/**thumbs_part2**/
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
		/**thumbs_part5**/             
    
                $ins=$this->pdo->prepare('DELETE FROM _CREATED_TABLE_NAME__gallery WHERE _CREATED_TABLE_PREFIX__img_id = :id ');      
                $ins->bindValue(':id', $imageId, PDO::PARAM_STR);
                $ins->execute(); 
                
         $return = 
         [
            'status' => 'deleted',
         ];
         return $return;
}

function _CREATED_MODEL_NAME_GalleryEdit() {
	
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
            
        $content = 
        [
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

function _CREATED_MODEL_NAME_GalleryUpdate() {
	
		// Take extension from path
		function extensionFromPath ( $path ){
			$extension =  explode ( '.', $path );
			$extension = end( $extension );
			return $extension;
		}
			
		// Create image name 
		function createImageName($array){
			
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
				if( $number === NULL ){
					$number = 1;
				}
				else{
					$number = $number + 1;
				}
				if( $delimer === NULL ){
					$delimer = '-';
				}				
				return checkFileName ( $path, $name, $extension, $delimer, $number );
			}
			else {
				return $name.$delimer.$number;
			}
		}		
	            
            $query=$this->pdo->prepare( 'SELECT 
            								_CREATED_TABLE_PREFIX__img_url,
            								/**thumbs_part2**/
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
				/**thumbs_part6**/
                             
                    // Original photo
                    if (!empty($result[0]['_CREATED_TABLE_PREFIX__img_url'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url'], $_SERVER['DOCUMENT_ROOT'].$original);
                    }                
                    if (!empty($result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'], $_SERVER['DOCUMENT_ROOT'].$cmsthumb);
                    }
					/**thumbs_part7**/
                    
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url']);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb']);
                    }
					/**thumbs_part8**/
            } else {
            	
                $original = $result[0]['_CREATED_TABLE_PREFIX__img_url'];
                $cmsthumb = $result[0]['_CREATED_TABLE_PREFIX__img_url_cmsthumb'];
				/**thumbs_part9**/
            	
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
						/**thumbs_part11**/
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                        
                $ins->execute();      
}

function _CREATED_MODEL_NAME_GalleryQueue()
{
    $x = 1;
    foreach($_POST['idek'] as $id)
    {
                $ins=$this->pdo->prepare('UPDATE _CREATED_TABLE_NAME__gallery
                                            SET 
                                            _CREATED_TABLE_PREFIX__img_queue = :queue                                        
                                            WHERE
                                            _CREATED_TABLE_PREFIX__img_id = :idek');      
                        
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);                      
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                        
                $ins->execute();     
                
         $x++;    
    }
    
}}/**delete**/