<?php
class InvitationService{
    public $invitation;
    private $user;
    
    function __construct($user){
        $this->user = $user;
        $this->invitation = InvitationDao::getByCreateUser($this->user->user_id);
    }
    
    private static function generateInvitation($create_user_id, $member_type, $quota){
        $invitation = new Invitation();
        $invitation->link = self::generateRandomString();
        $invitation->quota = $quota;
        $invitation->create_user_id = $create_user_id;
        $invitation->member_type = $member_type;
        $invitation->expire_date = date('Y-m-d', strtotime('+1 month')) ; //time() * 1000 + (31 + 24 * 60 * 60); // expire after 1 month
        
        return $invitation;
    }

    private static function getQuota($member_type){
        $ret = 0;
        switch($member_type){
            case MemberType::SUPER_ADMIN:
                $ret = 1;
                break;
            case MemberType::L0:
                $ret = 1;
                break;
            case MemberType::L1:
                $ret = 100;
                break;
            case MemberType::L2:
                $ret = 30;
                break;
            case MemberType::L3:
                $ret = 10;
                break;
            case MemberType::L4:
                $ret = 5;
                break;
            case MemberType::CELEBRITIES:
                $ret = 50;
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

    public static function getFullLink($invitation){
        return INVITATION_LINK_PREFIX.$invitation->link;
    }

    public function createOneInivitationLink($member_type){
        $this->invitation = self::generateInvitation($this->user->user_id, $member_type, 1);
        $this->invitaiton = InvitationDao::save($this->invitation);
    }
    
    public function createInvitation($member_type){
        $quota = self::getQuota($member_type);
        if($quota > 0){
            $this->invitation = self::generateInvitation($this->user->user_id, MemberType::getChildType($member_type), $quota);
            
            $this->invitaiton = InvitationDao::save($this->invitation);
        }
    }

    public function getInvitation(){
        if(null == $this->invitation){
            $this->createInvitation($this->user->member_type);
        }
        return $this->invitation;
    }
    
    public function hasGenerated(){
        return $this->invitation != null;
    }
    
    public function canGenerate(){
        return $this->user->member_type == MemberType::SUPER_ADMIN ||
            $this->user->member_type == MemberType::L0 || 
            (self::getQuota($this->user->member_type) > 0 && !$this->hasGenerated());
    }
}
?>