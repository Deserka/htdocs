<?php function _CREATED_MODEL_NAME_Queue() {
    $x = 1;
    foreach ($_POST['idek'] as $id) {
                $ins= $this->pdo->prepare('UPDATE _CREATED_TABLE_NAME_
                                            SET 
                                            _CREATED_TABLE_PREFIX__queue = :queue                                        
                                            WHERE
                                            _CREATED_TABLE_PREFIX__id = :idek');
                        $ins->bindValue(':queue', $x, PDO::PARAM_STR);
                        $ins->bindValue(':idek', $id, PDO::PARAM_STR);
                $ins->execute();
         $x++;
    }    
}