<?php
class InvitationService{
    private $invitation;
    private $user;
    
    function __construct($user){
        $this->user = $user;
        $this->invitation = InvitationDao::getByCreateUser($this->user->user_id);
    }
    
    private static function generateInvitation($create_user_id, $quota){
        $invitation = new Invitation();
        $invitation->link = self::generateRandomString();
        $invitation->quota = $quota;
        $invitation->create_user_id = $create_user_id;
        $invitation->expire_date = date('Y-m-d', strtotime('+1 month')) ; //time() * 1000 + (31 + 24 * 60 * 60); // expire after 1 month
        
        return $invitation;
    }

    private static function getQuota($level){
        $ret = 0;
        switch(intval($level)){
            case 1:
                $ret = 100;
                break;
            case 2:
                $ret = 30;
                break;
            case 3:
                $ret = 10;
                break;
        }
        return $ret;
    }

    private static function generateRandomString($length = 14) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    private function createInvitation(){
        $quota = self::getQuota($this->user->level);
        if($quota > 0){
            $this->invitation = self::generateInvitation($this->user->user_id, $quota);
            
            $this->invitaiton = InvitationDao::save($this->invitation);
        }
    }

    public function getInvitation(){
        if(null == $this->invitation){
            $this->createInvitation();
        }
        return $this->invitation;
    }
    
    public function hasGenerated(){
        return $this->invitation != null;
    }
    
    public function canGenerate(){
        return $this->user->level == 0 || (self::getQuota($this->user->level) > 0 && !$this->hasGenerated());
    }
}
?>