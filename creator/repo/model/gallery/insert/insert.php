<?php function _CREATED_MODEL_NAME_GalleryInsert(/**_IDS_**/) {
	include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
    $inputs = $_POST;
		// Check if file with this name exist - if yes - add number at the end
		function checkFileName ( $path, $name, $extension, $delimer=NULL, $number=NULL ) {
			if( file_exists( $path.$name.$delimer.$number.'.'.$extension)) {				
				if ($number === NULL) {
					$number = 1;
				} else{
					$number = $number + 1;
				}
				if ($delimer === NULL) {
					$delimer = '-';
				}				
				return checkFileName ( $path, $name, $extension, $delimer, $number );
			}
			else {
				return $name.$delimer.$number;
			}
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
		function prepareName($name) {
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
    if (!empty($_FILES['image']['name'])) {
        $allowedExts = array('gif', 'jpeg', 'jpg', 'png');
        $tempImage = explode('.', $_FILES['image']['name']);
        $extension = end($tempImage);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);  
        $imageDimension = getimagesize($_FILES['image']['tmp_name']);
        $imageWidth = $imageDimension[0];
        $imageHeight = $imageDimension[1];   
    }    
    	if (empty($_FILES['image']['name'])) {
        	$errors[] = 'Wybierz zdjęcie';  
    	} elseif ( ($mime !== 'image/gif') && ($mime !== 'image/jpeg') && ($mime !== 'image/pjpeg') && ($mime !== 'image/x-png') && ($mime !== 'image/png')) {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        } elseif (!in_array(strtolower($extension), $allowedExts)) {
            $errors[] = 'Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        } elseif ($_FILES['image']['size'] > $configuration['_CREATED_CONFIG_NAME__gallery_max_size'] * 1000) {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['_CREATED_CONFIG_NAME__gallery_max_size']/1000).'mb - '.($configuration['_CREATED_CONFIG_NAME__gallery_max_size']).'kb)';
        } elseif ($imageWidth > $configuration['_CREATED_CONFIG_NAME__gallery_max_width']) {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['_CREATED_CONFIG_NAME__gallery_max_width'].'px)';
        } elseif ($imageHeight > $configuration['_CREATED_CONFIG_NAME__gallery_max_height']) {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['_CREATED_CONFIG_NAME__gallery_max_height'].'px)';
        }    
        if (!empty($errors)) {
        $return = [
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
        if ($imageWidth <= $requiredWidth && $imageHeight <= $requiredHeight) {
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
            if ($mainImageWidth > $requiredWidth || $mainImageHeight > $requiredHeight) {
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
/**type1_part1**/
/**type2_part1**/
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
        $return = [
            'status' => 'added',
            'galleryParent_id'     => $id
        ];
        return $return;   
}