<?php
		// Parent name for Path
        $query=$this->pdo->prepare('SELECT *parent table prefix*_title as title FROM *parent table name* WHERE *parent table prefix*_id = :id ');
		$query->bindValue(":id", $parent_id, PDO::PARAM_STR);
		$query->execute();
        $parent = $query->fetchAll();