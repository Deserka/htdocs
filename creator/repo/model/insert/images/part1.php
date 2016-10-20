<?php
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