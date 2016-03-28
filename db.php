<?php

function getDb(){
    //$db = new PDO(DB_CONNECT_STR, DB_USERNAME, DB_PASSWORD);  //for mysql
    $db = new PDO(DB_CONNECT_STR);  //for postgresql
    
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

function getUser($userId){
    $db = getDb();
    $stmt = $db->prepare('SELECT id, user_Id, user_name, first_name, last_name, ip FROM voter WHERE user_id = ?');
    $stmt->execute(array($userId));
    
    $ret['user_id'] = $userId;
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret['id'] = $row['id'];
        $ret['user_name'] = $row['user_name'];
        $ret['first_name'] = $row['first_name'];
        $ret['last_name'] = $row['last_name'];
        $ret['ip'] = $row['ip'];
    }
    
    return $ret;
}

function createUser($userId, $userName, $firstName, $lastName){
    $db = getDb();

    $stmt = $db->prepare("INSERT INTO voter(user_id, user_name, first_name, last_name, ip, create_date, last_modified_date) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute(array($userId, $userName, $firstName, $lastName, $_SERVER['REMOTE_ADDR']));
    $insertId = $db->lastInsertId();
    
    $db = null;
}

function isUserChanged($userArray, $userId, $userName, $firstName, $lastName, $ip){
    return ($userArray['user_id'] != $userId ||
        $userArray['user_name'] !== $userName ||
        $userArray['first_name'] !== $firstName ||
        $userArray['last_name'] !== $lastName ||
        $userArray['ip'] !== $ip
        );
}

function updateUser($userArray, $userId, $userName, $firstName, $lastName){
    $ip =  $_SERVER['REMOTE_ADDR'];
    if(isUserChanged($userArray, $userId, $userName, $firstName, $lastName, $ip)){
        $db = getDb();

        $stmt = $db->prepare("update voter set user_name = ? , first_name = ?, last_name = ?, ip = ?, last_modified_date = NOW() where user_id = ?");
        $stmt->execute(array($userName, $firstName, $lastName, $ip, $userId,));
        $insertId = $db->lastInsertId();
        
        $db = null;
        return $insertId;
    }
    
    return -1;
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