<?php
class cms_contactModel extends Model {
public function contactEdit() {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM contact WHERE contact_lang = :lang ');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
        $inputs = 
        [
            'title'             => $result[0]['contact_title'],
            'hide'              => $result[0]['contact_hide'],
            'lang'              => $result[0]['contact_lang'],
/* meta_tags_part1 */
"meta_title"    	 => $result[0]["contact_meta_title"],
"meta_keywords"      => $result[0]["contact_meta_keywords"],
"meta_description"   => $result[0]["contact_meta_description"],
"meta_author"        => $result[0]["contact_meta_author"],
"meta_robots"        => $result[0]["contact_meta_robots"],
/* End meta_tags_part1 */
'show_gallery'              => $result[0]['contact_show_gallery'],          			            
        ];
        $content = 
        [
            'inputs' => $inputs,
        ];
            return $content;
}
public function contactInsert() {
    include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
	    $inputs = $_POST;
		$errors = [];
// INPUTS VALIDATION -------------------------------------------------------------------------            
    // Validate title - required
    if (empty( $_POST['title'])) {
        $errors[] = 'Wpisz tytuł';
    }  
// CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
    if (!empty( $errors )) {
        $return = [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs,
        ];
        return $return;
    }  
        // Url - Create URL based on title
        $url = mb_strtolower( $inputs['title'], 'UTF-8' );        
        $url = str_replace( $notAllowedCharacters, $substitutes, $url );   
                $ins= $this->pdo->prepare('UPDATE contact
                                            SET 											
                                            contact_url = :contact_url, contact_title = :contact_title, 
                                            contact_lang = :contact_lang, contact_hide = :contact_hide,
                                            contact_last_modified_date = NOW(), contact_last_modified_by = :contact_last_modified_by                                         
/* <!-- meta_tags part 1 */
, contact_meta_title = :contact_meta_title,
contact_meta_keywords = :contact_meta_keywords,
contact_meta_description = :contact_meta_description,
contact_meta_author = :contact_meta_author,
contact_meta_robots = :contact_meta_robots
/* --> End meta_tags part 1 */
,contact_show_gallery = :contact_show_gallery
                                            WHERE
                                            contact_lang = :contact_lang 
                                            ');
                        $ins->bindValue(':contact_url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':contact_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':contact_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':contact_last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
/* <!-- meta_tags part 2 */
$ins->bindValue(":contact_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":contact_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":contact_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":contact_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":contact_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
$ins->bindValue(':contact_show_gallery', $_POST['show_gallery'], PDO::PARAM_STR);
                $ins->execute();    
        $return =  [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;
}
function contactGallery() {
        $query=$this->pdo->prepare('SELECT contact_img_id as id, contact_img_title as title, contact_img_url_cmsthumb as cmsthumb, contact_img_url as url  
                                    FROM contact_gallery
                                    ORDER BY contact_img_queue ASC ,  contact_img_id DESC
                                        ');
        $query->execute();
        $result = $query->fetchAll();
        $images = $result;
    $return = [
        'images' => $images,
    ];
    return $return;
}function contactGalleryInsert() {
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
        } elseif ($_FILES['image']['size'] > $configuration['contact_gallery_max_size'] * 1000) {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['contact_gallery_max_size']/1000).'mb - '.($configuration['contact_gallery_max_size']).'kb)';
        } elseif ($imageWidth > $configuration['contact_gallery_max_width']) {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['contact_gallery_max_width'].'px)';
        } elseif ($imageHeight > $configuration['contact_gallery_max_height']) {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['contact_gallery_max_height'].'px)';
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
	$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/contact/gallery/original/', $tempImageName, $extension );		
  	$path = '/public/images/uploads/contact/gallery/original/'.$currName.'.'.$extension;
            // Upload temporary image
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);    
        list($imageWidth, $imageHeight) = getimagesize($_SERVER['DOCUMENT_ROOT'].$path);             
/*
 *    ADD THUMB FOR CMS         
*/             
        $requiredWidth = 200;
        $requiredHeight = 150;
        $cmsThumbPath = '/public/images/uploads/contact/gallery/cms_thumb/'.$currName.'.'.$extension;
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
                $ins=$this->pdo->prepare('INSERT INTO 
                                            contact_gallery 
                                            (contact_img_parent_id, 
                                            contact_img_url, 
                                            contact_img_url_cmsthumb, 
                                            contact_img_title, contact_img_content, contact_img_meta_title, contact_img_alt,  contact_img_file_name, 
                                            contact_img_date, contact_img_queue) 
                                            VALUES 
                                            (:contact_img_parent_id, :contact_img_url, 
											:contact_img_url_cmsthumb, 
											:contact_img_title, :contact_img_content, :contact_img_meta_title, :contact_img_alt, :contact_img_file_name, 
											NOW(), :contact_img_queue) 
                                            ');
                        $ins->bindValue(':contact_img_url', $path, PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_url_cmsthumb', $cmsThumbPath, PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_content', $inputs['image_description'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_meta_title', $inputs['image_meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_alt', $inputs['image_meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':contact_img_queue', 0, PDO::PARAM_STR);
                $ins->execute();   
        $return = [
            'status' => 'added',
            'galleryParent_id'     => $id
        ];
        return $return;   
}function contactGalleryDelete($imageId) {
	$query=$this->pdo->prepare('SELECT  contact_img_url_cmsthumb as cmsthumb, 
        									contact_img_url as url
        							FROM contact_gallery WHERE contact_img_id = :id ');
        $query->bindValue(':id', $imageId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb']);
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['url'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['url']);
        }
                $ins=$this->pdo->prepare('DELETE FROM contact_gallery WHERE contact_img_id = :id ');      
                $ins->bindValue(':id', $imageId, PDO::PARAM_STR);
                $ins->execute(); 
         $return = [
            'status' => 'deleted',
         ];
         return $return;
}function contactGalleryEdit() {
       $idek = $_POST['idek'];
            $query=$this->pdo->prepare( 'SELECT 
            								contact_img_title, 
            								contact_img_content, 
            								contact_img_meta_title, 
            								contact_img_alt, 
            								contact_img_file_name, 
            								contact_img_url_cmsthumb                              
                                          FROM contact_gallery
                                          WHERE contact_img_id = :idek
                                            ');
			$query->bindValue(':idek', $idek, PDO::PARAM_STR);
            $query->execute();  
            $result = $query->fetchAll();   
        $content = [
            'id'            => $idek,
            'title'        => $result[0]['contact_img_title'],
            'content'     => $result[0]['contact_img_content'],
            'meta_title'   => $result[0]['contact_img_meta_title'],
            'alt'           => $result[0]['contact_img_alt'],
            'file_name'    => $result[0]['contact_img_file_name'],   
            'cmsthumb'      => $result[0]['contact_img_url_cmsthumb'],        
        ];
            echo json_encode($content);
}function contactGalleryUpdate() {
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
            								contact_img_url,
            								contact_img_url_cmsthumb
                                        FROM contact_gallery
                                          WHERE contact_img_id = :idek  ');  
            $query->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);                                                                                           
            $query->execute();  
            $result = $query->fetchAll();  
			$old_mysql = $result[0]['contact_img_url'];
		    // Create name of image
		    $arr = array($_POST['edit-file-name'], $_POST['edit-meta-description'], $_POST['edit-meta-title'], $_POST['edit-title']);
		    $currName = createImageName($arr);		
			$currName = prepareName($currName);
            if (!strpos($old_mysql, $currName)) {
            	$extension = extensionFromPath($old_mysql);
				$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/contact/gallery/original/', $currName, $extension );	
                $original = '/public/images/uploads/contact/gallery/original/'.$currName.'.'.$extension;
                $cmsthumb = '/public/images/uploads/contact/gallery/cms_thumb/'.$currName.'.'.$extension;
                    // Original photo
                    if (!empty($result[0]['contact_img_url'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url'], $_SERVER['DOCUMENT_ROOT'].$original);
                    }                
                    if (!empty($result[0]['contact_img_url_cmsthumb'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url_cmsthumb'], $_SERVER['DOCUMENT_ROOT'].$cmsthumb);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url']);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url_cmsthumb'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['contact_img_url_cmsthumb']);
                    }
            } else {
                $original = $result[0]['contact_img_url'];
                $cmsthumb = $result[0]['contact_img_url_cmsthumb'];
            }
                $ins=$this->pdo->prepare('UPDATE contact_gallery
                                            SET 
                                            	contact_img_url = :url,
                                            	contact_img_url_cmsthumb = :cmsthumb,
                                           	 	contact_img_title = :title, contact_img_content = :content, contact_img_meta_title = :meta_title, 
                                            	contact_img_alt = :alt, contact_img_file_name = :file_name                                           
                                            WHERE
                                            	contact_img_id = :idek');
                        $ins->bindValue(':title', $_POST['edit-title'], PDO::PARAM_STR);
                        $ins->bindValue(':content', $_POST['edit-description'], PDO::PARAM_STR);
                        $ins->bindValue(':meta_title', $_POST['edit-meta-title'], PDO::PARAM_STR);
                        $ins->bindValue(':alt', $_POST['edit-meta-description'], PDO::PARAM_STR);
                        $ins->bindValue(':file_name', $_POST['edit-file-name'], PDO::PARAM_STR);
                        $ins->bindValue(':url', $original, PDO::PARAM_STR);
                        $ins->bindValue(':cmsthumb', $cmsthumb, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                $ins->execute();      
}function contactGalleryQueue() {
    $x = 1;
    foreach($_POST['idek'] as $id) {
    	$ins=$this->pdo->prepare('UPDATE contact_gallery
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
}