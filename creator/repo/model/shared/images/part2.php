<?php
/*image_NUMBER_OF_IMAGE__part2*/
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

    // If image is for uplaod - validate it
    if( isset( $_FILES['image_NUMBER_OF_IMAGE_']['tmp_name'] ) && !empty ( $_FILES['image_NUMBER_OF_IMAGE_']['tmp_name'] ) ) {
		$image_NUMBER_OF_IMAGE__go_for_validate = 1;
						
    }
	// Image wasn't uploaded this time - but earlier was. We've got temporary image in folder - validated already.
	elseif ( isset ( $inputs['temp_image_NUMBER_OF_IMAGE__path'] ) && !empty ( $inputs['temp_image_NUMBER_OF_IMAGE__path'] ) ) {
		
		$inputs['temp_image_NUMBER_OF_IMAGE__path'] = $inputs['temp_image_NUMBER_OF_IMAGE__path'];
		
	}
	
// Validate new (just added) image
if( isset( $image_NUMBER_OF_IMAGE__go_for_validate ) && $image_NUMBER_OF_IMAGE__go_for_validate === 1 ){
	
        $image_NUMBER_OF_IMAGE__allowedExts = array('gif', 'jpeg', 'jpg', 'png');
        $image_NUMBER_OF_IMAGE_Temp = explode('.', $_FILES['image_NUMBER_OF_IMAGE_']['name']);
        $image_NUMBER_OF_IMAGE__extension = end( $image_NUMBER_OF_IMAGE_Temp );
        $image_NUMBER_OF_IMAGE__finfo = finfo_open( FILEINFO_MIME_TYPE );
        $image_NUMBER_OF_IMAGE__mime = finfo_file( $image_NUMBER_OF_IMAGE__finfo, $_FILES['image_NUMBER_OF_IMAGE_']['tmp_name'] );  
        $image_NUMBER_OF_IMAGE__imageDimension = getimagesize( $_FILES['image_NUMBER_OF_IMAGE_']['tmp_name'] );
        $image_NUMBER_OF_IMAGE__imageWidth = $image_NUMBER_OF_IMAGE__imageDimension[0];          
        $image_NUMBER_OF_IMAGE__imageHeight = $image_NUMBER_OF_IMAGE__imageDimension[1];        
        

		
        if ( ( $image_NUMBER_OF_IMAGE__mime !== 'image/gif') && ( $image_NUMBER_OF_IMAGE__mime !== 'image/jpeg' ) && ( $image_NUMBER_OF_IMAGE__mime !== 'image/pjpeg' ) && ( $image_NUMBER_OF_IMAGE__mime !== 'image/x-png' ) && ( $image_NUMBER_OF_IMAGE__mime !== 'image/png' ) ) {
            $errors[] = '_CREATED_NAME_: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)';
        }      
        elseif( !in_array( strtolower( $image_NUMBER_OF_IMAGE__extension ), $image_NUMBER_OF_IMAGE__allowedExts ) ) {
            $errors[] = '_CREATED_NAME_: Błędny format zdjęcia. (dostępne: jpg, jpeg, png, gif)2';
        }       
        elseif( isset( $_FILES['image_NUMBER_OF_IMAGE_']['size'] ) && ($_FILES['image_NUMBER_OF_IMAGE_']['size'] / 1000) > $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_size'] ) {
            $errors[] = '_CREATED_NAME_: Rozmiar zdjęcia jest za duży. (max. '.( $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_size']/1000 ).'mb - '.$configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_size'].'kb)';
        } 
        elseif ($configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_width'] > 0 && $image_NUMBER_OF_IMAGE__imageWidth > $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_width']) {
        		$errors[] = '_CREATED_NAME_: Obrazek jest za szeroki. ( max. '.$configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_width'].'px )';
        }
        elseif ($configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_height'] > 0 && $image_NUMBER_OF_IMAGE__imageHeight > $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_height']) {
        		$errors[] = '_CREATED_NAME_: Obrazek jest za wysoki. ( max. '.$configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__max_height'].'px )';
        }
		else {
            // Create temporary name for image
            $image_NUMBER_OF_IMAGE__name =  uniqid().'.'.$image_NUMBER_OF_IMAGE__extension;
            // Upload temporary image
            move_uploaded_file( $_FILES['image_NUMBER_OF_IMAGE_']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/temp/'.$image_NUMBER_OF_IMAGE__name );    
            // Delete files from temp if last modification of file is further than 24h
                    // Get all files from temp
                    $image_NUMBER_OF_IMAGE__files = glob($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/temp/*'); 
                    foreach( $image_NUMBER_OF_IMAGE__files as $image_NUMBER_OF_IMAGE__file )
                    { 
                      if( is_file( $image_NUMBER_OF_IMAGE__file ) )
                        if((time() - filemtime( $image_NUMBER_OF_IMAGE__file )) > 86400)
                        {
                            unlink( $image_NUMBER_OF_IMAGE__file );
                        }
                    } 
            // Save that temp image was created
            $inputs['temp_image_NUMBER_OF_IMAGE__path'] = '/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/temp/'.$image_NUMBER_OF_IMAGE__name; 				
		} 	
}