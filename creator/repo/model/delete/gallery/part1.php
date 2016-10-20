<?php /* image_NUMBER_OF_IMAGE_ part1 */
$ins= $this-> pdo-> prepare("SELECT _CREATED_TABLE_PREFIX__image_NUMBER_OF_IMAGE_ as image_NUMBER_OF_IMAGE_
								/**thumbs_part1**/
							FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__id = :id");
$ins -> bindValue(":id", $id, PDO::PARAM_STR);
$ins -> execute();
$result = $ins->fetchAll();
if (!empty($result[0]["image_NUMBER_OF_IMAGE_"])) {
	unlink($_SERVER["DOCUMENT_ROOT"].$result[0]["image_NUMBER_OF_IMAGE_"]);
}
/**thumbs_part2**/
/* End image_NUMBER_OF_IMAGE_ part1 */