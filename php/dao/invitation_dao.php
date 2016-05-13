<?php
class InvitationDao{
    
    public static function get($id){
        $db = getDb();
        $stmt = $db->prepare('SELECT id, link, quota, create_user_id, member_type, expire_date, create_date, last_modified_date FROM invitation WHERE id = ?');
        $stmt->execute(array($id));
        
        $ret = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invitation = new Invitation($row);
            return $invitation;
        }
        
        return null;
    }

    public static function create($obj){
        $db = getDb();

        $stmt = $db->prepare("INSERT INTO invitation(link, quota, create_user_id, expire_date, member_type, 
                    create_date, last_modified_date) VALUES (:link, :quota, :create_user_id, :expire_date, :member_type, NOW(), NOW())");
        $stmt->bindValue(':link', $obj->link);
        $stmt->bindValue(':quota', $obj->quota);
        $stmt->bindValue(':create_user_id', $obj->create_user_id);
        $stmt->bindValue(':member_type', $obj->member_type);
        $stmt->bindValue(':expire_date', $obj->expire_date, PDO::PARAM_INT);
        $stmt->execute();
        $insertId = $db->lastInsertId();
        
        $db = null;
        
        $obj->id = $insertId;
        
        return $obj;
    }

    public static function update($obj){
        $db = getDb();

        $stmt = $db->prepare("update invitation set link = :link , quota = :quota, 
                create_user_id = :create_user_id, expire_date = :expire_date, 
                member_type = :member_type,
                last_modified_date = NOW() 
                where id = :id and quota = :original_quota");
        $stmt->bindValue(':link', $obj->link);
        $stmt->bindValue(':quota', $obj->quota);
        $stmt->bindValue(':create_user_id', $obj->create_user_id);
        $stmt->bindValue(':member_type', $obj->member_type);
        $stmt->bindValue(':expire_date', $obj->expire_date, PDO::PARAM_INT);
        $stmt->bindValue(':id', $obj->id, PDO::PARAM_INT);
        $stmt->bindValue(':original_quota', $obj->originalQuota, PDO::PARAM_INT);
        $updated = $stmt->execute();
        
        $count = $stmt->rowCount();
        if(0 == $count){
            $invitation = self::get($obj->id);
            $invitation->link = $obj->link;
            $invitation->create_user_id = $obj->create_user_id;
            $invitation->expire_date = $obj->expire_date;
            $invitation->useQuota();
            $obj = self::update($invitation);
        }
        
        $db = null;
        
        return $obj;
    }
    
    public static function save($obj){
        if($obj->id){
            return self::update($obj);
        }
        else{
            return self::create($obj);
        }
    }
    
    public static function getByLink($link){
        $db = getDb();
        $stmt = $db->prepare('SELECT id, link, quota, create_user_id, member_type, expire_date, create_date, last_modified_date FROM invitation WHERE link = ?');
        $stmt->execute(array($link));
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invitation = new Invitation($row);
            return $invitation;
        }
        
        $db = null;
        return null;
    }
    
    public static function getByCreateUser($user_id){
        $db = getDb();
        $stmt = $db->prepare('SELECT id, link, quota, create_user_id, 
                    member_type, expire_date, create_date, last_modified_date 
                    FROM invitation 
                    WHERE create_user_id = ?');
        $stmt->execute(array($user_id));
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invitation = new Invitation($row);
            return $invitation;
        }
        
        return null;
    }
}
?>