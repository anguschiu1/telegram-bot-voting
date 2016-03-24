<?php

function getDb(){
    $db = new PDO(DB_CONNECT_STR, DB_USERNAME, DB_PASSWORD);  //for mysql
    //$db = new PDO(DB_CONNECT_STR);  //for postgresql
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $db;
}
function addRecords($userId, $userName, $poll){
    $db = getDb();
	
    $stmt = $db->prepare("INSERT INTO polling(User_ID, User_Name, Poll, Last_Modified_Date, IP) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->execute(array($userId, $userName, $poll, $_SERVER['REMOTE_ADDR']));
    $insertId = $db->lastInsertId();
    
    $db = null;
}

function getResult(){
    $db = getDb();
    $stmt = $db->query('SELECT poll, count(1) AS total FROM polling GROUP BY poll ORDER BY poll');
 
    $ret['1'] = 0;
    $ret['2'] = 0;
    $ret['3'] = 0;
    $ret['4'] = 0;
    $ret['5'] = 0;
    $ret['6'] = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['poll']] = $row['total'];
    }
    
    $db = null;
    
    return $ret;
}
?>