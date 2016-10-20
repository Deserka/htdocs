<?php
		$query= $this->pdo->prepare('SELECT _PARENT_TABLE_PREFIX__title as title, _PARENT_TABLE_PREFIX__id as id
									  FROM _PARENT_TABLE_NAME_
									  WHERE _PARENT_TABLE_PREFIX__id = :id ');
		$query->bindValue(':id', $parent_id, PDO::PARAM_STR);
		$query->execute();
		$parent = $query->fetchAll();