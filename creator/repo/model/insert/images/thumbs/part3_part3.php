<?php	
if( is_file( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb__number__/".$image_NUMBER_OF_IMAGE__deleteName ) ) {
	unlink( $_SERVER["DOCUMENT_ROOT"]."/public/images/uploads/_CREATED_FOLDER_NAME_/main_NUMBER_OF_IMAGE_/thumb__number__/".$image_NUMBER_OF_IMAGE__deleteName );
}