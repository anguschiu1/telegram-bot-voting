<?php

function getDb(){
    $db = new PDO(DB_CONNECT_STR, DB_USER_NAME, DB_PASSWORD);  //for mysql
    //$db = new PDO(DB_CONNECT_STR);  //for postgresql
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    return $db;
}


function getDistrictResult($districtKey){
    $db = getDb();
    $stmt = $db->prepare("SELECT q5 as party, count(1) AS total FROM question q, voter v WHERE v.user_id = q.user_id and v.stage in ('Q12', 'Q13', 'Q14')
                         and q4 = ? and q12 is not null GROUP BY q5 ORDER BY q5");
    $stmt->execute(array($districtKey));

    $ret = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['party']] = $row['total'];
    }
    
    $db = null;
    
    return $ret;
}

function getSuperDistrictResult(){
    $db = getDb();
    $stmt = $db->prepare("SELECT q10 as party, count(1) AS total FROM question q, voter v WHERE v.user_id = q.user_id and v.stage in ('Q12', 'Q13', 'Q14')
                         and q12 is not null GROUP BY q10 ORDER BY q10");
    $stmt->execute();

    $ret = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['party']] = $row['total'];
    }
    
    $db = null;
    
    return $ret;
}
?>