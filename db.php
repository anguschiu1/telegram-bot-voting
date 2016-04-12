<?php

function getDb(){
    $db = new PDO(DB_CONNECT_STR, DB_USER_NAME, DB_PASSWORD);  //for mysql
    //$db = new PDO(DB_CONNECT_STR);  //for postgresql
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $db;
}

function getQuestion($userId){
    $db = getDb();
    $stmt = $db->prepare('SELECT q1, q2, q3, ip FROM question WHERE user_id = ?');
    $stmt->execute(array($userId));
    
    $ret = null;
    if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret['user_id'] = $userId;
        $ret['q1'] = $row['q1'];
        $ret['q2'] = $row['q2'];
        $ret['q3'] = $row['q3'];
        $ret['ip'] = $row['ip'];
    }
    
    return $ret;
}

function createQuestion($userId, $q1, $q2, $q3){
    $db = getDb();

    $stmt = $db->prepare("INSERT INTO question(user_id, q1, q2, q3, ip, create_date, last_modified_date) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute(array($userId, $q1, $q2, $q3, $_SERVER['REMOTE_ADDR']));
    
    $db = null;
}

function isQuestionChanged($questionArray, $userId, $q1, $q2, $q3, $ip){
    return ($questionArray['q1'] !== $q1 ||
        $questionArray['q2'] !== $q2 ||
        $questionArray['q3'] !== $q3 ||
        $questionArray['ip'] !== $ip
        );
}

function updateQuestion($questionArray, $userId, $q1, $q2, $q3){
    $ip =  $_SERVER['REMOTE_ADDR'];
    if(isQuestionChanged($questionArray, $userId, $q1, $q2, $q3, $ip)){
        $db = getDb();

        $stmt = $db->prepare("update question set q1 = ? , q2 = ?, q3 = ?, ip = ?, last_modified_date = NOW() where user_id = ?");
        $stmt->execute(array($q1, $q2, $q3, $ip, $userId,));
        
        $db = null;
    }
}
function updateSingleQuestion($questionArray, $userId, $question, $answer){
    $ip =  $_SERVER['REMOTE_ADDR'];
    $q1 = $questionArray['q1'];
    $q2 = $questionArray['q2'];
    $q3 = $questionArray['q3'];
    switch($question){
        case 1:
            $q1 = $answer;
            break;
        case 2:
            $q2 = $answer;
            break;
        default:
            $q3 = $answer;
            break;
    }
    if(isQuestionChanged($questionArray, $userId, $q1, $q2, $q3, $ip)){
        $db = getDb();

        $stmt = $db->prepare("update question set q1 = ? , q2 = ?, q3 = ?, ip = ?, last_modified_date = NOW() where user_id = ?");
        $stmt->execute(array($q1, $q2, $q3, $ip, $userId,));
        
        $db = null;
    }
}

function getResult($q2){
    $db = getDb();
    $stmt = $db->prepare('SELECT q3, count(1) AS total FROM question WHERE q2 = ? GROUP BY q3 ORDER BY q3');
    $stmt->execute(array($q2));

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['q3']] = $row['total'];
    }
    
    $db = null;
    
    print_r($ret);
    return $ret;
}
?>