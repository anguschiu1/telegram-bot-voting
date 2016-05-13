<?php
abstract class Stage{
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const AUTHORIZED = 'AUTHORIZED';
    const LANG = 'LANG';
    const Q1 = 'Q1';
    const Q2 = 'Q2';
    const Q2_CONFIRM = 'Q2_CONFIRM';
    const Q3 = 'Q3';
    const Q4 = 'Q4';
    const Q5 = 'Q5';
    const Q6 = 'Q6';
    const Q7 = 'Q7';
    const Q8 = 'Q8';
    const Q9 = 'Q9';
    const Q10 = 'Q10';
    const Q11 = 'Q11';
    const Q12 = 'Q12';
    const Q13 = 'Q13';
    const Q14 = 'Q14';
    const Q15 = 'Q15';
    const RESTART = 'RESTART';
    const DELETED = 'DELETED';
    
    public static function canChangeStage($current, $new){
        $okay = false;
        switch($new){
            case Stage::AUTHORIZED:
                $okay = ($current == Stage::UNAUTHORIZED);
                break;
            case Stage::LANG:
                $okay = ($current == Stage::AUTHORIZED);
                break;
            case Stage::Q1:
                $okay = ($current == Stage::LANG);
                break;
            case Stage::Q2:
                $okay = ($current == Stage::Q1);
                break;
            case Stage::Q3:
                $okay = ($current == Stage::Q2);
                break;
            case Stage::Q4:
                $okay = ($current == Stage::Q3 || $current == Stage::Q7);
                break;
            case Stage::Q5:
                $okay = ($current == Stage::Q4);
                break;
            case Stage::Q6:
                $okay = ($current == Stage::Q5);
                break;
            case Stage::Q7:
                $okay = ($current == Stage::Q6 || $current == Stage::Q5);
                break;
            case Stage::Q8:
                $okay = ($current == Stage::Q7 || $current == Stage::Q11);
                break;
            case Stage::Q9:
                $okay = ($current == Stage::Q8);
                break;
            case Stage::Q10:
                $okay = ($current == Stage::Q9);
                break;
            case Stage::Q11:
                $okay = ($current == Stage::Q10 || $current == Stage::Q9);
                break;
            case Stage::Q12:
                $okay = ($current == Stage::Q11);
                break;
            case Stage::Q13:
                $okay = ($current == Stage::Q12);
                break;
            case Stage::Q14:
                $okay = ($current == Stage::Q13);
                break;
            case Stage::Q15:
                $okay = ($current == Stage::Q14);
                break;
            case Stage::RESTART:
                $okay = ($current == Stage::Q15);
                break;
            case Stage::DELETED:
                $okay = true;
                break;
            default:
                $okay = false;
                break;
        }
        
        return $okay;
    }
}
?>