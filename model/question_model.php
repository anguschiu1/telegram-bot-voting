<?php


class Question{
    public $user_id;
    public $q1;
    public $q2;
    public $q3;
    public $round;
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
       $this->q1 = $array['q1'];
       $this->q2 = $array['q2'];
       $this->q3 = $array['q3'];
       $this->round = $array['round'];
       $this->ip = $array['ip'];
       $this->create_date = $array['create_date'];
       $this->last_modified_date = $array['last_modified_date'];
    }
}
?>