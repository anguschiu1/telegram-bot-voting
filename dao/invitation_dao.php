<?php
class InvitationDao{
    
    public static function get($id){
        $db = getDb();
        $stmt = $db->prepare('SELECT id, link, quota, create_user_id, expire_date, create_date, last_modified_date FROM invitation WHERE id = ?');
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

        $stmt = $db->prepare("INSERT INTO invitation(link, quota, create_user_id, expire_date, create_date, last_modified_date) VALUES (?, ?, ?, FROM_UNIXTIME(?), NOW(), NOW())");
        $stmt->execute(array($obj->link, $obj->quota, $obj->create_user_id, $obj->expire_date));
        $insertId = $db->lastInsertId();
        
        $db = null;
        
        $obj->id = $insertId;
        
        return $obj;
    }

    public static function update($obj){
        $db = getDb();

        $stmt = $db->prepare("update invitation set link = ? , quota = ?, create_user_id = ?, expire_date = FROM_UNIXTIME(?), last_modified_date = NOW() where id = ? and quota = ?");
        $updated = $stmt->execute(array($obj->link, $obj->quota, $obj->create_user_id, $obj->expire_date, $obj->id, $obj->originalQuota));
        
        $count = $stmt->rowCount;
        $affected = $count?"T":"F";
        print "Affected row: $updated, $count, $affected. Quota : $obj->quota, original: $obj->originalQuota<BR>";
        if(false){
            print "Reloading<BR>";
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
        $stmt = $db->prepare('SELECT id, link, quota, create_user_id, expire_date, create_date, last_modified_date FROM invitation WHERE link = ? and quota > 0');
        $stmt->execute(array($link));
        
        $ret = null;
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $invitation = new Invitation($row);
            return $invitation;
        }
        
        $db = null;
        return null;
    }
}
?>