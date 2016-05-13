<?php
class InvitationUserDao{

    public static function save($obj){
        $db = getDb();

        $stmt = $db->prepare("INSERT INTO invitation_user(invitation_id, user_id, create_date, last_modified_date) VALUES (?, ?, NOW(), NOW())");
        $stmt->execute(array($obj->invitation_id, $obj->user_id));
        $insertId = $db->lastInsertId();
        
        $db = null;
        
        $obj->id = $insertId;
        
        return $obj;
    }
}
?>