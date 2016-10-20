        $query=$this->pdo->prepare('SELECT _CREATED_TABLE_PREFIX__id as id, _CREATED_TABLE_PREFIX__title as title FROM _CREATED_TABLE_NAME_ ');
		$query->execute();								
        $title = $query->fetchAll();