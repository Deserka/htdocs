<?php
/*image_NUMBER_OF_IMAGE__part3*/
/*
 * VALIDATION IS OK - START ADDING TO folders (image 1) -------------------------------------------------------------------------       
*/        
ini_set('memory_limit', '1024M');  // if more than 3 images and more than FHD resolution... will be a problem
if ( isset ( $inputs['temp_image_NUMBER_OF_IMAGE__path'] ) && !empty ( $inputs['temp_image_NUMBER_OF_IMAGE__path'] ) ) {		
		$image_NUMBER_OF_IMAGE__extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path']);		
		$image_NUMBER_OF_IMAGE__arrayWithNames = array($inputs['image_NUMBER_OF_IMAGE__file_name'], $inputs['image_NUMBER_OF_IMAGE__alt'], $inputs['title']);
		
		$image_NUMBER_OF_IMAGE__newName = createImageName($image_NUMBER_OF_IMAGE__arrayWithNames);		
		$image_NUMBER_OF_IMAGE__newName = prepareName($image_NUMBER_OF_IMAGE__newName);
		
		// Check if file with this name exists
		$image_NUMBER_OF_IMAGE__newName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/', $image_NUMBER_OF_IMAGE__newName, $image_NUMBER_OF_IMAGE__extension );	
		
		$image_NUMBER_OF_IMAGE__originalPath = '/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__newName.'.'.$image_NUMBER_OF_IMAGE__extension;
/*start thumbs_part1*/
/**thumbs_part1**/
/*end thumbs_part1*/
// CUT ORIGINAL IMAGE - START
        // Dimension of required main image for _CREATED_MODEL_NAME_
        $image_NUMBER_OF_IMAGE__requiredWidth = $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__required_width'];
        $image_NUMBER_OF_IMAGE__requiredHeight = $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__required_height'];
        list( $image_NUMBER_OF_IMAGE__width, $image_NUMBER_OF_IMAGE__height ) = getimagesize( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] );    
        // If original image is smaller than required - upload original image as main image
        if( $image_NUMBER_OF_IMAGE__width <= $image_NUMBER_OF_IMAGE__requiredWidth && $image_NUMBER_OF_IMAGE__height <= $image_NUMBER_OF_IMAGE__requiredHeight)
        {
            // Upload original image
            copy( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'], $_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__originalPath );
        }    
        else 
        {        	
                if( ( $image_NUMBER_OF_IMAGE__requiredWidth/$image_NUMBER_OF_IMAGE__width ) <= ( $image_NUMBER_OF_IMAGE__requiredHeight / $image_NUMBER_OF_IMAGE__height ) )
                {
                    $image_NUMBER_OF_IMAGE__percent = $image_NUMBER_OF_IMAGE__requiredHeight / $image_NUMBER_OF_IMAGE__height;
                }
                else {
                    $image_NUMBER_OF_IMAGE__percent = $image_NUMBER_OF_IMAGE__requiredWidth / $image_NUMBER_OF_IMAGE__width;
                }		                        
            // Size of new image
            $image_NUMBER_OF_IMAGE__mainImageWidth = round( $image_NUMBER_OF_IMAGE__width * $image_NUMBER_OF_IMAGE__percent );
            $image_NUMBER_OF_IMAGE__mainImageHeight = round( $image_NUMBER_OF_IMAGE__height * $image_NUMBER_OF_IMAGE__percent );                        
            // Rezize image
            $image_NUMBER_OF_IMAGE__tempImageForResize = imagecreatetruecolor( $image_NUMBER_OF_IMAGE__mainImageWidth, $image_NUMBER_OF_IMAGE__mainImageHeight );    
            $image_NUMBER_OF_IMAGE__tempImageFromOriginalImage = imagecreatefromjpeg( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] );
            imagecopyresampled( $image_NUMBER_OF_IMAGE__tempImageForResize, $image_NUMBER_OF_IMAGE__tempImageFromOriginalImage, 0, 0, 0, 0, $image_NUMBER_OF_IMAGE__mainImageWidth, $image_NUMBER_OF_IMAGE__mainImageHeight, $image_NUMBER_OF_IMAGE__width, $image_NUMBER_OF_IMAGE__height );  
            if( $image_NUMBER_OF_IMAGE__mainImageWidth > $image_NUMBER_OF_IMAGE__requiredWidth || $image_NUMBER_OF_IMAGE__mainImageHeight > $image_NUMBER_OF_IMAGE__requiredHeight )
            {
                // Cut image
                if( $image_NUMBER_OF_IMAGE__mainImageWidth > $image_NUMBER_OF_IMAGE__mainImageHeight )
                {
                    $image_NUMBER_OF_IMAGE__cutX = ( $image_NUMBER_OF_IMAGE__mainImageWidth/2 )-( $image_NUMBER_OF_IMAGE__requiredWidth/2 );
                    $image_NUMBER_OF_IMAGE__cutY = 0;                      
                }
                else 
                {
                    $image_NUMBER_OF_IMAGE__cutX = 0;
                    $image_NUMBER_OF_IMAGE__cutY = ( $image_NUMBER_OF_IMAGE__mainImageHeight/2 )-( $image_NUMBER_OF_IMAGE__requiredHeight/2 ); 
                }      
                $image_NUMBER_OF_IMAGE__totalCut = imagecreatetruecolor( $image_NUMBER_OF_IMAGE__requiredWidth, $image_NUMBER_OF_IMAGE__requiredHeight );     
                imagecopyresampled( $image_NUMBER_OF_IMAGE__totalCut, $image_NUMBER_OF_IMAGE__tempImageForResize, 0, 0, $image_NUMBER_OF_IMAGE__cutX, $image_NUMBER_OF_IMAGE__cutY, $image_NUMBER_OF_IMAGE__requiredWidth, $image_NUMBER_OF_IMAGE__requiredHeight, $image_NUMBER_OF_IMAGE__requiredWidth, $image_NUMBER_OF_IMAGE__requiredHeight );  
                imagejpeg( $image_NUMBER_OF_IMAGE__totalCut, $_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__originalPath , 100 );                   
            }
            else 
            {
                imagejpeg( $image_NUMBER_OF_IMAGE__tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__originalPath , 100 );              
            }                     
        }
// CUT ORIGINAL IMAGE - END	
/*start thumbs_part2*/
/**thumbs_part2**/
/*end thumbs_part2*/
		//New image is uploaded - delete old - if existed
		// Delete old images - if exists
		if( isset( $inputs['current_image_NUMBER_OF_IMAGE_']) && !empty ($inputs['current_image_NUMBER_OF_IMAGE_']) ) {
			$image_NUMBER_OF_IMAGE__deleteName = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$inputs['current_image_NUMBER_OF_IMAGE_']);
		    if( is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__deleteName ) )
		    {
		    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__deleteName );
		    }	
/*start thumbs_part3*/
/**thumbs_part3**/
/*end thumbs_part3*/
		}		
			
	} // end of adding image
	elseif( isset( $inputs['current_image_NUMBER_OF_IMAGE_'] ) && !empty( $inputs['current_image_NUMBER_OF_IMAGE_'] ) ) {
		$image_NUMBER_OF_IMAGE__originalPath = $inputs['current_image_NUMBER_OF_IMAGE_'];
		$image_NUMBER_OF_IMAGE__originalPath = nameAndExtFromPath($_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__originalPath);
		// name from current inputs
		$image_NUMBER_OF_IMAGE__arrayWithNames = array($inputs['image_NUMBER_OF_IMAGE__file_name'], $inputs['image_NUMBER_OF_IMAGE__alt'], $inputs['title']);
		$image_NUMBER_OF_IMAGE__potName = createImageName($image_NUMBER_OF_IMAGE__arrayWithNames);
		$image_NUMBER_OF_IMAGE__potName = prepareName($image_NUMBER_OF_IMAGE__potName);
		if (strpos($image_NUMBER_OF_IMAGE__originalPath, $image_NUMBER_OF_IMAGE__potName) === false) {
			// Check extension of image
			$image_NUMBER_OF_IMAGE__extension = extensionFromPath($_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__originalPath);
			// Check if file with this name exists
			$image_NUMBER_OF_IMAGE__potName = checkFileName( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/', $image_NUMBER_OF_IMAGE__potName, $image_NUMBER_OF_IMAGE__extension );	
			// Copy file - then delete old image		
			    if (is_file( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__originalPath )) {
			    	copy( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__originalPath, 
			    			$_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__potName.'.'.$image_NUMBER_OF_IMAGE__extension );
			    	unlink( $_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__originalPath );
			    }	
/*start thumbs_part4*/
/**thumbs_part4**/
/*end thumbs_part4*/	
			// can't be eariler - deleted with old names
			$image_NUMBER_OF_IMAGE__originalPath = '/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__potName.'.'.$image_NUMBER_OF_IMAGE__extension;
/*start thumbs_part5*/
/**thumbs_part5**/	
/*end thumbs_part5*/
		} else {
			$oldImageName = $image_NUMBER_OF_IMAGE__originalPath;
			$image_NUMBER_OF_IMAGE__originalPath = '/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/original/'.$image_NUMBER_OF_IMAGE__originalPath;
/*start thumbs_part6*/
/**thumbs_part6**/
/*end thumbs_part6*/
		}		
					
	} else {
		$image_NUMBER_OF_IMAGE__originalPath = '';
/*start thumbs_part7*/
/**thumbs_part7**/
/*end thumbs_part7*/
	}

// Delete temporary image ??????????????????????????????????????????????????????????????????????????????????????????????????????????????????
            // Unlink temporary image
            if( isset( $inputs['temp_image_NUMBER_OF_IMAGE__path'] ) && is_file( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] ) )
            {
                unlink( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] );
            }		
