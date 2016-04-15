<?php
abstract class MemberType{
    const UNAUTHORIZED = -100;
    const SUPER_ADMIN = 0;
    const L0 = 100;
    const CELEBRITIES = 200;
    const L1 = 300;
    const L2 = 400;
    const L3 = 500;
    const L4 = 600;
    
    public static function getNextType($type){
        $ret = MemberType::UNAUTHORIZED;
        switch($type){
            case MemberType::SUPER_ADMIN:
                $ret = MemberType::L0;
                break;
            case MemberType::L0:
                $ret = MemberType::L1;
                break;
            case MemberType::L1:
                $ret = MemberType::L2;
                break;
            case MemberType::L2:
                $ret = MemberType::L3;
                break;
            case MemberType::L3:
                $ret = MemberType::L4;
                break;
            case MemberType::CELEBRITIES:
                $ret = MemberType::L3;
                break;
            case MemberType::L4:
                $ret = MemberType::L4;
                break;
            case MemberType::UNAUTHORIZED:
                $ret = MemberType::L4;
                break;
        }
        return $ret;
    }
}
?>