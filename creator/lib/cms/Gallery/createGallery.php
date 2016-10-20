<?php

class cms_Gallery_createGallery extends Creator {

	 public function __construct() {

	 }
	 
	public function countGalleryThumbs(array $inputName) {
		return count($inputName);
	}
	
}