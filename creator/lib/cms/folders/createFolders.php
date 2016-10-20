<?php

class cms_folders_createFolders extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {
		
	}
	
	public function deleteFolders($dir) {
		if (file_exists($dir)) {
			$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
			$files = new RecursiveIteratorIterator($it,
			             RecursiveIteratorIterator::CHILD_FIRST);
			foreach($files as $file) {
			    if ($file->isDir()){
			        rmdir($file->getRealPath());
			    } else {
			        unlink($file->getRealPath());
			    }
			}
			rmdir($dir);	
		}		
	}	
	
	public function createEditorFolders($folderName, $amount) {
		for ($i=1; $i<=$amount; $i++) {
	        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName)) {
	            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName, 0777, true);
	        }  
	        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/editor' . $i)) {
	            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/editor' . $i, 0777, true);
	        }  
	        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/editor' . $i . '/thumbs')) {
	            mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/editor' . $i . '/thumbs', 0777, true);
	        }
		}
	}
	
	public function createGalleryFolders($folderName, $thumbsAmount) {
	    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName)) {
	        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName, 0777, true);
	    }  
	    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery')) {
	        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery', 0777, true);
	    }  
	    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/cms_thumb')) {
	        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/cms_thumb', 0777, true);
	    }  
	    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/original')) {
	        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/original', 0777, true);
	    }
		for ($x=1; $x<=$thumbsAmount; $x++) {
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/thumb' . $x)) {
		        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/gallery/thumb' . $x, 0777, true);
		    }
		}
	}	

	public function createImagesFolders($folderName, array $imagesAndThumbs) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName)) {
		        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName, 0777, true);
		    }  
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j)) {
		        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j, 0777, true);
		    }  
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/original')) {
		        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/original', 0777, true);
		    }  	
		    if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/temp')) {
		        mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/temp', 0777, true);
		    }
			// Thumbs
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/thumb' . $x)) {
					    mkdir($_SERVER['DOCUMENT_ROOT'].'/public/images/uploads/' . $folderName . '/main' . $j . '/thumb' . $x, 0777, true);	
					}
				}
			}
		}
		
		

	}
	
	
	

	
	
}