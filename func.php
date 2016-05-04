<?php
abstract class Func{

    public static function isValidAge($str){
        return (preg_match("/^[1-9][0-9]{0,1}$/D", $str));
    }

    public static function addAuditLog($content){
        $db = getDb();


        $stmt = $db->prepare("insert into audit_log (message, create_date, last_modified_date) values (:message, now(), now())");
        $stmt->bindValue(':message', $content);
        $stmt->execute();
        
        $db = null;
    }
}
?>