<?php
abstract class Stage{
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const AUTHORIZED = 'AUTHORIZED';
    const Q1 = 'Q1';
    const Q2 = 'Q2';
    const Q3 = 'Q3';
    const RESTART = 'RESTART';
    const DELETED = 'DELETED';
    
    public static function canChangeStage($current, $new){
        $okay = false;
        switch($new){
            case Stage::AUTHORIZED:
                $okay = ($current == Stage::UNAUTHORIZED);
                break;
            case Stage::Q1:
                $okay = ($current == Stage::AUTHORIZED);
                break;
            case Stage::Q2:
                $okay = ($current == Stage::Q1 || $current == Stage::RESTART);
                break;
            case Stage::Q3:
                $okay = ($current == Stage::Q2);
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