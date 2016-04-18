<?php

function getDb(){
    $db = new PDO(DB_CONNECT_STR, DB_USER_NAME, DB_PASSWORD);  //for mysql
    //$db = new PDO(DB_CONNECT_STR);  //for postgresql
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $db;
}


function getResult($q2){
    $db = getDb();
    $stmt = $db->prepare('SELECT q3, count(1) AS total FROM question WHERE q2 = ? and q3 is not null GROUP BY q3 ORDER BY q3');
    $stmt->execute(array($q2));

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['q3']] = $row['total'];
    }
    
    $db = null;
    
    print_r($ret);
    return $ret;
}
?>