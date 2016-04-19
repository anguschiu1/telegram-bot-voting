<?php
class User{
    public $user_id;
    public $user_name;
    public $first_name;
    public $last_name;
    public $chat_id;
    public $authorized;
    public $stage;
    public $lang;
    public $member_type;
    public $ip;
    public $create_date;
    public $last_modified_date;

    function __construct(){
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
    }

    function __construct1($array) {
       $this->user_id = $array['user_id'];
       $this->user_name = $array['user_name'];
       $this->first_name = $array['first_name'];
       $this->last_name = $array['last_name'];
       $this->chat_id = $array['chat_id'];
       $this->authorized = $array['authorized'];
       $this->lang = $array['lang'];
       $this->stage = $array['stage'];
       $this->member_type = $array['member_type'];
       $this->ip = $array['ip'];
       $this->create_date = $array['create_date'];
       $this->last_modified_date = $array['last_modified_date'];
    }
}
?>