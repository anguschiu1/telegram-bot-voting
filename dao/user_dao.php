<?php
class UserDao{
    
    public static function get($id){
        $db = getDb();
        $stmt = $db->prepare('SELECT user_id, user_name, first_name, last_name, chat_id, member_type, ip, authorized, create_date, last_modified_date FROM voter WHERE user_id = ?');
        $stmt->execute(array($id));
        
        $ret = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row);
            return $user;
        }
        
        return null;
    }

    public static function create($obj){
        $db = getDb();
        
        $stmt = $db->prepare("INSERT INTO voter(user_id, user_name, first_name, last_name, chat_id, member_type, authorized, ip, create_date, last_modified_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute(array($obj->user_id, $obj->user_name, $obj->first_name, $obj->last_name, 
                $obj->chat_id, $obj->member_type, $obj->authorized, $_SERVER['REMOTE_ADDR']));
                
        $obj->create_date = time();
        
        $db = null;
        
        return $obj;
    }

    public static function update($obj){
        $db = getDb();

        $stmt = $db->prepare("update voter set user_name = ? , first_name = ?, last_name = ?, chat_id = ?, member_type = ? , authorized = ?, ip = ?, last_modified_date = NOW() where user_id = ?");
        $stmt->execute(array($obj->user_name, $obj->first_name, $obj->last_name, $obj->chat_id, 
            $obj->member_type, $obj->authorized, $_SERVER['REMOTE_ADDR'], $obj->user_id));
        
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