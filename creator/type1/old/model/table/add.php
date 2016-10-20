<?php

        try {
            require '../../config/sql.php';
            $pdo=new PDO('mysql:host='.$host.';charset=utf8;dbname='.$dbase, $user, $pass);
            //$dbh->exec("set names utf8");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Throwable $e) {
            echo 'The connect can not create: ' . $e->getMessage();
        }
		
		if ($gallery === 1) {
			$a1 = ','.$table_prefix.'_show_gallery';
			$a2 = ',"1"';
		} else {
			$a1 = ''; $a2 = '';
		}
		
		
                $ins = $pdo ->prepare( ' INSERT INTO '.$table_name.' ('.$table_prefix.'_title, '.$table_prefix.'_lang '.$a1.') VALUES ("'.$module_name.'", "pl" '.$a2.') ');
                $ins->execute();
                
        unset($a1);
		unset($a2);
