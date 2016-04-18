<?php
class QuestionDao{
    
    public static function get($id){
        $db = getDb();
        $stmt = $db->prepare('SELECT user_id, q1, q2, q3, ip, create_date, last_modified_date FROM question WHERE user_id = ?');
        $stmt->execute(array($id));
        
        $ret = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $question = new Question($row);
            return $question;
        }
        
        return null;
    }

    public static function create($obj){
        $db = getDb();
        
        $stmt = $db->prepare("INSERT INTO question(user_id, q1, q2, q3, ip, create_date, last_modified_date) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute(array($obj->user_id, $obj->q1, $obj->q2, $obj->q3, $_SERVER['REMOTE_ADDR']));
                
        $obj->create_date = time();
        
        $db = null;
        
        return $obj;
    }
    
    public static function updateSingle($obj, $questionNum, $answer){
        $ip =  $_SERVER['REMOTE_ADDR'];
        switch($questionNum){
            case 1:
                $obj->q1 = $answer;
                break;
            case 2:
                $obj->q2 = $answer;
                break;
            default:
                $obj->q3 = $answer;
                break;
        }
        return self::update($obj);
    }

    public static function update($obj){
        $db = getDb();

        
        $stmt = $db->prepare("update question set q1 = ? , q2 = ?, q3 = ?, ip = ?, last_modified_date = NOW() where user_id = ?");
        $stmt->execute(array($obj->q1, $obj->q2, $obj->q3, $_SERVER['REMOTE_ADDR'], $obj->user_id));
        
        $db = null;
        
        return $obj;
    }
    
    public static function save($obj){
        if($obj->create_date){
            return self::update($obj);
        }
        else{
            return self::create($obj);
        }
    }
}
?>