<?php


$theadRowsAmount = 2;

function tableForCms($inputs, $firstTableCmsContent) {
	$firstTableCmsContent = preg_replace('/<input class="table-input firstTable" name="firstTable\[\]" value="(.*?)" type="text">/', "0%%%%%0", $firstTableCmsContent);
	//$firstTableCmsContent = str_replace('<input class="table-input firstTable" name="firstTable[]" value="" type="text">', '0%%%%%0', $firstTableCmsContent);
	var_dump($firstTableCmsContent);
	foreach ($inputs as $input) {
		$firstTableCmsContent = preg_replace('/0%%%%%0/', '<input class="table-input firstTable" name="firstTable[]" value="' . htmlentities($input) . '" type="text">', $firstTableCmsContent, 1);
	}
	//$firstTableCmsContent = htmlspecialchars($firstTableCmsContent);
	return $firstTableCmsContent;
}

function tablePrepare($inputs, $columnsAmount, $theadRowsAmount=NULL) {
	$countInputs = count($inputs);
	$rows = $countInputs / $columnsAmount;
	for ($i=0; $i<$rows; $i++) {
		for ($x=0; $x<$columnsAmount; $x++) {
			$temp[] = $inputs[0];
			unset($inputs[0]);
			$inputs = array_values($inputs);
		}
	   $table[] = $temp;
	   unset($temp);
	}
	return $table;
}
function createTableToShow($preparedTable, $theadRowsAmount) {
	$table[] = '<table class="product-table">';
	if ($theadRowsAmount !== NULL && is_int($theadRowsAmount) && $theadRowsAmount >0) {
		$table[] = '<thead>';
		for ($i=0; $i <$theadRowsAmount; $i++) {
			$table[] = '<tr>';
					foreach ($preparedTable[0] as $th) {
						$table[] = '<th>' . $th . '</th>';
					}
					unset($preparedTable[0]);
					$preparedTable = array_values($preparedTable);
			$table[] = '</tr>';
		}
		$table[] = '</thead>';
	}
	if (!empty($preparedTable)) {
		$table[] = '<tbody>';
		for ($i=0; $i<count($preparedTable); $i) {
			$table[] = '<tr>';
					foreach ($preparedTable[0] as $td) {
						$table[] = '<td>' . $td . '</td>';
					}
					unset($preparedTable[0]);
					$preparedTable = array_values($preparedTable);
			$table[] = '</tr>';
		}
		$table[] = '</tbody>';
	}
	$table[] = '</table>';
	return $table = implode('', $table);
}

$preparedTable = tablePrepare($_POST['firstTable'], $_POST['firstTableColumnsAmount'], $theadRowsAmount);
$table = createTableToShow($preparedTable, $theadRowsAmount);
$tableForCms = tableForCms($_POST['firstTable'], $_POST['firstTableCmsContent']);





?>
<html>
	<head>
		<style>
			table.product-table {border-collapse: collapse;}
			table.product-table th , table.product-table td{text-align: center; padding: 5px; }
			table.product-table thead tr{ color: #595959; background: #f2f2f2 }
			table.product-table thead tr:first-child{ background: #595959; color: white; }
			table.product-table thead tr th{ border-right: 2px solid white;  }
			
			table.product-table tbody {border-top: 2px solid #c00000; border-bottom: 2px solid #c00000; }
			table.product-table tbody tr:nth-child(odd) {background: #bfbfbf}
			table.product-table tbody tr:nth-child(even) {background: #f2f2f2}
			table.product-table tbody tr td{ border-right: 2px solid white; }
		</style>
	</head>
	<body>
		<?php echo $table; ?>
		<?php echo $tableForCms; ?>
		<?php //echo htmlspecialchars_decode($tableForCms); ?>
	</body>
</html>


