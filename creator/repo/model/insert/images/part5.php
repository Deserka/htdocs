/*image_NUMBER_OF_IMAGE__part6*/
$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_", $image_NUMBER_OF_IMAGE__originalPath, PDO::PARAM_STR);
/**thumbs**/
$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__alt", $inputs["image_NUMBER_OF_IMAGE__alt"], PDO::PARAM_STR);
$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__title", $inputs["image_NUMBER_OF_IMAGE__title"], PDO::PARAM_STR);
$ins->bindValue(":_CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE__file_name", $inputs["image_NUMBER_OF_IMAGE__file_name"], PDO::PARAM_STR);