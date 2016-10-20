<?php

class cms_model_createBasicModel extends Creator {

	 public function __construct() {

	 }
	 
	 
	public function prepareModel($content, $model_name, $table_name, $table_prefix, $folder_name, $config_name) {
		$content = str_replace('}/**delete**/', '', $content); // Delete unwanted if
		$content = str_replace('_CREATED_MODEL_NAME_', $model_name, $content); // Set url 
		$content = str_replace('_CREATED_TABLE_NAME_', $table_name, $content); // Set table name 
		$content = str_replace('_CREATED_TABLE_PREFIX_', $table_prefix, $content); // Set table prefix 
		$content = str_replace('_CREATED_FOLDER_NAME_', $folder_name, $content); // Set folder name 
		$content = str_replace('_CREATED_CONFIG_NAME_', $config_name, $content); 
		return $content;
	}
	 
	public function endModel($content) {
		$content = $content . '}';
		return $content;
	}	 

	 
	 
}