<?php			
	/*thumb __number__*/
		        // Dimension of required main image for _CREATED_MODEL_NAME_
		        $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth = $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__thumb__number___width'];
		        $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight = $configuration['_CREATED_CONFIG_NAME__image_NUMBER_OF_IMAGE__thumb__number___height'];
		        list( $image_NUMBER_OF_IMAGE__thumb__number___width, $image_NUMBER_OF_IMAGE__thumb__number___height ) = getimagesize( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] );
		       
		        // If original image is smaller than required - upload original image as main image
		        if( $image_NUMBER_OF_IMAGE__thumb__number___width <= $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth && $image_NUMBER_OF_IMAGE__thumb__number___height <= $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight)
		        {
		            // Upload original image
		            copy( $_SERVER['DOCUMENT_ROOT'] . $inputs['temp_image_NUMBER_OF_IMAGE__path'], $_SERVER['DOCUMENT_ROOT'] . $image_NUMBER_OF_IMAGE__thumb__number__Path );
		        }    
		        else 
		        {
		                if( ( $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth/$image_NUMBER_OF_IMAGE__thumb__number___width ) <= ( $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight / $image_NUMBER_OF_IMAGE__thumb__number___height ) )
		                {
		                    $image_NUMBER_OF_IMAGE__thumb__number___percent = $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight / $image_NUMBER_OF_IMAGE__thumb__number___height;
		                }
		                else {
		                    $image_NUMBER_OF_IMAGE__thumb__number___percent = $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth / $image_NUMBER_OF_IMAGE__thumb__number___width;
		                }     				            
		            
		            // Size of new image
		            $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth = round( $image_NUMBER_OF_IMAGE__thumb__number___width * $image_NUMBER_OF_IMAGE__thumb__number___percent );
		            $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight = round( $image_NUMBER_OF_IMAGE__thumb__number___height * $image_NUMBER_OF_IMAGE__thumb__number___percent );            
		            
		            // Rezize image
		            $image_NUMBER_OF_IMAGE__thumb__number___tempImageForResize = imagecreatetruecolor( $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth, $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight );    
		            $image_NUMBER_OF_IMAGE__thumb__number___tempImageFromOriginalImage = imagecreatefromjpeg( $_SERVER['DOCUMENT_ROOT'].$inputs['temp_image_NUMBER_OF_IMAGE__path'] );
		            imagecopyresampled( $image_NUMBER_OF_IMAGE__thumb__number___tempImageForResize, $image_NUMBER_OF_IMAGE__thumb__number___tempImageFromOriginalImage, 0, 0, 0, 0, $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth, $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight, $image_NUMBER_OF_IMAGE__thumb__number___width, $image_NUMBER_OF_IMAGE__thumb__number___height );  
		
		            if( $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth > $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth || $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight > $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight )
		            {
		                // Cut image
		                if( $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth > $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight )
		                {
		                    $image_NUMBER_OF_IMAGE__thumb__number___cutX = ( $image_NUMBER_OF_IMAGE__thumb__number___mainImageWidth/2 )-( $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth/2 );
		                    $image_NUMBER_OF_IMAGE__thumb__number___cutY = 0;                      
		                }
		                else 
		                {
		                    $image_NUMBER_OF_IMAGE__thumb__number___cutX = 0;
		                    $image_NUMBER_OF_IMAGE__thumb__number___cutY = ( $image_NUMBER_OF_IMAGE__thumb__number___mainImageHeight/2 )-( $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight/2 ); 
		                }      
		                $image_NUMBER_OF_IMAGE__thumb__number___totalCut = imagecreatetruecolor( $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth, $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight );     
		                imagecopyresampled( $image_NUMBER_OF_IMAGE__thumb__number___totalCut, $image_NUMBER_OF_IMAGE__thumb__number___tempImageForResize, 0, 0, $image_NUMBER_OF_IMAGE__thumb__number___cutX, $image_NUMBER_OF_IMAGE__thumb__number___cutY, $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth, $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight, $image_NUMBER_OF_IMAGE__thumb__number___requiredWidth, $image_NUMBER_OF_IMAGE__thumb__number___requiredHeight );  
		                imagejpeg( $image_NUMBER_OF_IMAGE__thumb__number___totalCut, $_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__thumb__number__Path , 100 );                         
		            }
		            else 
		            {
		                imagejpeg( $image_NUMBER_OF_IMAGE__thumb__number___tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$image_NUMBER_OF_IMAGE__thumb__number__Path , 100 );             
		            }                     
		        }  
	/*end thumb___number__*/