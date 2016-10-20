<?php

class page_elements_elementsCollector extends Creator {

   /**
    * @var array
    */
	private $whatever;

	public function __construct() {

	}
	
	public function collecElementsBasic(array $elements) {
		array_push($elements, 'id');
		array_push($elements, 'title');
		array_push($elements, 'url');
		array_push($elements, 'hide');
		array_push($elements, 'lang');
		array_push($elements, 'viewers');
		array_push($elements, 'queue');
		array_push($elements, 'created_date');
		array_push($elements, 'created_by');
		array_push($elements, 'last_modified_date');
		array_push($elements, 'last_modified_by');
		return $elements;
	}
	
	public function collecElementsMetaTags(array $elements) {
		array_push($elements, 'meta_title');
		array_push($elements, 'meta_keywords');
		array_push($elements, 'meta_description');
		array_push($elements, 'meta_author');
		array_push($elements, 'meta_robots');
		return $elements;
	}
	
	public function collecElementsImages(array $elements, array $imagesAndThumbs) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			array_push($elements, 'image');
			array_push($elements, 'image' . $j . '_alt');
			array_push($elements, 'image' . $j . '_title');
			array_push($elements, 'image' . $j . '_file_name');
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					array_push($elements, 'image' . $j . '_thumb' . $x);
				}
			}
		}
		return $elements;
	}
	
	public function collecElementsOwnColumns(array $elements, array $columnName) {
		for($i=0; $i<count($columnName); $i++) {
			array_push($elements, $columnName[$i]);
		}
		return $elements;
	}
	
	public function collecElementsGalleryButton(array $elements) {
		array_push($elements, 'show_gallery');
		return $elements;
	}
	
	
	
	
	
	
	
	
	
	
	public function insertTables($connection, $tables) {
		try {
		    $connection-> exec($tables);
		    echo 'Tabele utworzone.<br />';
		} catch(PDOException $e) {
		    echo "<br />" . $e->getMessage()."<br />";
		}
	}

	public function insertData($tableName, $tablePrefix, $name) {
		$content = "INSERT INTO " . $tableName . " (
			" . $tablePrefix . "_title,
			" . $tablePrefix . "_lang,
			" . $tablePrefix . "_created_date,
			" . $tablePrefix . "_created_by
			)
			VALUES
			('" . $name . "',
			'pl',
			NOW(),
			'creator'
			
			); ";
		return $content;
	}

	public function startBasicsTable($tableName, $tablePrefix) {
		return $content = 
		"CREATE TABLE ".$tableName." (
		    ".$tablePrefix."_id 				int(10) NOT NULL NOT NULL AUTO_INCREMENT,
		    ".$tablePrefix."_title 			varchar(100) NOT NULL,
		    ".$tablePrefix."_url 				varchar(100) NOT NULL,
		    ".$tablePrefix."_hide 				int(1) NOT NULL,
		    ".$tablePrefix."_lang 				varchar(2) NOT NULL,
		    ".$tablePrefix."_viewers 			int(15) NOT NULL,
		    ".$tablePrefix."_queue 			int(5) NOT NULL,
		    ".$tablePrefix."_created_date 		datetime NOT NULL,  
		    ".$tablePrefix."_created_by 		varchar(30) NOT NULL,    
		    ".$tablePrefix."_last_modified_date datetime NOT NULL,  
			".$tablePrefix."_last_modified_by  varchar(30) NOT NULL,";
	}
	
	
	
	public function EndBasicsTable($tablePrefix) {
		return $content =
		"PRIMARY KEY (".$tablePrefix."_id)
		    )  CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
	}	
	
	public function createType3Elements($tablePrefix) {
		$content[] = $tablePrefix."_parent_id varchar(500) NOT NULL,\n";

		return implode('', $content);
	}
	
	public function createOwnColumnsElements($tablePrefix, $columnName, $columnType, $columnLength) {
		$count = count($columnName);
		for($i=0; $i<$count; $i++) {
			if ($columnType[$i] != 'text') {
				$table[] = $tablePrefix . '_' . $columnName[$i] . ' ' . $columnType[$i].  '(' . $columnLength[$i] . ') NOT NULL,' . "\n";
			} else {
				$table[] = $tablePrefix . '_' . $columnName[$i] . ' ' . $columnType[$i] . ' NOT NULL,' . "\n";
			}			
		}
		return implode('', $table);
	}
	
	public function createImagesAndThumbsElements(array $imagesAndThumbs, $tablePrefix) {
		for ($i=0; $i<$imagesAndThumbs[0]; $i++) {
			$j = $i+1;
			$content[] = $tablePrefix."_image" . $j . " varchar(500) NOT NULL,\n";
			$content[] = $tablePrefix."_image" . $j . "_alt varchar(500) NOT NULL,\n";
			$content[] = $tablePrefix."_image" . $j . "_title varchar(500) NOT NULL,\n";
			$content[] = $tablePrefix."_image" . $j . "_file_name varchar(500) NOT NULL,\n";
			if ($imagesAndThumbs[1][$i] != 0) {
				for($x=1; $x<=$imagesAndThumbs[1][$i]; $x++) {
					$content[] = $tablePrefix."_image" . $j . "_thumb" . $x . " varchar(500) NOT NULL,\n";
				}
			}
		}
		return $content = implode('', $content);
	}
		
	public function createMetaTagsElements($tablePrefix) {
		return $content =
		$tablePrefix."_meta_title varchar(400) NOT NULL,".
		$tablePrefix."_meta_keywords varchar(350) NOT NULL,".
		$tablePrefix."_meta_description varchar(400) NOT NULL,".
		$tablePrefix."_meta_author varchar(30) NOT NULL,".
		$tablePrefix."_meta_robots varchar(50) NOT NULL,";
	}
	
	public function createGalleryElements($tablePrefix) {
		$content = $tablePrefix."_show_gallery int(1) NOT NULL,";
		return $content;

	}
	
	public function createGalleryTable($tableName, $tablePrefix, $thumbsAmount=NULL) {
		$content[] = 
			"CREATE TABLE ".$tableName."_gallery (".	
	        $tablePrefix."_img_id int(10) NOT NULL AUTO_INCREMENT,".
	        $tablePrefix."_img_parent_id int(10) NOT NULL,".
	        $tablePrefix."_img_url varchar(200) NOT NULL,";
		
		if ($thumbsAmount !== NULL) {
			for ($x=1; $x<=$thumbsAmount; $x++) {
				$content[] = $tablePrefix."_img_url_thumb" . $x ." varchar(200) NOT NULL,";
			}
		}
		
		$content[] =
	        $tablePrefix."_img_url_pagethumb varchar(200) NOT NULL,".
	        $tablePrefix."_img_url_cmsthumb   varchar(200)    NOT NULL,".
	        $tablePrefix."_img_title          varchar(200)    NOT NULL,".
	        $tablePrefix."_img_content        varchar(200)    NOT NULL,".
	        $tablePrefix."_img_alt            varchar(200)    NOT NULL,".
	        $tablePrefix."_img_meta_title     varchar(200)    NOT NULL,".  
	        $tablePrefix."_img_file_name      varchar(200)    NOT NULL,".
	        $tablePrefix."_img_date           DATETIME    	 NOT NULL,".
	        $tablePrefix."_img_queue          int(10)     	 NOT NULL,".
	          "PRIMARY KEY (".$tablePrefix."_img_id)
	        )  CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
		$content = implode('', $content);
		return $content;
	}
	
	public function createTagsTable($tableName, $tablePrefix) {
		return $content =
		
	    "CREATE TABLE " . $tableName . "_tags_connection(
	    connector_id int(10) NOT NULL AUTO_INCREMENT,
	    con_" . $tablePrefix . "_id int(5) NOT NULL,
	    con_tag_id int(5) NOT NULL,    
	    UNIQUE KEY (con_".$tablePrefix."_id, con_tag_id),
	    PRIMARY KEY (connector_id)
	    )    
	    CHARACTER SET utf8 COLLATE utf8_unicode_ci".
		
	    "CREATE TABLE  ".$tableName."_tags(
	    tag_id int(10) NOT NULL AUTO_INCREMENT,
	    tag_name varchar(100) NOT NULL,
	    tag_url varchar(100) NOT NULL,
	    UNIQUE KEY (tag_name),
	    KEY (tag_id)
	    )
	    CHARACTER SET utf8 COLLATE utf8_unicode_ci;";
	}
	
		
	
	public function deleteTables($pdo, $tableName) {
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."\n\r<br />";
		}	
		
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."_gallery'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."_gallery") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."_gallery\n\r<br />";
		}	
		
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."_tags'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."_tags") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."_tags\n\r<br />";
		}
		
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."_tags_connection'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."_tags_connection") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."_tags_connection\n\r<br />";
		}
		
		
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."_tags2'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."_tags2") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."_tags2\n\r<br />";
		}
		
		$query=$pdo->prepare("SHOW TABLES LIKE '".$tableName."_tags2_connection'") ;
		$query -> execute();
		$check2 = $query->fetchAll();
		if( isset($tableName) && isset($check2[0]) && !empty($tableName) && $check2[0] != NULL )
		{
		    $query=$pdo->prepare("DROP TABLE ".$tableName."_tags2_connection") ;  
		    $query -> execute();  
		    echo "Usunięto tabelę ".$tableName."_tags2_connection\n\r<br />";
		}		
		
	}

	
	
}