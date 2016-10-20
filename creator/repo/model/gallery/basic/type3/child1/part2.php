        $query=$this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__id as id, _CREATED_TABLE_PREFIX__title as title FROM _CREATED_TABLE_NAME_ WHERE _CREATED_TABLE_PREFIX__id = :id ');
        $query->bindValue(":id", $id, PDO::PARAM_STR);
		$query->execute();								
        $title = $query->fetchAll();