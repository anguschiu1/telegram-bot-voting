<?php
class Invitation{
    public $id;
    public $link;
    public $quota;
    public $create_user_id;
    public $member_type;
    public $expire_date;
    public $create_date;
    public $last_modified_date;
    
    public $originalQuota;

    function __construct(){
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    function __construct1($array) {
       $this->id = $array['id'];
       $this->link = $array['link'];
       $this->quota = $array['quota'];
       $this->create_user_id = $array['create_user_id'];
       $this->expire_date = $array['expire_date'];
       $this->create_date = $array['create_date'];
       $this->member_type = $array['member_type'];
       $this->last_modified_date = $array['last_modified_date'];
       
       $this->originalQuota = $this->quota;
    }
    
    public function useQuota($user){
        $this->quota--;
        
        $user->authorized = 'Y';
        $user->member_type = $invitation->member_type;
        $user->stage = Stage::AUTHORIZED;
            
        $invitationUser = new InvitationUser();
        $invitationUser->invitation_id = $invitation->id;
        $invitationUser->user_id = $user->user_id;
        
        return $invitationUser;
    }
}
?>