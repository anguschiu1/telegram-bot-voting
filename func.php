<?php
function isValidAge($str){
    return (preg_match("/^[1-9][0-9]{0,1}$/D", $str));
}
?>