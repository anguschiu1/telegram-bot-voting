<?php
class Invitation{
    public $id;
    public $link;
    public $quota;
    public $create_user_id;
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
       $this->last_modified_date = $array['last_modified_date'];
       
       $this->originalQuota = $this->quota;
    }
    
    public function useQuota(){
        $this->quota--;
    }
}
?>