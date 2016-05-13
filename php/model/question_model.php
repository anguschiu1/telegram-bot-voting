<?php


class Question{
    public $user_id;
    public $q1;
    public $q2;
    public $q3;
    public $q4;
    public $q5;
    public $q6;
    public $q7;
    public $q8;
    public $q9;
    public $q10;
    public $q11;
    public $q12;
    public $q13;
    public $q14;
    public $q15;
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
       $this->q4 = $array['q4'];
       $this->q5 = $array['q5'];
       $this->q6 = $array['q6'];
       $this->q7 = $array['q7'];
       $this->q8 = $array['q8'];
       $this->q9 = $array['q9'];
       $this->q10 = $array['q10'];
       $this->q11 = $array['q11'];
       $this->q12 = $array['q12'];
       $this->q13 = $array['q13'];
       $this->q14 = $array['q14'];
       $this->q15 = $array['q15'];
       $this->round = $array['round'];
       $this->ip = $array['ip'];
       $this->create_date = $array['create_date'];
       $this->last_modified_date = $array['last_modified_date'];
    }
}
?>