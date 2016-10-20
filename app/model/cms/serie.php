<?php
class cms_serieModel extends Model {
public function serie($parent_id) {
		$query= $this->pdo->prepare('SELECT seria_id as id, seria_title as title, seria_url as url
									  FROM serie 
		                              WHERE seria_lang = :lang && seria_parent_id = :parent_id
		                              ORDER BY seria_queue ASC ,  seria_id DESC');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
$query->bindValue(':parent_id', $parent_id, PDO::PARAM_STR);
		$query->execute();	
		$result = $query->fetchAll();
		$query= $this->pdo->prepare('SELECT kategoria_title as title, kategoria_id as id
									  FROM kategorie
									  WHERE kategoria_id = :id ');
		$query->bindValue(':id', $parent_id, PDO::PARAM_STR);
		$query->execute();
		$parent = $query->fetchAll();
        $content = [
        	'list' => $result,
'parent_title' => $parent[0]['title'],
'parent_id' => $parent[0]['id'],
        ];
		return $content;
}
public function serieAdd($parent_id) {	
		$query= $this->pdo->prepare('SELECT kategoria_title as title, kategoria_id as id
									  FROM kategorie
									  WHERE kategoria_id = :id ');
		$query->bindValue(':id', $parent_id, PDO::PARAM_STR);
		$query->execute();
		$parent = $query->fetchAll();
        $content = [
'parent_title' => $parent[0]['title'],
'parent_id' => $parent[0]['id'],
        ];
         return $content;
}
public function serieInsert($parent_id) {
    include('config/configuration.php');
	include('creator/repo/allowed_characters/arrays.php');
	    $inputs = $_POST;
		$errors = [];
/*
 * IMAGE VALIDATION -------------------------------------------------------------------------       
*/    
	// functions - for image path and name 00000
		// Take name and extension
		if (!function_exists('nameAndExtFromPath')) {
			function nameAndExtFromPath ( $path ){
				$name = explode ( '/', $path );
				$name = end( $name );
				return $name;
			}
		}
		if (!function_exists('nameFromPath')) {
		// Take name without extension
			function nameFromPath ($path){
				$name = explode ('/', $path);
				$extensions = array('.jpg', 'jpeg', '.png', '.gif');
				$name = str_ireplace( $extensions, '', end($name));
				return $name;
			}
		}
		if (!function_exists('extensionFromPath')) {
		// Take extension from path
			function extensionFromPath ( $path ){
				$extension =  explode ( '.', $path );
				$extension = end( $extension );
				return $extension;
			}
		}
		if (!function_exists('checkFileName')) {
		// Check if file with this name exist - if yes - add number at the end
			function checkFileName ( $path, $name, $extension, $delimer=NULL, $number=NULL ) {
				if( file_exists( $path.$name.$delimer.$number.'.'.$extension ) ) {				
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
		}	
		if (!function_exists('createImageName')) {
		// Create image name 
			function createImageName($array){
				foreach($array as $name){
					if(!empty($name)){
						return $name;
					}
				}
				return uniqid();
			}
		}
		if (!function_exists('prepareName')) {
		// Prepare name - from normal sentence to URL os sth
			function prepareName($name){
				// to lowercase
				$name = mb_strtolower( $name, 'UTF-8' );
				// delete unwanted characters
				$notAllowedCharacters = array(' ', '_' ,'ą', 'ć', 'ę', 'ó', 'ł', 'ń', 'ż', 'ź', 'ś',
				                            '?', '!', '.', ',', ':', ';', '!', '@', '#', '$', '%', '^', '*', '(', ')', '+','=', '<', '>', '~', '`', '/', '\\', '{', '}', '[', ']', '\'', '\'', '|', '"');                       
				$substitutes = array('-', '-', 'a', 'c', 'e', 'o', 'l', 'n', 'z', 'z', 's',
				                            '');	
				$name = str_replace( $notAllowedCharacters, $substitutes, $name ); 	
				// Delete more '-' than 1
				$name = preg_replace('/-{2,}/', '-', $name);			
				// Trim '-'
				$name = trim($name, '-');	
				return $name;													
			}
		}
/*image1_part2*/
/*
 * IMAGE VALIDATION -------------------------------------------------------------------------       
*/    
    // If image is for uplaod - validate it
    if( isset( $_FILES['image1']['tmp_name'] ) && !empty ( $_FILES['image1']['tmp_name'] ) ) {
		$image1_go_for_validate = 1;
    }
	// Image wasn't uploaded this time - but earlier was. We've got temporary image in folder - validated already.
	elseif ( isset ( $inputs['temp_image1_path'] ) && !empty ( $inputs['temp_image1_path'] ) ) {
		$inputs['temp_image1_path'] = $inputs['temp_image1_path'];
	}
// Validate new (just added) image
if( isset( $image1_go_for_validate ) && $image1_go_for_validate === 1 ){
        $image1_allowedExts = array('gif', 'jpeg', 'jpg', 'png');
        $image1Temp = explode('.', $_FILES['image1']['name']);
        $image1_extension = end( $image1Temp );
        $image1_finfo = finfo_open( FILEINFO_MIME_TYPE );
        $image1_mime = finfo_file( $image1_finfo, $_FILES['image1']['tmp_name'] );  
        $image1_imageDimension = getimagesize( $_FILES['image1']['tmp_name'] );
        $image1_imageWidth = $image1_imageDimension[0];          
        $image1_imageHeight = $image1_imageDimension[1];        
        if ( ( $image1_mime !== 'image/gif') && ( $image1_mime !== 'image/jpeg' ) && ( $image1_mime !== 'image/pjpeg' ) && ( $image1_mime !== 'image/x-png' ) && ( $image1_mime !== 'image/png' ) ) {
            $errors[] = 'Miniaturka: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif( !in_array( strtolower( $image1_extension ), $image1_allowedExts ) ) {
            $errors[] = 'Miniaturka: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif( isset( $_FILES['image1']['size'] ) && ($_FILES['image1']['size'] / 1000) > $configuration['serie_image1_max_size'] ) {
            $errors[] = 'Miniaturka: Rozmiar zdjęcia jest za duży. (max. '.( $configuration['serie_image1_max_size']/1000 ).'mb - '.$configuration['serie_image1_max_size'].'kb)';
        } 
        elseif ($configuration['serie_image1_max_width'] > 0 && $image1_imageWidth > $configuration['serie_image1_max_width']) {
        		$errors[] = 'Miniaturka: Obrazek jest za szeroki. ( max. '.$configuration['serie_image1_max_width'].'px )';
        }
        elseif ($configuration['serie_image1_max_height'] > 0 && $image1_imageHeight > $configuration['serie_image1_max_height']) {
        		$errors[] = 'Miniaturka: Obrazek jest za wysoki. ( max. '.$configuration['serie_image1_max_height'].'px )';
        }
		else {
            // Create temporary name for image
            $image1_name =  uniqid().'.'.$image1_extension;
            // Upload temporary image
            move_uploaded_file( $_FILES['image1']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/temp/'.$image1_name );    
            // Delete files from temp if last modification of file is further than 24h
                    // Get all files from temp
                    $image1_files = glob($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/temp/*'); 
                    foreach( $image1_files as $image1_file )
                    { 
                      if( is_file( $image1_file ) )
                        if((time() - filemtime( $image1_file )) > 86400)
                        {
                            unlink( $image1_file );
                        }
                    } 
            // Save that temp image was created
            $inputs['temp_image1_path'] = '/public/images/uploads/serie/main1/temp/'.$image1_name; 				
		} 	
}
/*image2_part2*/
/*
 * IMAGE VALIDATION -------------------------------------------------------------------------       
*/    
    // If image is for uplaod - validate it
    if( isset( $_FILES['image2']['tmp_name'] ) && !empty ( $_FILES['image2']['tmp_name'] ) ) {
		$image2_go_for_validate = 1;
    }
	// Image wasn't uploaded this time - but earlier was. We've got temporary image in folder - validated already.
	elseif ( isset ( $inputs['temp_image2_path'] ) && !empty ( $inputs['temp_image2_path'] ) ) {
		$inputs['temp_image2_path'] = $inputs['temp_image2_path'];
	}
// Validate new (just added) image
if( isset( $image2_go_for_validate ) && $image2_go_for_validate === 1 ){
        $image2_allowedExts = array('gif', 'jpeg', 'jpg', 'png');
        $image2Temp = explode('.', $_FILES['image2']['name']);
        $image2_extension = end( $image2Temp );
        $image2_finfo = finfo_open( FILEINFO_MIME_TYPE );
        $image2_mime = finfo_file( $image2_finfo, $_FILES['image2']['tmp_name'] );  
        $image2_imageDimension = getimagesize( $_FILES['image2']['tmp_name'] );
        $image2_imageWidth = $image2_imageDimension[0];          
        $image2_imageHeight = $image2_imageDimension[1];        
        if ( ( $image2_mime !== 'image/gif') && ( $image2_mime !== 'image/jpeg' ) && ( $image2_mime !== 'image/pjpeg' ) && ( $image2_mime !== 'image/x-png' ) && ( $image2_mime !== 'image/png' ) ) {
            $errors[] = 'Główne zdjęcie: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif( !in_array( strtolower( $image2_extension ), $image2_allowedExts ) ) {
            $errors[] = 'Główne zdjęcie: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif( isset( $_FILES['image2']['size'] ) && ($_FILES['image2']['size'] / 1000) > $configuration['serie_image2_max_size'] ) {
            $errors[] = 'Główne zdjęcie: Rozmiar zdjęcia jest za duży. (max. '.( $configuration['serie_image2_max_size']/1000 ).'mb - '.$configuration['serie_image2_max_size'].'kb)';
        } 
        elseif ($configuration['serie_image2_max_width'] > 0 && $image2_imageWidth > $configuration['serie_image2_max_width']) {
        		$errors[] = 'Główne zdjęcie: Obrazek jest za szeroki. ( max. '.$configuration['serie_image2_max_width'].'px )';
        }
        elseif ($configuration['serie_image2_max_height'] > 0 && $image2_imageHeight > $configuration['serie_image2_max_height']) {
        		$errors[] = 'Główne zdjęcie: Obrazek jest za wysoki. ( max. '.$configuration['serie_image2_max_height'].'px )';
        }
		else {
            // Create temporary name for image
            $image2_name =  uniqid().'.'.$image2_extension;
            // Upload temporary image
            move_uploaded_file( $_FILES['image2']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/temp/'.$image2_name );    
            // Delete files from temp if last modification of file is further than 24h
                    // Get all files from temp
                    $image2_files = glob($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/temp/*'); 
                    foreach( $image2_files as $image2_file )
                    { 
                      if( is_file( $image2_file ) )
                        if((time() - filemtime( $image2_file )) > 86400)
                        {
                            unlink( $image2_file );
                        }
                    } 
            // Save that temp image was created
            $inputs['temp_image2_path'] = '/public/images/uploads/serie/main2/temp/'.$image2_name; 				
		} 	
}
// INPUTS VALIDATION -------------------------------------------------------------------------            
    // Validate title - required
    if (empty( $_POST['title'])) {
        $errors[] = 'Wpisz tytuł';
    }  
// CHECK IF ERRRORS EXIST -------------------------------------------------------------------------       
    if (!empty( $errors )) {
		$query= $this->pdo->prepare('SELECT kategoria_title as title, kategoria_id as id
									  FROM kategorie
									  WHERE kategoria_id = :id ');
		$query->bindValue(':id', $parent_id, PDO::PARAM_STR);
		$query->execute();
		$parent = $query->fetchAll();
        $return = [
            'status' => 'error',
            'errors' => $errors,
            'inputs' => $inputs,
            'parent_title' => $parent[0]['title'],
'parent_id' => $parent[0]['id'],
        ];
        return $return;
    }  
/*image1_part3*/
/*
 * VALIDATION IS OK - START ADDING TO folders (image 1) -------------------------------------------------------------------------       
*/        
ini_set('memory_limit', '1024M');  // if more than 3 images and more than FHD resolution... will be a problem
if ( isset ( $inputs['temp_image1_path'] ) && !empty ( $inputs['temp_image1_path'] ) ) {		
		$image1_extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path']);		
		$image1_arrayWithNames = array($inputs['image1_file_name'], $inputs['image1_alt'], $inputs['title']);
		$image1_newName = createImageName($image1_arrayWithNames);		
		$image1_newName = prepareName($image1_newName);
		// Check if file with this name exists
		$image1_newName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/', $image1_newName, $image1_extension );	
		$image1_originalPath = '/public/images/uploads/serie/main1/original/'.$image1_newName.'.'.$image1_extension;
/*start thumbs_part1*/
/*end thumbs_part1*/
// CUT ORIGINAL IMAGE - START
        // Dimension of required main image for serie
        $image1_requiredWidth = $configuration['serie_image1_required_width'];
        $image1_requiredHeight = $configuration['serie_image1_required_height'];
        list( $image1_width, $image1_height ) = getimagesize( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path'] );    
        // If original image is smaller than required - upload original image as main image
        if( $image1_width <= $image1_requiredWidth && $image1_height <= $image1_requiredHeight)
        {
            // Upload original image
            copy( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path'], $_SERVER['DOCUMENT_ROOT'].$image1_originalPath );
        }    
        else 
        {        	
                if( ( $image1_requiredWidth/$image1_width ) <= ( $image1_requiredHeight / $image1_height ) )
                {
                    $image1_percent = $image1_requiredHeight / $image1_height;
                }
                else {
                    $image1_percent = $image1_requiredWidth / $image1_width;
                }		                        
            // Size of new image
            $image1_mainImageWidth = round( $image1_width * $image1_percent );
            $image1_mainImageHeight = round( $image1_height * $image1_percent );                        
            // Rezize image
            $image1_tempImageForResize = imagecreatetruecolor( $image1_mainImageWidth, $image1_mainImageHeight );    
            $image1_tempImageFromOriginalImage = imagecreatefromjpeg( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path'] );
            imagecopyresampled( $image1_tempImageForResize, $image1_tempImageFromOriginalImage, 0, 0, 0, 0, $image1_mainImageWidth, $image1_mainImageHeight, $image1_width, $image1_height );  
            if( $image1_mainImageWidth > $image1_requiredWidth || $image1_mainImageHeight > $image1_requiredHeight )
            {
                // Cut image
                if( $image1_mainImageWidth > $image1_mainImageHeight )
                {
                    $image1_cutX = ( $image1_mainImageWidth/2 )-( $image1_requiredWidth/2 );
                    $image1_cutY = 0;                      
                }
                else 
                {
                    $image1_cutX = 0;
                    $image1_cutY = ( $image1_mainImageHeight/2 )-( $image1_requiredHeight/2 ); 
                }      
                $image1_totalCut = imagecreatetruecolor( $image1_requiredWidth, $image1_requiredHeight );     
                imagecopyresampled( $image1_totalCut, $image1_tempImageForResize, 0, 0, $image1_cutX, $image1_cutY, $image1_requiredWidth, $image1_requiredHeight, $image1_requiredWidth, $image1_requiredHeight );  
                imagejpeg( $image1_totalCut, $_SERVER['DOCUMENT_ROOT'].$image1_originalPath , 100 );                   
            }
            else 
            {
                imagejpeg( $image1_tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$image1_originalPath , 100 );              
            }                     
        }
// CUT ORIGINAL IMAGE - END	
/*start thumbs_part2*/
/*end thumbs_part2*/
		//New image is uploaded - delete old - if existed
		// Delete old images - if exists
		if( isset( $inputs['current_image1']) && !empty ($inputs['current_image1']) ) {
			$image1_deleteName = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['current_image1']);
		    if( is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_deleteName ) )
		    {
		    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_deleteName );
		    }	
/*start thumbs_part3*/
/*end thumbs_part3*/
		}		
	} // end of adding image
	elseif( isset( $inputs['current_image1'] ) && !empty( $inputs['current_image1'] ) ) {
		$image1_originalPath = $inputs['current_image1'];
		$image1_originalPath = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$image1_originalPath);
		// name from current inputs
		$image1_arrayWithNames = array($inputs['image1_file_name'], $inputs['image1_alt'], $inputs['title']);
		$image1_potName = createImageName($image1_arrayWithNames);
		$image1_potName = prepareName($image1_potName);
		if (strpos($image1_originalPath, $image1_potName) === false) {
			// Check extension of image
			$image1_extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$image1_originalPath);
			// Check if file with this name exists
			$image1_potName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/', $image1_potName, $image1_extension );	
			// Copy file - then delete old image		
			    if (is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_originalPath )) {
			    	copy( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_originalPath, 
			    			$_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_potName.'.'.$image1_extension );
			    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main1/original/'.$image1_originalPath );
			    }	
/*start thumbs_part4*/
/*end thumbs_part4*/	
			// can't be eariler - deleted with old names
			$image1_originalPath = '/public/images/uploads/serie/main1/original/'.$image1_potName.'.'.$image1_extension;
/*start thumbs_part5*/
/*end thumbs_part5*/
		} else {
			$oldImageName = $image1_originalPath;
			$image1_originalPath = '/public/images/uploads/serie/main1/original/'.$image1_originalPath;
/*start thumbs_part6*/
/*end thumbs_part6*/
		}		
	} else {
		$image1_originalPath = '';
/*start thumbs_part7*/
/*end thumbs_part7*/
	}
// Delete temporary image ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
            // Unlink temporary image
            if( isset( $inputs['temp_image1_path'] ) && is_file( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path'] ) )
            {
                unlink( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image1_path'] );
            }		
/*image2_part3*/
/*
 * VALIDATION IS OK - START ADDING TO folders (image 1) -------------------------------------------------------------------------       
*/        
ini_set('memory_limit', '1024M');  // if more than 3 images and more than FHD resolution... will be a problem
if ( isset ( $inputs['temp_image2_path'] ) && !empty ( $inputs['temp_image2_path'] ) ) {		
		$image2_extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path']);		
		$image2_arrayWithNames = array($inputs['image2_file_name'], $inputs['image2_alt'], $inputs['title']);
		$image2_newName = createImageName($image2_arrayWithNames);		
		$image2_newName = prepareName($image2_newName);
		// Check if file with this name exists
		$image2_newName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/', $image2_newName, $image2_extension );	
		$image2_originalPath = '/public/images/uploads/serie/main2/original/'.$image2_newName.'.'.$image2_extension;
/*start thumbs_part1*/
/*end thumbs_part1*/
// CUT ORIGINAL IMAGE - START
        // Dimension of required main image for serie
        $image2_requiredWidth = $configuration['serie_image2_required_width'];
        $image2_requiredHeight = $configuration['serie_image2_required_height'];
        list( $image2_width, $image2_height ) = getimagesize( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path'] );    
        // If original image is smaller than required - upload original image as main image
        if( $image2_width <= $image2_requiredWidth && $image2_height <= $image2_requiredHeight)
        {
            // Upload original image
            copy( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path'], $_SERVER['DOCUMENT_ROOT'].$image2_originalPath );
        }    
        else 
        {        	
                if( ( $image2_requiredWidth/$image2_width ) <= ( $image2_requiredHeight / $image2_height ) )
                {
                    $image2_percent = $image2_requiredHeight / $image2_height;
                }
                else {
                    $image2_percent = $image2_requiredWidth / $image2_width;
                }		                        
            // Size of new image
            $image2_mainImageWidth = round( $image2_width * $image2_percent );
            $image2_mainImageHeight = round( $image2_height * $image2_percent );                        
            // Rezize image
            $image2_tempImageForResize = imagecreatetruecolor( $image2_mainImageWidth, $image2_mainImageHeight );    
            $image2_tempImageFromOriginalImage = imagecreatefromjpeg( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path'] );
            imagecopyresampled( $image2_tempImageForResize, $image2_tempImageFromOriginalImage, 0, 0, 0, 0, $image2_mainImageWidth, $image2_mainImageHeight, $image2_width, $image2_height );  
            if( $image2_mainImageWidth > $image2_requiredWidth || $image2_mainImageHeight > $image2_requiredHeight )
            {
                // Cut image
                if( $image2_mainImageWidth > $image2_mainImageHeight )
                {
                    $image2_cutX = ( $image2_mainImageWidth/2 )-( $image2_requiredWidth/2 );
                    $image2_cutY = 0;                      
                }
                else 
                {
                    $image2_cutX = 0;
                    $image2_cutY = ( $image2_mainImageHeight/2 )-( $image2_requiredHeight/2 ); 
                }      
                $image2_totalCut = imagecreatetruecolor( $image2_requiredWidth, $image2_requiredHeight );     
                imagecopyresampled( $image2_totalCut, $image2_tempImageForResize, 0, 0, $image2_cutX, $image2_cutY, $image2_requiredWidth, $image2_requiredHeight, $image2_requiredWidth, $image2_requiredHeight );  
                imagejpeg( $image2_totalCut, $_SERVER['DOCUMENT_ROOT'].$image2_originalPath , 100 );                   
            }
            else 
            {
                imagejpeg( $image2_tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$image2_originalPath , 100 );              
            }                     
        }
// CUT ORIGINAL IMAGE - END	
/*start thumbs_part2*/
/*end thumbs_part2*/
		//New image is uploaded - delete old - if existed
		// Delete old images - if exists
		if( isset( $inputs['current_image2']) && !empty ($inputs['current_image2']) ) {
			$image2_deleteName = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['current_image2']);
		    if( is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_deleteName ) )
		    {
		    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_deleteName );
		    }	
/*start thumbs_part3*/
/*end thumbs_part3*/
		}		
	} // end of adding image
	elseif( isset( $inputs['current_image2'] ) && !empty( $inputs['current_image2'] ) ) {
		$image2_originalPath = $inputs['current_image2'];
		$image2_originalPath = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$image2_originalPath);
		// name from current inputs
		$image2_arrayWithNames = array($inputs['image2_file_name'], $inputs['image2_alt'], $inputs['title']);
		$image2_potName = createImageName($image2_arrayWithNames);
		$image2_potName = prepareName($image2_potName);
		if (strpos($image2_originalPath, $image2_potName) === false) {
			// Check extension of image
			$image2_extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$image2_originalPath);
			// Check if file with this name exists
			$image2_potName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/', $image2_potName, $image2_extension );	
			// Copy file - then delete old image		
			    if (is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_originalPath )) {
			    	copy( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_originalPath, 
			    			$_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_potName.'.'.$image2_extension );
			    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/main2/original/'.$image2_originalPath );
			    }	
/*start thumbs_part4*/
/*end thumbs_part4*/	
			// can't be eariler - deleted with old names
			$image2_originalPath = '/public/images/uploads/serie/main2/original/'.$image2_potName.'.'.$image2_extension;
/*start thumbs_part5*/
/*end thumbs_part5*/
		} else {
			$oldImageName = $image2_originalPath;
			$image2_originalPath = '/public/images/uploads/serie/main2/original/'.$image2_originalPath;
/*start thumbs_part6*/
/*end thumbs_part6*/
		}		
	} else {
		$image2_originalPath = '';
/*start thumbs_part7*/
/*end thumbs_part7*/
	}
// Delete temporary image ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
            // Unlink temporary image
            if( isset( $inputs['temp_image2_path'] ) && is_file( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path'] ) )
            {
                unlink( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image2_path'] );
            }		
        // Url - Create URL based on title
        $url = mb_strtolower( $inputs['title'], 'UTF-8' );        
        $url = str_replace( $notAllowedCharacters, $substitutes, $url );   
/* <!-- type2 part 1 */
if (empty( $inputs['id'])) {
	$ins = $this ->pdo ->prepare( 'UPDATE serie
									SET 
                                   seria_queue = seria_queue + 1
                                 ');
	$ins->execute();
    $ins = $this -> pdo -> prepare(' INSERT INTO 
                                            serie 
                                            (seria_url, seria_title, seria_created_date, seria_created_by, 
                                            seria_lang, seria_queue, seria_hide
, seria_opis
, seria_tabela
/* <!-- meta_tags part 3 */
, seria_meta_title, seria_meta_keywords, seria_meta_description, seria_meta_author, seria_meta_robots
/* <!-- image1 part 6 */
, seria_image1,
seria_image1_alt,
seria_image1_title,
seria_image1_file_name
/* --> end image1 part 6 *//* <!-- image2 part 6 */
, seria_image2,
seria_image2_alt,
seria_image2_title,
seria_image2_file_name
/* --> end image2 part 6 */
,seria_show_gallery
,seria_parent_id
											) 
                                            VALUES 
                                            ( :seria_url, :seria_title, NOW(), :seria_created_by, :seria_lang, :seria_queue, :seria_hide  
, :seria_opis
, :seria_tabela
/* <!-- meta_tags part 4 */
, :seria_meta_title, :seria_meta_keywords, :seria_meta_description, :seria_meta_author, :seria_meta_robots
/* <!-- image1 part 6 */
, :seria_image1,
:seria_image1_alt,
:seria_image1_title,
:seria_image1_file_name
/* --> end image1 part 6 *//* <!-- image2 part 6 */
, :seria_image2,
:seria_image2_alt,
:seria_image2_title,
:seria_image2_file_name
/* --> end image2 part 6 */
,:seria_show_gallery
,:seria_parent_id
                                            ) 											
                                     ');   
                        $ins->bindValue(':seria_url', $url, PDO::PARAM_STR);  
                        $ins->bindValue(':seria_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':seria_queue', 0, PDO::PARAM_STR);
						$ins->bindValue(':seria_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':seria_created_by', $_SESSION['login'], PDO::PARAM_STR);
$ins->bindValue(":seria_opis", $inputs["opis"], PDO::PARAM_STR);
$ins->bindValue(":seria_tabela", $inputs["tabela"], PDO::PARAM_STR);
/* <!-- meta_tags part 2 */
$ins->bindValue(":seria_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
/*image1_part6*/
$ins->bindValue(":seria_image1", $image1_originalPath, PDO::PARAM_STR);
$ins->bindValue(":seria_image1_alt", $inputs["image1_alt"], PDO::PARAM_STR);
$ins->bindValue(":seria_image1_title", $inputs["image1_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_image1_file_name", $inputs["image1_file_name"], PDO::PARAM_STR);/*image2_part6*/
$ins->bindValue(":seria_image2", $image2_originalPath, PDO::PARAM_STR);
$ins->bindValue(":seria_image2_alt", $inputs["image2_alt"], PDO::PARAM_STR);
$ins->bindValue(":seria_image2_title", $inputs["image2_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_image2_file_name", $inputs["image2_file_name"], PDO::PARAM_STR);
$ins->bindValue(':seria_show_gallery', $_POST['show_gallery'], PDO::PARAM_STR);
$ins->bindValue(':seria_parent_id', $parent_id, PDO::PARAM_STR);
                $ins->execute(); 
/*tags1_part4*/
        $return = [
            'status' => 'added',
        ];
        return $return;
} else {
/* --> end type2 part 1 */
                $ins= $this->pdo->prepare('UPDATE serie
                                            SET 											
                                            seria_url = :seria_url, seria_title = :seria_title, 
                                            seria_lang = :seria_lang, seria_hide = :seria_hide,
                                            seria_last_modified_date = NOW(), seria_last_modified_by = :seria_last_modified_by                                         
, seria_opis = :seria_opis
, seria_tabela = :seria_tabela
/* <!-- meta_tags part 1 */
, seria_meta_title = :seria_meta_title,
seria_meta_keywords = :seria_meta_keywords,
seria_meta_description = :seria_meta_description,
seria_meta_author = :seria_meta_author,
seria_meta_robots = :seria_meta_robots
/* --> End meta_tags part 1 */
/*image1_part4*/
, seria_image1 = :seria_image1,
seria_image1_alt = :seria_image1_alt,
seria_image1_title = :seria_image1_title,
seria_image1_file_name = :seria_image1_file_name/*image2_part4*/
, seria_image2 = :seria_image2,
seria_image2_alt = :seria_image2_alt,
seria_image2_title = :seria_image2_title,
seria_image2_file_name = :seria_image2_file_name
,seria_show_gallery = :seria_show_gallery
                                            WHERE
                                            seria_lang = :seria_lang 
/* <1!-- type2 part 3 */
&& seria_id = :seria_id
/* <1!-- type2 part 3 */
                                            ');
/* <1!-- type2 part 3 */
$ins->bindValue(':seria_id', $inputs['id'], PDO::PARAM_STR);
/* <1!-- type2 part 3 */
                        $ins->bindValue(':seria_url', $url, PDO::PARAM_STR);
                        $ins->bindValue(':seria_title', $inputs['title'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
						$ins->bindValue(':seria_hide', $inputs['hide'], PDO::PARAM_STR);
						$ins->bindValue(':seria_last_modified_by', $_SESSION['login'], PDO::PARAM_STR);	
$ins->bindValue(":seria_opis", $inputs["opis"], PDO::PARAM_STR);
$ins->bindValue(":seria_tabela", $inputs["tabela"], PDO::PARAM_STR);
/* <!-- meta_tags part 2 */
$ins->bindValue(":seria_meta_title", $inputs["meta_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_keywords", $inputs["meta_keywords"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_description", $inputs["meta_description"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_author", $inputs["meta_author"], PDO::PARAM_STR);
$ins->bindValue(":seria_meta_robots", $inputs["meta_robots"], PDO::PARAM_STR);
/* --> meta_tags part 2 */
/*image1_part6*/
$ins->bindValue(":seria_image1", $image1_originalPath, PDO::PARAM_STR);
$ins->bindValue(":seria_image1_alt", $inputs["image1_alt"], PDO::PARAM_STR);
$ins->bindValue(":seria_image1_title", $inputs["image1_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_image1_file_name", $inputs["image1_file_name"], PDO::PARAM_STR);/*image2_part6*/
$ins->bindValue(":seria_image2", $image2_originalPath, PDO::PARAM_STR);
$ins->bindValue(":seria_image2_alt", $inputs["image2_alt"], PDO::PARAM_STR);
$ins->bindValue(":seria_image2_title", $inputs["image2_title"], PDO::PARAM_STR);
$ins->bindValue(":seria_image2_file_name", $inputs["image2_file_name"], PDO::PARAM_STR);
$ins->bindValue(':seria_show_gallery', $_POST['show_gallery'], PDO::PARAM_STR);
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
public function serieEdit($parent_id, $id) {
        // Select main part
        $query= $this->pdo->prepare(' SELECT * FROM serie WHERE seria_lang = :lang && seria_id = :id');
		$query->bindValue(':lang', $_SESSION['editing_lang'], PDO::PARAM_STR);
$query->bindValue(':id', $id, PDO::PARAM_STR);
        $query->execute();  
        $result = $query->fetchAll();       	
        $inputs = 
        [
'id'                => $result[0]['seria_id'],
            'title'             => $result[0]['seria_title'],
            'hide'              => $result[0]['seria_hide'],
            'lang'              => $result[0]['seria_lang'],
"opis"=> $result[0]["seria_opis"],
"tabela"=> $result[0]["seria_tabela"],
/* meta_tags_part1 */
"meta_title"    	 => $result[0]["seria_meta_title"],
"meta_keywords"      => $result[0]["seria_meta_keywords"],
"meta_description"   => $result[0]["seria_meta_description"],
"meta_author"        => $result[0]["seria_meta_author"],
"meta_robots"        => $result[0]["seria_meta_robots"],
/* End meta_tags_part1 */
/* image1_part1 */
"image1" => $result[0]["seria_image1"],
"image1_alt" => $result[0]["seria_image1_alt"],
"image1_title" => $result[0]["seria_image1_title"],
"image1_file_name" => $result[0]["seria_image1_file_name"],
/* End image_1_part1 */
/* image2_part1 */
"image2" => $result[0]["seria_image2"],
"image2_alt" => $result[0]["seria_image2_alt"],
"image2_title" => $result[0]["seria_image2_title"],
"image2_file_name" => $result[0]["seria_image2_file_name"],
/* End image_2_part1 */
'show_gallery'              => $result[0]['seria_show_gallery'],          			            
        ];
		$query= $this->pdo->prepare('SELECT kategoria_title as title, kategoria_id as id
									  FROM kategorie
									  WHERE kategoria_id = :id ');
		$query->bindValue(':id', $parent_id, PDO::PARAM_STR);
		$query->execute();
		$parent = $query->fetchAll();
        $content = 
        [
            'inputs' => $inputs,
'parent_title' => $parent[0]['title'],
'parent_id' => $parent[0]['id'],
        ];
            return $content;
}
function serieDelete($parent_id, $id) {
/* image1 part1 */
$ins= $this-> pdo-> prepare("SELECT seria_image1 as image1
							FROM serie WHERE seria_id = :id");
$ins -> bindValue(":id", $id, PDO::PARAM_STR);
$ins -> execute();
$result = $ins->fetchAll();
if (!empty($result[0]["image1"])) {
	unlink($_SERVER["DOCUMENT_ROOT"].$result[0]["image1"]);
}
/* End image1 part1 */
                $ins= $this-> pdo-> prepare( 'DELETE FROM serie WHERE seria_id = :id ' );      
                $ins -> bindValue(':id', $id, PDO::PARAM_STR);
                $ins -> execute();
}
 function serieQueue() {
    $x = 1;
    foreach ($_POST['idek'] as $id) {
                $ins= $this->pdo->prepare('UPDATE serie
                                            SET 
                                            seria_queue = :queue                                        
                                            WHERE
                                            seria_id = :idek');
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                $ins->execute();
         $x++;
    }    
}function serieGallery($parent_id, $id) {
        $query=$this->pdo->prepare('SELECT seria_img_id as id, seria_img_title as title, seria_img_url_cmsthumb as cmsthumb, seria_img_url as url  
                                    FROM serie_gallery
                                    WHERE seria_img_parent_id = :id
                                    ORDER BY seria_img_queue ASC ,  seria_img_id DESC
                                        ');
		$query->bindValue(":id", $id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        $images = $result;
		// Parent name for Path
        $query=$this->pdo->prepare('SELECT kategoria_title as title FROM kategorie WHERE kategoria_id = :id ');
		$query->bindValue(":id", $parent_id, PDO::PARAM_STR);
		$query->execute();
        $parent = $query->fetchAll();
        $query=$this->pdo->prepare('SELECT seria_id as id, seria_title as title FROM serie WHERE seria_id = :id ');
        $query->bindValue(":id", $id, PDO::PARAM_STR);
		$query->execute();								
        $title = $query->fetchAll();
    $return = [
        'images' => $images,
'parent_title' => $parent[0]['title'], 'parent_id' => $parent_id,
"galleryParent_id" => $title[0][0], "galleryParent_title" => $title[0][1],
    ];
    return $return;
}function serieGalleryInsert($parent_id, $id) {
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
        } elseif ($_FILES['image']['size'] > $configuration['serie_gallery_max_size'] * 1000) {
            $errors[] = 'Rozmiar zdjęcia jest za duży. (max. '.($configuration['serie_gallery_max_size']/1000).'mb - '.($configuration['serie_gallery_max_size']).'kb)';
        } elseif ($imageWidth > $configuration['serie_gallery_max_width']) {
            $errors[] = 'Obrazek jest za szeroki. (max. '.$configuration['serie_gallery_max_width'].'px)';
        } elseif ($imageHeight > $configuration['serie_gallery_max_height']) {
             $errors[] = 'Obrazek jest za wysoki. (max. '.$configuration['serie_gallery_max_height'].'px)';
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
	$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/gallery/original/', $tempImageName, $extension );		
  	$path = '/public/images/uploads/serie/gallery/original/'.$currName.'.'.$extension;
            // Upload temporary image
            move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$path);    
        list($imageWidth, $imageHeight) = getimagesize($_SERVER['DOCUMENT_ROOT'].$path);             
/*
 *    ADD THUMB FOR CMS         
*/             
        $requiredWidth = 200;
        $requiredHeight = 150;
        $cmsThumbPath = '/public/images/uploads/serie/gallery/cms_thumb/'.$currName.'.'.$extension;
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
                                            serie_gallery 
                                            (seria_img_parent_id, 
                                            seria_img_url, 
                                            seria_img_url_cmsthumb, 
                                            seria_img_title, seria_img_content, seria_img_meta_title, seria_img_alt,  seria_img_file_name, 
                                            seria_img_date, seria_img_queue) 
                                            VALUES 
                                            (:seria_img_parent_id, :seria_img_url, 
											:seria_img_url_cmsthumb, 
											:seria_img_title, :seria_img_content, :seria_img_meta_title, :seria_img_alt, :seria_img_file_name, 
											NOW(), :seria_img_queue) 
                                            ');
$ins->bindValue(":seria_img_parent_id", $id, PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_url', $path, PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_url_cmsthumb', $cmsThumbPath, PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_title', $inputs['image_title'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_content', $inputs['image_description'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_meta_title', $inputs['image_meta_title'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_alt', $inputs['image_meta_description'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_file_name', $inputs['image_file_name'], PDO::PARAM_STR);
                        $ins->bindValue(':seria_img_queue', 0, PDO::PARAM_STR);
                $ins->execute();   
        $return = [
            'status' => 'added',
            'galleryParent_id'     => $id
        ];
        return $return;   
}function serieGalleryDelete($parent_id, $id, $imageId) {
	$query=$this->pdo->prepare('SELECT  seria_img_url_cmsthumb as cmsthumb, 
        									seria_img_url as url
        							FROM serie_gallery WHERE seria_img_id = :id ');
        $query->bindValue(':id', $imageId, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['cmsthumb']);
        }
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['url'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['url']);
        }
                $ins=$this->pdo->prepare('DELETE FROM serie_gallery WHERE seria_img_id = :id ');      
                $ins->bindValue(':id', $imageId, PDO::PARAM_STR);
                $ins->execute(); 
         $return = [
            'status' => 'deleted',
         ];
         return $return;
}function serieGalleryEdit() {
       $idek = $_POST['idek'];
            $query=$this->pdo->prepare( 'SELECT 
            								seria_img_title, 
            								seria_img_content, 
            								seria_img_meta_title, 
            								seria_img_alt, 
            								seria_img_file_name, 
            								seria_img_url_cmsthumb                              
                                          FROM serie_gallery
                                          WHERE seria_img_id = :idek
                                            ');
			$query->bindValue(':idek', $idek, PDO::PARAM_STR);
            $query->execute();  
            $result = $query->fetchAll();   
        $content = [
            'id'            => $idek,
            'title'        => $result[0]['seria_img_title'],
            'content'     => $result[0]['seria_img_content'],
            'meta_title'   => $result[0]['seria_img_meta_title'],
            'alt'           => $result[0]['seria_img_alt'],
            'file_name'    => $result[0]['seria_img_file_name'],   
            'cmsthumb'      => $result[0]['seria_img_url_cmsthumb'],        
        ];
            echo json_encode($content);
}function serieGalleryUpdate($parent_id, $id) {
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
            								seria_img_url,
            								seria_img_url_cmsthumb
                                        FROM serie_gallery
                                          WHERE seria_img_id = :idek  ');  
            $query->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);                                                                                           
            $query->execute();  
            $result = $query->fetchAll();  
			$old_mysql = $result[0]['seria_img_url'];
		    // Create name of image
		    $arr = array($_POST['edit-file-name'], $_POST['edit-meta-description'], $_POST['edit-meta-title'], $_POST['edit-title']);
		    $currName = createImageName($arr);		
			$currName = prepareName($currName);
            if (!strpos($old_mysql, $currName)) {
            	$extension = extensionFromPath($old_mysql);
				$currName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/serie/gallery/original/', $currName, $extension );	
                $original = '/public/images/uploads/serie/gallery/original/'.$currName.'.'.$extension;
                $cmsthumb = '/public/images/uploads/serie/gallery/cms_thumb/'.$currName.'.'.$extension;
                    // Original photo
                    if (!empty($result[0]['seria_img_url'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url'], $_SERVER['DOCUMENT_ROOT'].$original);
                    }                
                    if (!empty($result[0]['seria_img_url_cmsthumb'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url_cmsthumb'], $_SERVER['DOCUMENT_ROOT'].$cmsthumb);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url']);
                    }
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url_cmsthumb'])) {
                        unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['seria_img_url_cmsthumb']);
                    }
            } else {
                $original = $result[0]['seria_img_url'];
                $cmsthumb = $result[0]['seria_img_url_cmsthumb'];
            }
                $ins=$this->pdo->prepare('UPDATE serie_gallery
                                            SET 
                                            	seria_img_url = :url,
                                            	seria_img_url_cmsthumb = :cmsthumb,
                                           	 	seria_img_title = :title, seria_img_content = :content, seria_img_meta_title = :meta_title, 
                                            	seria_img_alt = :alt, seria_img_file_name = :file_name                                           
                                            WHERE
                                            	seria_img_id = :idek');
                        $ins->bindValue(':title', $_POST['edit-title'], PDO::PARAM_STR);
                        $ins->bindValue(':content', $_POST['edit-description'], PDO::PARAM_STR);
                        $ins->bindValue(':meta_title', $_POST['edit-meta-title'], PDO::PARAM_STR);
                        $ins->bindValue(':alt', $_POST['edit-meta-description'], PDO::PARAM_STR);
                        $ins->bindValue(':file_name', $_POST['edit-file-name'], PDO::PARAM_STR);
                        $ins->bindValue(':url', $original, PDO::PARAM_STR);
                        $ins->bindValue(':cmsthumb', $cmsthumb, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $_POST['edit-id'], PDO::PARAM_STR);
                $ins->execute();      
}function serieGalleryQueue() {
    $x = 1;
    foreach($_POST['idek'] as $id) {
    	$ins=$this->pdo->prepare('UPDATE serie_gallery
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