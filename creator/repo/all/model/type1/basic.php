<?php
            $query=$this->pdo->prepare( "SELECT TABLE_PREFIX_url, TABLE_PREFIX_title
                                          FROM TABLE_NAME
                                          WHERE TABLE_PREFIX_lang = :lang ");
			$query->bindValue(':lang', $_SESSION['page_lang'], PDO::PARAM_STR);
            $query->execute();
            $MODEL_NAME = $query->fetchAll();
			$content['MODEL_NAME'] = ['url' => $MODEL_NAME[MODEL_NAME_url], 'title' => $MODEL_NAME[MODEL_NAME_title]];