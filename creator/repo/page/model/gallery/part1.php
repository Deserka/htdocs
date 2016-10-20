<?php
		if ($result[0]['gallery'] === 1) {
			$query=$this->pdo->prepare("
				SELECT * 
				TABLE_PREFIX_img_id,
				TABLE_PREFIX_img_parent_id,
				TABLE_PREFIX_img_url,
				/**thumbs_part1**/
				TABLE_PREFIX_img_title,
				TABLE_PREFIX_img_content,
				TABLE_PREFIX_img_alt,
				TABLE_PREFIX_img_meta_title,
				TABLE_PREFIX_img_file_name,
				TABLE_PREFIX_img_date,
				TABLE_PREFIX_img_queue,
			");
		    $query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);
			$query->execute();	
			$gallery = $query->fetchAll();
		}