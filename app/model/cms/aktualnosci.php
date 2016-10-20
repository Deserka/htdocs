<?php
class cms_aktualnosciModel extends Model {
public function aktualnosci() {
		$query= $this->pdo->prepare('SELECT aktualnosc_id as id, aktualnosc_title as title, aktualnosc_url as url
									  FROM aktualnosci 
		                              WHERE aktualnosc_lang = :lang 
		                              ORDER BY aktualnosc_queue ASC ,  aktualnosc_id DESC');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
		$query->execute();	
		$result = $query->fetchAll();
        $content = [
        	'list' => $result,
        ];
		return $content;
}
public function aktualnosciAdd() {	
        $content = [
        ];
         return $content;
}
public function aktualnosciInsert() {
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
/* <!-- type2 part 1 */
if (empty( $inputs['id'])) {
	$ins = $this ->pdo ->prepare( 'UPDATE aktualnosci
									SET 
                                   aktualnosc_queue = aktualnosc_queue + 1
                                 ');
	$ins->execute();
    $ins = $this -> pdo -> prepare(' INSERT INTO 
                                            aktualnosci 
                                            (aktualnosc_url, aktualnosc_title, aktualnosc_created_date, aktualnosc_created_by, 
                                            aktualnosc_lang, aktualnosc_queue, aktualnosc_hide
/* <!-- meta_tags part 3 */
, aktualnosc_meta_title, aktualnosc_meta_keywords, aktualnosc_meta_description, aktualnosc_meta_author, aktualnosc_meta_robots
,aktualnosc_show_gallery
											) 
                                            VALUES 
                                            ( :aktualnosc_url, :aktualnosc_title, NOW(), :aktualnosc_created_by, :aktualnosc_lang, :aktualnosc_queue, :aktualnosc_hide  
/* <!-- meta_tags part 4 */
, :aktualnosc_meta_title, :aktualnosc_meta_keywords, :aktualnosc_meta_description, :aktualnosc_meta_author, :aktualnosc_meta_robots
,:aktualnosc_show_gallery
                                            ) 											
                                     ');   
                        $ins->bindValue(':aktualnosc_url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':aktualnosc_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':aktualnosc_queue', 0, PDO::PARAM_STR);
						$ins->bindValue(':aktualnosc_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':aktualnosc_created_by', $_SESSION['login'], PDO::PARAM_STR);
/* <!-- meta_tags part 2 */
$ins->bindValue(":aktualnosc_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
$ins->bindValue(':aktualnosc_show_gallery', $_POST['show_gallery'], PDO::PARAM_STR);
                $ins->execute(); 
/*tags1_part4*/
        $return = [
            'status' => 'added',
        ];
        return $return;
} else {
/* --> end type2 part 1 */
                $ins= $this->pdo->prepare('UPDATE aktualnosci
                                            SET 											
                                            aktualnosc_url = :aktualnosc_url, aktualnosc_title = :aktualnosc_title, 
                                            aktualnosc_lang = :aktualnosc_lang, aktualnosc_hide = :aktualnosc_hide,
                                            aktualnosc_last_modified_date = NOW(), aktualnosc_last_modified_by = :aktualnosc_last_modified_by                                         
/* <!-- meta_tags part 1 */
, aktualnosc_meta_title = :aktualnosc_meta_title,
aktualnosc_meta_keywords = :aktualnosc_meta_keywords,
aktualnosc_meta_description = :aktualnosc_meta_description,
aktualnosc_meta_author = :aktualnosc_meta_author,
aktualnosc_meta_robots = :aktualnosc_meta_robots
/* --> End meta_tags part 1 */
,aktualnosc_show_gallery = :aktualnosc_show_gallery
                                            WHERE
                                            aktualnosc_lang = :aktualnosc_lang 
/* <1!-- type2 part 3 */
&& aktualnosc_id = :aktualnosc_id
/* <1!-- type2 part 3 */
                                            ');
/* <1!-- type2 part 3 */
$ins->bindValue(':aktualnosc_id', $inputs['id'], PDO::PARAM_STR);
/* <1!-- type2 part 3 */
                        $ins->bindValue(':aktualnosc_url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':aktualnosc_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':aktualnosc_last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
/* <!-- meta_tags part 2 */
$ins->bindValue(":aktualnosc_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":aktualnosc_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
$ins->bindValue(':aktualnosc_show_gallery', $_POST['show_gallery'], PDO::PARAM_STR);
                $ins->execute();    
/* <1!-- type2 part 2 */
}
/* <1!-- type2 part 2 */
        $return =  [
            'status' => 'saved',
            'id'     => $inputs['id']
        ];
        return $return;
}
public function aktualnosciEdit($id) {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM aktualnosci WHERE aktualnosc_lang = :lang && aktualnosc_id = :id');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
$query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
        $inputs = 
        [
'id'                => $result[0]['aktualnosc_id'],
            'title'             => $result[0]['aktualnosc_title'],
            'hide'              => $result[0]['aktualnosc_hide'],
            'lang'              => $result[0]['aktualnosc_lang'],
/* meta_tags_part1 */
"meta_title"    	 => $result[0]["aktualnosc_meta_title"],
"meta_keywords"      => $result[0]["aktualnosc_meta_keywords"],
"meta_description"   => $result[0]["aktualnosc_meta_description"],
"meta_author"        => $result[0]["aktualnosc_meta_author"],
"meta_robots"        => $result[0]["aktualnosc_meta_robots"],
/* End meta_tags_part1 */
'show_gallery'              => $result[0]['aktualnosc_show_gallery'],          			            
        ];
        $content = 
        [
            'inputs' => $inputs,
        ];
            return $content;
}
function aktualnosciDelete($id) {
                $ins= $this-> pdo-> prepare( 'DELETE FROM aktualnosci WHERE aktualnosc_id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();
}
 function aktualnosciQueue() {
    $x = 1;
    foreach ($_POST['idek'] as $id) {
                $ins= $this->pdo->prepare('UPDATE aktualnosci
                                            SET 
                                            aktualnosc_queue = :queue                                        
                                            WHERE
                                            aktualnosc_id = :idek');
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                $ins->execute();
         $x++;
    }    
}function aktualnosciGallery($id) {
        $query=$this->pdo->prepare('SELECT aktualnosc_img_id as id, aktualnosc_img_title as title, aktualnosc_img_url_cmsthumb as cmsthumb, aktualnosc_img_url as url  
                                    FROM aktualnosci_gallery
                                    WHERE aktualnosc_img_parent_id = :id
                                    ORDER BY aktualnosc_img_queue ASC ,  aktualnosc_img_id DESC
                                        ');
		$query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        $images = $result;
        $query=$this->pdo->prepare('SELECT aktualnosc_id as id, aktualnosc_title as title FROM aktualnosci ');
		$query->execute();								
        $title = $query->fetchAll();
    $return = [
        'images' => $images,
"galleryParent_id" => $title[0][0], "galleryParent_title" => $title[0][1],
    ];
    return $return;
}function aktualnosciGalleryInsert($id) {
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
        } elseif ($_FILES['image']['size'] > $configuration['aktualnosci_gallery_max_size'] * 1000) {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['aktualnosci_gallery_max_size']/1000).'mb - '.($configuration['aktualnosci_gallery_max_size']).'kb)';
        } elseif ($imageWidth > $configuration['aktualnosci_gallery_max_width']) {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['aktualnosci_gallery_max_width'].'px)';
        } elseif ($imageHeight > $configuration['aktualnosci_gallery_max_height']) {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['aktualnosci_gallery_max_height'].'px)';
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
	$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/aktualnosci/gallery/original/', $tempImageName, $extension );		
  	$path = '/public/images/uploads/aktualnosci/gallery/original/'.$currName.'.'.$extension;
            // Upload temporary image
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);    
        list($imageWidth, $imageHeight) = getimagesize($_SERVER['DOCUMENT_ROOT'].$path);             
/*
 *    ADD THUMB FOR CMS         
*/             
        $requiredWidth = 200;
        $requiredHeight = 150;
        $cmsThumbPath = '/public/images/uploads/aktualnosci/gallery/cms_thumb/'.$currName.'.'.$extension;
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
                                            aktualnosci_gallery 
                                            (aktualnosc_img_parent_id, 
                                            aktualnosc_img_url, 
                                            aktualnosc_img_url_cmsthumb, 
                                            aktualnosc_img_title, aktualnosc_img_content, aktualnosc_img_meta_title, aktualnosc_img_alt,  aktualnosc_img_file_name, 
                                            aktualnosc_img_date, aktualnosc_img_queue) 
                                            VALUES 
                                            (:aktualnosc_img_parent_id, :aktualnosc_img_url, 
											:aktualnosc_img_url_cmsthumb, 
											:aktualnosc_img_title, :aktualnosc_img_content, :aktualnosc_img_meta_title, :aktualnosc_img_alt, :aktualnosc_img_file_name, 
											NOW(), :aktualnosc_img_queue) 
                                            ');
                        $ins->bindValue(':aktualnosc_img_url', $path, PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_url_cmsthumb', $cmsThumbPath, PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_content', $inputs['image_description'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_meta_title', $inputs['image_meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_alt', $inputs['image_meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':aktualnosc_img_queue', 0, PDO::PARAM_STR);
                $ins->execute();   
        $return = [
            'status' => 'added',
            'galleryParent_id'     => $id
        ];
        return $return;   
}function aktualnosciGalleryDelete($id, $imageId) {
	$query=$this->pdo->prepare('SELECT  aktualnosc_img_url_cmsthumb as cmsthumb, 
        									aktualnosc_img_url as url
        							FROM aktualnosci_gallery WHERE aktualnosc_img_id = :id ');
        $query->bindValue(':id', $imageId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb']);
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['url'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['url']);
        }
                $ins=$this->pdo->prepare('DELETE FROM aktualnosci_gallery WHERE aktualnosc_img_id = :id ');      
                $ins->bindValue(':id', $imageId, PDO::PARAM_STR);
                $ins->execute(); 
         $return = [
            'status' => 'deleted',
         ];
         return $return;
}function aktualnosciGalleryEdit() {
       $idek = $_POST['idek'];
            $query=$this->pdo->prepare( 'SELECT 
            								aktualnosc_img_title, 
            								aktualnosc_img_content, 
            								aktualnosc_img_meta_title, 
            								aktualnosc_img_alt, 
            								aktualnosc_img_file_name, 
            								aktualnosc_img_url_cmsthumb                              
                                          FROM aktualnosci_gallery
                                          WHERE aktualnosc_img_id = :idek
                                            ');
			$query->bindValue(':idek', $idek, PDO::PARAM_STR);
            $query->execute();  
            $result = $query->fetchAll();   
        $content = [
            'id'            => $idek,
            'title'        => $result[0]['aktualnosc_img_title'],
            'content'     => $result[0]['aktualnosc_img_content'],
            'meta_title'   => $result[0]['aktualnosc_img_meta_title'],
            'alt'           => $result[0]['aktualnosc_img_alt'],
            'file_name'    => $result[0]['aktualnosc_img_file_name'],   
            'cmsthumb'      => $result[0]['aktualnosc_img_url_cmsthumb'],        
        ];
            echo json_encode($content);
}function aktualnosciGalleryUpdate($id) {
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
            								aktualnosc_img_url,
            								aktualnosc_img_url_cmsthumb
                                        FROM aktualnosci_gallery
                                          WHERE aktualnosc_img_id = :idek  ');  
            $query->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);                                                                                           
            $query->execute();  
            $result = $query->fetchAll();  
			$old_mysql = $result[0]['aktualnosc_img_url'];
		    // Create name of image
		    $arr = array($_POST['edit-file-name'], $_POST['edit-meta-description'], $_POST['edit-meta-title'], $_POST['edit-title']);
		    $currName = createImageName($arr);		
			$currName = prepareName($currName);
            if (!strpos($old_mysql, $currName)) {
            	$extension = extensionFromPath($old_mysql);
				$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/aktualnosci/gallery/original/', $currName, $extension );	
                $original = '/public/images/uploads/aktualnosci/gallery/original/'.$currName.'.'.$extension;
                $cmsthumb = '/public/images/uploads/aktualnosci/gallery/cms_thumb/'.$currName.'.'.$extension;
                    // Original photo
                    if (!empty($result[0]['aktualnosc_img_url'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url'], $_SERVER['DOCUMENT_ROOT'].$original);
                    }                
                    if (!empty($result[0]['aktualnosc_img_url_cmsthumb'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url_cmsthumb'], $_SERVER['DOCUMENT_ROOT'].$cmsthumb);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url']);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url_cmsthumb'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['aktualnosc_img_url_cmsthumb']);
                    }
            } else {
                $original = $result[0]['aktualnosc_img_url'];
                $cmsthumb = $result[0]['aktualnosc_img_url_cmsthumb'];
            }
                $ins=$this->pdo->prepare('UPDATE aktualnosci_gallery
                                            SET 
                                            	aktualnosc_img_url = :url,
                                            	aktualnosc_img_url_cmsthumb = :cmsthumb,
                                           	 	aktualnosc_img_title = :title, aktualnosc_img_content = :content, aktualnosc_img_meta_title = :meta_title, 
                                            	aktualnosc_img_alt = :alt, aktualnosc_img_file_name = :file_name                                           
                                            WHERE
                                            	aktualnosc_img_id = :idek');
                        $ins->bindValue(':title', $_POST['edit-title'], PDO::PARAM_STR);
                        $ins->bindValue(':content', $_POST['edit-description'], PDO::PARAM_STR);
                        $ins->bindValue(':meta_title', $_POST['edit-meta-title'], PDO::PARAM_STR);
                        $ins->bindValue(':alt', $_POST['edit-meta-description'], PDO::PARAM_STR);
                        $ins->bindValue(':file_name', $_POST['edit-file-name'], PDO::PARAM_STR);
                        $ins->bindValue(':url', $original, PDO::PARAM_STR);
                        $ins->bindValue(':cmsthumb', $cmsthumb, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                $ins->execute();      
}function aktualnosciGalleryQueue() {
    $x = 1;
    foreach($_POST['idek'] as $id) {
    	$ins=$this->pdo->prepare('UPDATE aktualnosci_gallery
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