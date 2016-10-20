<?php
// ADD THUMB FOR WEBSITE - THUMB /**_NUMBER_OF_THUMB_**/   
        $thumb_NUMBER_OF_THUMB_RequiredWidth = $configuration['_CREATED_CONFIG_NAME__gallery_thumb_NUMBER_OF_THUMB__width'];
        $thumb_NUMBER_OF_THUMB_RequiredHeight = $configuration['_CREATED_CONFIG_NAME__gallery_thumb_NUMBER_OF_THUMB__height'];
        $pageThumb_NUMBER_OF_THUMB_Path = '/public/images/uploads/_CREATED_FOLDER_NAME_/gallery/thumb_NUMBER_OF_THUMB_/'.$currName.'.'.$extension;
    // If original image is smaller than required - upload original image as main image
        if($imageWidth <= $thumb_NUMBER_OF_THUMB_RequiredWidth && $imageHeight <= $thumb_NUMBER_OF_THUMB_RequiredHeight) {
            // Upload thumb from original file
            copy($_SERVER['DOCUMENT_ROOT'].$path, $_SERVER['DOCUMENT_ROOT'].$pageThumb_NUMBER_OF_THUMB_Path);
        } else {
                if( ( $thumb_NUMBER_OF_THUMB_RequiredWidth/$imageWidth ) <= ( $thumb_NUMBER_OF_THUMB_RequiredHeight / $imageHeight ) ) {
                    $percent = $thumb_NUMBER_OF_THUMB_RequiredHeight / $imageHeight;
                } else {
                    $percent = $thumb_NUMBER_OF_THUMB_RequiredWidth / $imageWidth;
                }				
            // Size of new image
            $thumb_NUMBER_OF_THUMB_ImageWidth = round($imageWidth * $percent);
            $thumb_NUMBER_OF_THUMB_ImageHeight = round($imageHeight * $percent);                 
            // Rezize image
            $tempImageForResize = imagecreatetruecolor($thumb_NUMBER_OF_THUMB_ImageWidth, $thumb_NUMBER_OF_THUMB_ImageHeight);    
            $tempImageFromOriginalImage = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'].$path);
            imagecopyresampled($tempImageForResize, $tempImageFromOriginalImage, 0, 0, 0, 0, $thumb_NUMBER_OF_THUMB_ImageWidth, $thumb_NUMBER_OF_THUMB_ImageHeight, $imageWidth, $imageHeight);
            if($thumb_NUMBER_OF_THUMB_ImageWidth > $requiredWidth || $thumb_NUMBER_OF_THUMB_ImageHeight > $requiredHeight) {
               // Cut image
                if($thumb_NUMBER_OF_THUMB_ImageWidth > $thumb_NUMBER_OF_THUMB_ImageHeight) {
                    $cutX = ($thumb_NUMBER_OF_THUMB_ImageWidth/2)-($thumb_NUMBER_OF_THUMB_RequiredWidth/2);
                    $cutY = 0;                      
                } else {
                    $cutX = 0;
                    $cutY = ($thumb_NUMBER_OF_THUMB_ImageHeight/2)-($thumb_NUMBER_OF_THUMB_RequiredHeight/2); 
                }      
                $totalCut = imagecreatetruecolor($thumb_NUMBER_OF_THUMB_RequiredWidth, $thumb_NUMBER_OF_THUMB_RequiredHeight);     
                imagecopyresampled($totalCut, $tempImageForResize, 0, 0, $cutX, $cutY, $thumb_NUMBER_OF_THUMB_RequiredWidth, $thumb_NUMBER_OF_THUMB_RequiredHeight, $thumb_NUMBER_OF_THUMB_RequiredWidth, $thumb_NUMBER_OF_THUMB_RequiredHeight);  
                imagejpeg($totalCut, $_SERVER['DOCUMENT_ROOT'].$pageThumb_NUMBER_OF_THUMB_Path , 100);                        
            } else {
                imagejpeg($tempImageForResize, $_SERVER['DOCUMENT_ROOT'].$pageThumb_NUMBER_OF_THUMB_Path , 100);             
            }
        }
// END ADD THUMB FOR WEBSITE - THUMB /**_NUMBER_OF_THUMB_**/