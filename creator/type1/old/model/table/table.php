<?php
$table_base = 
"
    CREATE TABLE ".$table_name." (
    ".$table_prefix."_id 				int(10) NOT NULL NOT NULL AUTO_INCREMENT,
    ".$table_prefix."_title 			varchar(100) NOT NULL,
    ".$table_prefix."_url 				varchar(100) NOT NULL,
    ".$table_prefix."_hide 				int(1) NOT NULL,
    ".$table_prefix."_lang 				varchar(2) NOT NULL,
    ".$table_prefix."_viewers 			int(15) NOT NULL,
    ".$table_prefix."_queue 			int(5) NOT NULL,
    ".$table_prefix."_created_date 		datetime NOT NULL,  
    ".$table_prefix."_created_by 		varchar(30) NOT NULL,    
    ".$table_prefix."_last_modified_date datetime NOT NULL,  
	".$table_prefix."_last_modified_by  varchar(30) NOT NULL,
";

$table_base_end = 
"
    PRIMARY KEY (".$table_prefix."_id)
    )  CHARACTER SET utf8 COLLATE utf8_unicode_ci;
";
