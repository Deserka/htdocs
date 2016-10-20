<?php
			$query=$this->pdo->prepare( "SELECT _PAGE_TABLE_PREFIX__img_url as img_url, _PAGE_TABLE_PREFIX__img_url_pagethumb as pagethumb, _PAGE_TABLE_PREFIX__img_title as img_title, _PAGE_TABLE_PREFIX__img_content as img_content, 
										_PAGE_TABLE_PREFIX__img_meta_title as img_meta_title, _PAGE_TABLE_PREFIX__img_alt as img_alt
										FROM _PAGE_TABLE_NAME__gallery WHERE _PAGE_TABLE_PREFIX__img_parent_id = :id ORDER BY _PAGE_TABLE_PREFIX__img_queue ASC ");
	            $query->bindValue(':id', $result[0]['_PAGE_TABLE_PREFIX__id'], PDO::PARAM_STR);			
			$query->execute();	
			$images = $query->fetchAll();