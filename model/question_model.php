<?php

$aryParty = array(
'1' => '民主黨',
'2' => '公民黨',
'3' => '工黨',
'4' => '街工',
'5' => '民協',
'6' => '新民主同盟',
'7' => '社民連',
'8' => '人民力量',
'9' => '學民思潮',
'10' => '青年新政本民前',
'11' => '熱血公民',
'12' => '民建聯',
'13' => '工聯會',
'14' => '經民聯',
'15' => '新民黨鄉事派',
'16' => '自由黨',
'17' => '民主思路',
'18' => '新思維',
'19' => '其他',
'20' => '未決定'
);

$aryQ2 = array(
   '香港島' => $aryParty,
   '九龍東' => $aryParty,
   '九龍西' => $aryParty,
   '新界東' => $aryParty,
   '新界西' => $aryParty
);

$Q1Agree = '👌 同意';
$Q1Disagree = '🚫 No!';

$aryQ1 = array('Y' => $Q1Agree, 'N' => $Q1Disagree);

class Question{
    public $user_id;
    public $q1;
    public $q2;
    public $q3;
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
       $this->ip = $array['ip'];
       $this->create_date = $array['create_date'];
       $this->last_modified_date = $array['last_modified_date'];
    }
}
?>