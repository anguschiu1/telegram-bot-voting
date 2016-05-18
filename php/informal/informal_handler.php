<?php
class InformalHandler{
    const WELCOME_MESSAGE = '公民聲吶會在未有正式民調既時間，推送不同的消息和進行有趣的非正式民調，重會即時將答案話番你聽。非正式民調**不需要**邀請連結，人人都玩得，快D叫朋友裝Telegram，然後用以下連結加入公民聲吶一齊玩啦！
https://telegram.me/VotSonarBot
你亦可以隨時番來，用/result睇最新結果！';
    const QUESTION1 = '非正式民調第一問（將會於 16-May 00:00 結束，距離完結還有 %s）：若果魔童在你的選區出選立法會，你會不會投票支持他？';
    const QUESTION2 = "你揀左「%s」，確定？";
    const NOT_AUTHORIZED = 'Please input "/start" to start';
    const SURVEY_RESULT = '多謝你參加！下面係「若果魔童在你的選區出選立法會，你會不會投票支持他？」的民調結果，現時總共 %d 人揀左。';

    private static $Q1_ANSWER_KEYBOARD = array('會', '不會', '考慮中', '唔想講');
    private static $Q2_ANSWER_KEYBOARD = array ('✔ 確定', '❌ 選錯了');

    public static function handleStageUnauthorized($user, $text){
        //authorize the user
        $args = explode(' ', $text);
        
        if (count($args) > 1){
            $invitation = InvitationDao::getByLink($args[1]);
            if(null !== $invitation){
                if($invitation->quota > 0){
                    $invitationUser = $invitation->useQuota($user);
                    
                    UserDao::save($user);
                    InvitationDao::save($invitation);
                    InvitationUserDao::save($invitationUser);
                    
                    handleInvitationUsedNotification($user, $invitation);
                }
                else{
                    UserDao::save($user);
                    respondLinkQuotaUsedUp($user->chat_id);
                }
            }
            else{
                UserDao::save($user);
            }
        }
        else{
            UserDao::save($user);
        }
    }

    public static function handleStageQ1($user, $questionService, $text){
        if(strlen($text) > 250) {
            respondWithMessage($user->chat_id, 'Your input is too long');
            $text = null;
        }
        else if(substr($text, 0, 1) === '/' && strpos($text, '/start') !== 0){
            $text = null;
        }

        if(null !== $text && in_array($text, self::$Q1_ANSWER_KEYBOARD)){
            if($user->changeStageToQ2()){
                if($questionService->addQ1($text)){
                    $user = InformalUserDao::save($user);
                    self::respondQ2($user->chat_id, $questionService->question);
                }
            }
        }
        else{
            if(strpos($text, '/start') !== 0){
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
            }
            InformalUserDao::save($user);
            self::respondQ1($user->chat_id);
        }
    }

    public static function handleStageQ2($user, $questionService, $text){
        $aryAgreeText = array('agree', 'ok', 'yes', self::$Q2_ANSWER_KEYBOARD[0]);
        $aryDisagreeText = array('not agree', 'no', 'nope', self::$Q2_ANSWER_KEYBOARD[1]);

        if(in_array($text, $aryAgreeText)){
            if($user->changeStageToQ3()){
                if($questionService->addQ2(ANSWER_YES)){
                    InformalUserDao::save($user);
                    self::respondResult($user->chat_id, $questionService->question);
                }
            }
        }
        else if(in_array($text, $aryDisagreeText)){
            if($user->changeStageToQ1()){
                InformalUserDao::save($user);
                self::respondQ1($user->chat_id);
            }
        }
        else{
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['INVALID_INPUT']);
            self::respondQ2($user->chat_id, $questionService->question);
        }
    }

    public static function handleStageQ3($user, $questionService, $text){
        if(strpos($text, "/result") === 0){
            self::respondResult($user->chat_id, $questionService->question);
        }
        else if(strpos($text, "/invite") === 0){
            $originalUser = UserDao::get($user->user_id);
            if($originalUser->stage !== Stage::UNAUTHORIZED){
                handleInvite($originalUser, $text);   
            }
            else{
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['ALREADY_VOTE']);
            }
        }
        else if(strpos($text, '/quota') === 0){
            $originalUser = UserDao::get($user->user_id);
            if($originalUser->stage !== Stage::UNAUTHORIZED){
                $invitationService = new InvitationService($originalUser);
                $invitation = $invitationService->getInvitation();
                respondQuotaLeft($originalUser->chat_id, $invitation);
            }
            else{
                respondWithMessage($user->chat_id, $GLOBALS['WORD']['ALREADY_VOTE']);
            }
        }
        else{
            respondWithMessage($user->chat_id, $GLOBALS['WORD']['ALREADY_VOTE']);
        }
    }

    public static function respondQ1($chat_id){
        $targetTime = strtotime("16 May 2016 00:00:00 +08:00");
        $timeDiff = ($targetTime - time())/60;
        $unit = ' 分鐘';

        if($timeDiff > 60){
            $timeDiff /= 60;
            $unit = ' 小時';


            if($timeDiff > 24){
                $timeDiff /= 24;
                $unit = ' 天';
            }
        }


        

        respondWithKeyboard($chat_id, sprintf(self::QUESTION1, number_format($timeDiff).$unit), array_chunk(self::$Q1_ANSWER_KEYBOARD, 2));
    }

    public static function respondQ2($chat_id, $questionObj){
        $answer1 = $questionObj->q1;
        respondWithKeyboard($chat_id, sprintf(self::QUESTION2, $answer1), array_chunk(self::$Q2_ANSWER_KEYBOARD, 2));
    }

    public static function respondResult($chat_id){
        $resultArray = self::getInformalResult();
        $total = array_sum($resultArray);

        $res = sprintf(self::SURVEY_RESULT, $total);
        
        $row = 0;
        foreach($resultArray as $key => $val) {
            $res .= "\n$key: $val\n";
            $count = ($val/$total * 10);
            
            for($i=0; $i < $count; $i++){
                $res .= '✅';
            }
            $res .= ' *'.floor($count * 10)."%*\n";
            $row++;
            if($row == 5){
                //res .= $GLOBALS['WORD']['SURVEY_RESULT_MORE'];
                break;
            }
        }
        respondWithMessage($chat_id, $res);
    }

    public static function respondNotAuthorized($chat_id){
        respondWithMessage($chat_id, self::NOT_AUTHORIZED);
    }



    public static function getInformalResult(){
        $db = getDb();
        $stmt = $db->prepare("SELECT q1 as answer, count(1) AS total FROM informal_question q, informal_voter v WHERE v.user_id = q.user_id and v.stage ='Q3'
                             GROUP BY q1 ORDER BY total desc");
        $stmt->execute();

        $ret = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ret[$row['answer']] = $row['total'];
        }
        
        $db = null;
        
        return $ret;
    }

}
?>