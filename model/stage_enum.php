<?php
abstract class Stage{
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const AUTHORIZED = 'AUTHORIZED';
    const LANG = 'LANG';
    const Q1 = 'Q1';
    const Q2 = 'Q2';
    const Q2_CONFIRM = 'Q2_CONFIRM';
    const Q3 = 'Q3';
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
                $okay = ($current == Stage::Q1 || $current == Stage::Q2_CONFIRM);
                break;
            case Stage::Q2_CONFIRM:
                $okay = ($current == Stage::Q2 || $current == Stage::RESTART);
                break;
            case Stage::Q3:
                $okay = ($current == Stage::Q2_CONFIRM);
                break;
            case Stage::RESTART:
                $okay = ($current == Stage::Q3);
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